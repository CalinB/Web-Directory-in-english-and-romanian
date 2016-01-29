<?php

namespace Directory;

class Acl {

	protected $table = 'access';
	
	public function isSuperAdmin()
	{
		if(\Auth::check())
		{	
			if(\Auth::user()->type == \User::ADMIN_USER)
			{
				return true;
			}
		}
		
		return false;
	}
	
	public function addAdmin($entity)
	{
		if(\Auth::check())
		{
			if(is_object($entity))
			{
				$acl = new \Access();

				$acl->user_id = \Auth::user()->id;
				$acl->entity_name = get_class($entity);
				$acl->entity_id = $entity->id;

				$acl->save();
                                
                                return;
			}
		}
		
		return;
	}
	
	public function isAdmin($entity)
	{
		if(\Auth::check())
		{
			if(\Acl::isSuperAdmin())
			{
				return true;
			}

			if(is_object($entity))
			{
				return \Access::where('user_id', \Auth::user()->id)
						->where('entity_name', get_class($entity))
						->where('entity_id', $entity->id)->count();
			}
		}
		return false;
	}
	
	public function deleteAdmin()
	{
		\Access::where('user_id', \Auth::user()->id)->delete();
		
		return;
	}

	public function isAdminFilter($entity_name, $entity_id)
	{
		if(\Auth::check())
		{
			if(\Acl::isSuperAdmin())
			{
				return true;
			}

			return \Access::where('user_id', \Auth::user()->id)
					->where('entity_name', $entity_name)
					->where('entity_id', $entity_id)->count();
		}
		
		return false;
	}
	
	public function getAdminEntitiesIDs($entity_name)
	{
		if(\Auth::check())
		{
			return array_flatten(\Access::where('user_id', \Auth::user()->id)
					->where('entity_name', $entity_name)
					->get(['entity_id'])
					->toArray());
		}
		
		return [];
	}
	
	/**
	 * @param int $selected ( $category->parent() for selected option )
	 * @return string
	 */
	public function renderCategoryHTMLSelect($selected = null)
	{
		$option_selected = ( ! isset($selected)) ? 'selected="selected"' : '';
		
		$roots = \Category::roots()->get();

		$select = '<select name="parent_id">';
		$select .= '<option value="0"' . $option_selected . '>' . trans('general.choose') . '</option>';
		
		foreach ($roots as $root)
		{
//			if(self::isAdmin($root) || $root->status == 1)
//			{
				$select .= self::renderNodeHTMLSelect($root, $selected);
//			}
		}
		
		$select .= '</select>';
		
		return $select;
	}
	
	public function renderNodeHTMLSelect($node, $selected)
	{		
		$res = '';
		$option_selected = '';
		
		if(isset($selected))
		{	
			$parent = $selected->parent()->pluck('id');
			
			if($parent == $node->id)
			{
				$option_selected = 'selected="selected"';
			}	
		}
		
//		if(self::isAdmin($node) || $node->status == 1)
//		{
			$status = ( ! $node->status) ? 'color:red;' : '';
			
			$res = '<option ' . $option_selected . ' value="' . $node->id . '" style="text-indent:' . $node->depth . 'em; ' . $status . '">';
			$res .= ($node->isRoot()) ? '&rarr;' : '&uarr;';
			$res .= $node->name;
			$res .= '</option>';
//		}
		
//		if(self::isAdmin($node) || $node->status == 1)
//		{
			if ($node->children()->count() > 0)
			{
				foreach ($node->children as $child)
				{	
					if(self::isAdmin($child) || $child->status == 1)
					{
						$res .= self::renderNodeHTMLSelect($child, $selected);
					}
				}
			}
//		}
		
		return $res;
	}

	// pentru add site
	public function categorySelect($selected = null)
	{
		$roots = \Category::roots()->get();
		
		$option_selected = ( ! isset($selected)) ? 'selected="selected"' : '';

		$select = '<select name="category_id">';
		$select .= '<option value="0"' . $option_selected . '>' . trans('general.choose') . '</option>';
		
		foreach ($roots as $root)
		{
//			if($root->status == 1 || self::isAdmin($root))
//			{
				$select .= self::subcategorySelect($root, $selected);
//			}
		}
		
		$select .= '</select>';
		
		return $select;
	}
	
	public function subcategorySelect($node, $selected)
	{		
		$res = '';
		
		$status = ($node->status == 0) ? 'color:red;' : '';
		
//		if($node->status == 1 || self::isAdmin($node))
//		{			
			$res .= '<option ';
			$res .= ($node->id == $selected) ? 'selected="selected"' : '';
			$res .= ' value="' . $node->id . '" style="text-indent:' . $node->depth . 'em;' . $status . '">';

			$res .= ($node->isRoot()) ? '&rarr;' : '&uarr;';

			$res .= $node->name . '</option>';
		
			if ($node->children()->count() > 0)
			{
				foreach ($node->children as $child)
				{	
//					if($child->status == 1 || self::isAdmin($child))
//					{
						$res .= self::subcategorySelect($child, $selected);
//					}
				}
			}
//		}
		
		return $res;
	}
	
	
	public function renderNodeHTMLTree($node)
	{
		$status = ( ! $node->status) ? 'red' : '';

		$row = '<tr><td class="' . $status . '">';

		if($node->isRoot()) 
		{
			$row .= '&nbsp;<span  style="margin-left:' . $node->depth . 'em;" class="glyphicon glyphicon-arrow-right"></span>';
		} 
		else 
		{ 
			$row .= '&nbsp;<span style="margin-left:' . $node->depth . 'em;" class="glyphicon glyphicon-arrow-up"></span>';
		}

		$row .= '&nbsp;<a class="' . $status . '" href="' . \URL::route('category.details', [$node->path]) . '">' . $node->name . '</a> '
				. '&nbsp;<a class="turquoise" href="' . \URL::route('domain.list', [$node->id]) . '">[ ' . count($node->domains) . ' ]</a>';

		if(self::isAdmin($node))
		{
			$row .= ' <a href="' . \URL::route('category.edit', [$node->id]) . '"> 
				&nbsp;<span class="glyphicon glyphicon-edit"></span>
			</a>';	
		}	
		if(self::isSuperAdmin())
		{
			$row .= ' <a onclick="alert(\'Sure?\');" href="' . \URL::route('category.delete', [$node->id]) . '"> 
					&nbsp;<span class="glyphicon glyphicon-trash"></span>								
				</a>';
			if($node->status == 0)
			{	
				$row .= ' <a href="' . \URL::route('category.approve', [$node->id]) . '"> 
						&nbsp;<span class="glyphicon glyphicon-ok"></span>
					</a>';
			}
			else
			{	
				$row .= ' <a href="' . \URL::route('category.disapprove', [$node->id]) . '">
						&nbsp;<span class="glyphicon glyphicon-remove"></span>
					</a>';
			}
			
		}

		$row .= '</td></tr>';
		
		if( ! \Auth::check())
		{
			if($node->status == 1)
			{
				if ($node->children()->count() > 0)
				{
					foreach ($node->children as $child)
					{
						if($child->status == 1)
						{	
							$row .= self::renderNodeHTMLTree($child);	
						}
					}
				}
				
			}	
		}
		else 
		{
			if($node->children()->count() > 0)
			{	
				foreach ($node->children as $child)
				{
					$row .= self::renderNodeHTMLTree($child);				
				}
			}
		}
		
		return $row;
	}
		
	public function renderCategoryHTMLTree()
	{
		$roots = \Category::roots()->get();
		
		$table = '<table>';
		
		foreach ($roots as $root)
		{	
			if( ! \Auth::check())
			{	
				if($root->status == 1)
				{
					$table .= self::renderNodeHTMLTree($root);
				}
			}	
			else
			{
				$table .= self::renderNodeHTMLTree($root);
			}		
		}
		
		$table .= '</table>';
		
		return $table;
	}
}
