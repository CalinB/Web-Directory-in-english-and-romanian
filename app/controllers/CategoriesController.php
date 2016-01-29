<?php

class CategoriesController extends BaseController {

	public function listCategories()
	{		
		$categories = Category::getCategories();

		return View::make('categories.index')->with(compact('categories'));
	}
	
	public function details($path)
	{
		$category = Category::where('path', $path)->first();
		
		$catgory_domains = $category->domains()->paginate(4);
		
		return View::make('categories.details')->with(compact('category', 'catgory_domains'));
	}
	
	public function create()
	{
		$categories = Category::getCategories();
		
		return View::make('categories.create')->with(compact('categories'));
	}
	
	public function createHandle()
	{
		$path = DirectoryHelpers::seoString(e(Input::get('path')));
		
		$nice_input_names = [
			'is_root' => trans('directory.is_root'),			
			'name' => trans('directory.name'),
			'path' => trans('directory.path'),			
			'description' => trans('directory.description'),
			'keywords' => trans('directory.keywords')
		];
		$rules = [
			'is_root' => 'required',			
			'name' => 'required|between:2,50|unique:categories',
			'path' => 'required|between:2,50|unique:categories',			
			'description' => 'between:5,1000',
			'keywords' => 'between:5,255'
		];
		
		$is_root = Input::get('is_root');
		
		if('no' == $is_root)
		{
			$nice_input_names['parent_id'] = trans('directory.parent');
			$rules['parent_id'] = 'not_in:0';
		}
		
		$validator = Validator::make(Input::all(), $rules, [], $nice_input_names);
		
		if($validator->fails())
		{
			return Redirect::route('category.create')->withErrors($validator)->withInput();
		}
		
		try
		{			
			if('yes' == $is_root)
			{
				$status = (Acl::isSuperAdmin()) ? 1 : 0;
					
				$node = Category::create([
					'status' => $status,
					'name' => e(Input::get('name')),
					'slug' => $path,
					'path' => $path,
					'description' => e(Input::get('description')),
					'keywords' => e(Input::get('keywords'))
				])->makeRoot();
			}
			
			if('no' == $is_root)
			{				
				$parent = Category::find(e(Input::get('parent_id')));
				
				$node = Category::create([
					'status' => $status,
					'name' => e(Input::get('name')),
					'slug' => $path,
					'path' => $path,
					'description' => e(Input::get('description')),
					'keywords' => e(Input::get('keywords')),
				])->makeChildOf($parent);
			}
			
			Acl::addAdmin($node);
			
			return Redirect::route('category.create')->with('success', Lang::get('directory.category_added', ['name' => Input::get('name')]));
		} 
		catch (Exception $ex)
		{
			return Redirect::route('category.create')->withErrors($ex->getMessage())->withInput();
		}
	}	
	
	public function approveHandle($id)
	{
		$category = Category::find($id);
		
		$category->status = 1;
		
		if($category->save())
		{
			return Redirect::back()->with('success', trans('directory.category_approve'));
		}	
	}
	
	public function disapproveHandle($id)
	{
		$category = Category::find($id);
		
		$category->status = 0;
		
		if($category->save())
		{
			return Redirect::back()->with('success', trans('directory.category_disabled'));
		}	
	}
	
	public function edit($id)
	{
		$category = Category::find($id);
		
		$categories = Category::getCategories();
		
		return View::make('categories.edit')->with(compact('category', 'categories'));
	}
	
	public function editHandle()
	{
		$id = e(Input::get('id'));		
		
		$category = Category::find($id);

		$path = DirectoryHelpers::seoString(e(Input::get('path')));

		$nice_input_names = [
			'is_root' => trans('directory.is_root'),			
			'name' => trans('directory.name'),
			'path' => trans('directory.path'),			
			'description' => trans('directory.description'),
			'keywords' => trans('directory.keywords')
		];
		$rules = [
			'is_root' => 'required',			
			'name' => 'required|between:2,50|unique:categories,name,' . $id,
			'path' => 'required|between:2,50|unique:categories,path,' . $id,			
			'description' => 'between:5,1000',
			'keywords' => 'between:5,255'
		];

		$is_root = Input::get('is_root');

		if('no' == $is_root)
		{
			$nice_input_names['parent_id'] = trans('directory.parent');
			
			if($id == Input::get('parent_id'))
			{
				//return Redirect::route('category.edit', [$id])->with('error', trans('directory.same_category_choosen'))->withInput();
			}
		}

		$validator = Validator::make(Input::all(), $rules, [], $nice_input_names);

		if($validator->fails())
		{
			return Redirect::route('category.edit', [$id])->withErrors($validator)->withInput();
		}
		
		$status = (Acl::isSuperAdmin()) ? 1 : 0;
		
		$category->update([
			'status' => $status,
			'name' => e(Input::get('name')),
			'slug' => $path,
			'path' => $path,
			'description' => e(Input::get('description')),
			'keywords' => e(Input::get('keywords'))
		]);
		
		try
		{
			if('yes' == $is_root)
			{
				$category->makeRoot();
			}

			if('no' == $is_root)
			{
				$parent = Category::find(e(Input::get('parent_id')));
				
				if($id != Input::get('parent_id') && !$parent->isDescendantOf($category))
				{
					$category->makeChildOf($parent);
				}
			}
			
			return Redirect::route('category.edit', [$id])->with('success', Lang::get('directory.category_updated', ['category' => $category->name]));
		} 
		catch (Exception $ex)
		{
			dd($ex->getMessage());
			return Redirect::route('category.edit', [$id])->withErrors($ex->getMessage())->withInput();
		}
		
	}
	
	public function delete($id)
	{
		return $this->deleteHandle($id);
	}
	
	public function deleteHandle($id)
	{
		try 
		{
			$category = Category::find($id);
		
			$category->delete();
			
			return Redirect::route('category.list')->with('success', 'Categorie stearsa!');
		} 
		catch (Exception $ex) 
		{
			return Redirect::route('category.list')->withErrors($ex->getMessage());
		}
		
	}
}
