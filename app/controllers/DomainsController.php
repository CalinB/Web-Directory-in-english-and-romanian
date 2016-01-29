<?php

use \Carbon\Carbon;

class DomainsController extends BaseController {
	
	public function listDomains($category_id = NULL)
	{		
		$sort_by = e(Input::get('sort_by'));
		
		switch($sort_by)
		{
			case 'newest':
				$field = 'created_at';
				$direction = 'DESC';
				break;
			case 'oldest':
				$field = 'created_at';
				$direction = 'ASC';
				break;
			case 'page_rank':
				$field = 'page_rank';
				$direction = 'DESC';
				break;
			case 'most_viewed':
				$field = 'hits';
				$direction = 'DESC';
				break;
			case 'most_upvoted':
				$field = 'votes_up';
				$direction = 'DESC';
				break;
			default:
				$field = 'created_at';
				$direction = 'DESC';
				break;
		}
		
		$domains = Domain::where('status', 1);		
		
		if(isset($category_id))
		{
			$domains = $domains->where('category_id', $category_id);
		}
		
		$domains = $domains->orderBy($field, $direction)->paginate(8)->appends(compact('sort_by'));
		
		return View::make('domains.index')->with(compact('domains', 'sort_by'));
	}
	
	public function details($name, $id)
	{
		$domain = Domain::find($id);
		
		if( !is_object($domain))
		{
			return Redirect::route('home');
		}	
				
		if( ! Acl::isSuperAdmin())
		{	
			if( ! $domain->status)
			{
				return Redirect::route('home');
			}	
		}
		
		$pr = DirectoryHelpers::getPagerank($domain->url);
		
		if($pr)
		{
			$domain->page_rank = $pr;
		}	
		
		if( ! SiteViewer::viewerExists($id))
		{
			$domain->increment('hits');
			
			$site_viewers = new SiteViewer();
			
			$site_viewers->domain_id = $id;
			$site_viewers->ip = Request::instance()->getClientIp();
			
			$site_viewers->save();
		}
		
		if( ! $domain->thumb || empty($domain->thumb))
		{	
			try {
				$domain->thumb = $domain->thumb ? $domain->thumb : DirectoryHelpers::generateThumb($domain->url);
			} catch (Exception $ex) {
				Log::error($ex->getMessage());
			}		
		}	
		
		$domain->save();
		
		$category = Category::find($domain->category_id);
		
		return View::make('domains.details')->with(compact('domain', 'category'));
	}
	
	public function create()
	{	
		$categories_select[0] = trans('general.choose');
		
		$approved_categories = Category::where('status', 1)->get();
		
		if( ! empty($approved_categories))
		{
			foreach($approved_categories as $category)
			{	
				$categories_select[$category->id] = $category->name;
			}	
		}
		
		return View::make('domains.create')->with(compact('categories_select'));
	}
	
	public function createHandle()
	{		
		$pr = DirectoryHelpers::getPagerank(e(Input::get('url')));
		
		$valid_domain = function($domain_name)
		{
				return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
						&& preg_match("/^.{1,253}$/", $domain_name) //overall length check
						&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label	
		};
		
		$format_url = rtrim(str_replace(['http://', 'https://'], '', e(Input::get('url'))), '/');
		
		if( ! $valid_domain($format_url))
		{
			Session::put('category_id', e(Input::get('category_id')));
			
			return Redirect::back()->with('url_error', trans('directory.invalid_url'))->withInput();
		}		
		
		$url_details = parse_url(e(Input::get('url')));
		
		$final_url = isset($url_details['scheme']) ? $url_details['scheme'] . '://' . $format_url : 'http://'. $format_url;
		
		Input::merge(array('url' => $final_url));
		
		$nice_input_names = [	
			'category_id' => trans('directory.select_category'),
			'name' => trans('directory.name'),
			'url' => trans('directory.url'),			
			'format_url' => trans('directory.url'),			
			'description' => trans('directory.description'),
			'keywords' => trans('directory.keywords')
		];

		$rules = [	
			'category_id' => 'not_in:"0"',
			'name' => 'required|between:6,260',
			'url' => 'required|url|between:6,100|unique:domains',
			'description' => 'required|between:200,1000',
			'keywords' => 'between:5,255'
		];
		
		if( ! Auth::check())
		{
			$nice_input_names['g-recaptcha-response'] = 'captcha';
			$rules['g-recaptcha-response'] = 'required|recaptcha';
		}
		
		$coma_replace = function($string) 
		{
			return str_replace(',', ', ', $string);
		};
		
		if(strlen(str_replace(' ', '', e(Input::get('description')))) < 200 && Auth::user()->type != User::ADMIN_USER)
		{
			$attempt = new Attempt();
			$attempt->user_id = Auth::check() ? Auth::user()->id : null;
			$attempt->category_id = (int)e(Input::get('category_id'));			
			$attempt->url = 'http://'. $format_url;
			$attempt->name = e(Input::get('name'));
			$attempt->description = $coma_replace(DirectoryHelpers::correctText(e(Input::get('description')), '.'));
			$attempt->keywords = $coma_replace(e(Input::get('keywords')));
			$attempt->save();
			
			return Redirect::back()->with('error', 'Descrierea este prea scurt&#259;')->withInput();
		}	
		
		$validator = Validator::make(array_map('trim', Input::all()), $rules, [], $nice_input_names);		
		
		if($validator->fails())
		{
			Session::put('category_id', e(Input::get('category_id')));
                        
			return Redirect::back()->withErrors($validator)->withInput();
		}	
        
		$status = (Acl::isSuperAdmin()) ? 1 : 0;		
		
		$domain = new Domain();
		$domain->category_id = (int)e(Input::get('category_id'));
		$domain->status = $status;
		$domain->name = $coma_replace(e(Input::get('name')));
		$domain->url = 'http://'. $format_url;
		$domain->page_rank = $pr;		
		$domain->description = $coma_replace(DirectoryHelpers::correctText(e(Input::get('description')), '.'));
		$domain->keywords = $coma_replace(e(Input::get('keywords')));
		
		try {
			$domain->thumb = DirectoryHelpers::generateThumb($domain->url);
		} catch (Exception $ex) {
			Log::error($ex->getMessage());
		}		
		
		if($domain->save())
		{
			Acl::addAdmin($domain);
			
			return Redirect::route('domain.create')->with('success', trans('directory.domain_added'));
		}	
                
		return Redirect::back()->with('error', trans('directory.domain_add_error'));
	}
		
	public function edit($id)
	{
		$domain = Domain::find($id);
		
		$categories = Category::getCategories();
		
		return View::make('domains.edit')->with(compact('domain', 'categories'));
	}
	
	public function editHandle()
	{
		$domain = Domain::find(e(Input::get('id')));
		
		$valid_domain = function($domain_name)
		{
				return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
						&& preg_match("/^.{1,253}$/", $domain_name) //overall length check
						&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label	
		};
		
		$format_url = rtrim(str_replace(['http://', 'https://'], '', e(Input::get('url'))), '/');
		
		if( ! $valid_domain($format_url))
		{
			return Redirect::back()->with('error', trans('directory.invalid_url'))->withInput();
		}		
		
		$nice_input_names = [	
			'category_id' => trans('directory.select_category'),
			'name' => trans('directory.name'),
			'url' => trans('directory.url'),			
			'format_url' => trans('directory.url'),			
			'description' => trans('directory.description'),
			'keywords' => trans('directory.keywords')
		];

		$rules = [	
			'category_id' => 'not_in:"0"',
			'name' => 'required|between:6,260',
			'url' => 'required|between:6,100|unique:domains,url,' . e(Input::get('id')),
			'description' => 'required|between:200,1000',
			'keywords' => 'between:5,255'
		];
		
		if( ! Auth::check())
		{
			$nice_input_names['g-recaptcha-response'] = 'captcha';
			$rules['g-recaptcha-response'] = 'required|recaptcha';
		}	
		
		$validator = Validator::make(Input::all(), $rules, [], $nice_input_names);		
		
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}	
		
		$coma_replace = function($string) 
		{
			return str_replace(',', ', ', $string);
		};
		
		$domain->category_id = (int)e(Input::get('category_id'));
		$domain->status = 0;
		$domain->name = $coma_replace(e(Input::get('name')));
		$domain->url = 'http://'. $format_url;	
		$domain->description = $coma_replace(DirectoryHelpers::correctText(e(Input::get('description')), '.'));
		$domain->keywords = $coma_replace(e(Input::get('keywords')));
		
		if($domain->save())
		{		
			return Redirect::to(Domain::seoURL($domain->id))->with('success', trans('directory.domain_updated'));
		}	
		
		return Redirect::back()->with('error', trans('directory.domain_edit_error'));
	}
	
	public function approveHandle($id)
	{
		$domain = Domain::find($id);
		
		$domain->status = 1;
		
		$domain->save();
		
		$next_domain = Domain::where('status', 0)->first();
		
		if($next_domain)
		{
			$name = Domain::seoURL($next_domain->id);
			
			return $this->details($name, $next_domain->id);
		}	
		
		return Redirect::route('home')->with('success', 'Yoohoo you\'re done!');	
	}
	
	public function disapproveHandle($id)
	{
		$domain = Domain::find($id);
		
		$domain->status = 0;
		
		if($domain->save())
		{
			return Redirect::back()->with('success', trans('directory.domain_disabled'));
		}	
	}
	
	public function vote()
	{		
		$id = e(Input::get('id'));
		$vote_type = e(Input::get('vote_type'));
		
		if( ! DomainVote::voterExists($id))
		{
			$domain = Domain::find($id);
			$domain->increment($vote_type);
			$domain->save();
			
			$domain_voter = new DomainVote();
			
			$domain_voter->domain_id = $id;
			$domain_voter->ip = Request::instance()->getClientIp();
			
			$domain_voter->save();
		}
		
		return;
	}
		
	public function deleteHandle($id)
	{
		$domain = Domain::find($id);
		
		if(Acl::isAdmin($domain) || Acl::isSuperAdmin())
		{		
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
			$domain->siteViewers()->delete();
			$domain->domainVotes()->delete();
			
			$domain->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
			
			try
			{
				$path_details = explode("/", $domain->thumb, 2);
				$folder = $path_details[0];

				File::deleteDirectory(public_path('assets/thumbs/'.$folder));
			}
			catch(Exception $e){}
			
			return Redirect::route('domains-pending')->with('success', trans('directory.domain_deleted'));
		}
		
		return Redirect::back()->with('error', Lang::get('directory.delete_denied', ['domain' => $domain->name]));
	}
	
}