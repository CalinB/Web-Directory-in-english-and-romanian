<?php

class HomeController extends BaseController {

	public function index()
	{		
		$domains = Domain::where('status', 1)
			->orderBy('created_at', 'desc')
			->paginate(8);
		
		return View::make('home.index')->with(compact('domains'));
	}

	public function search()
	{
		$search_term = trim(e(Input::get('search_term')));
		
		$rules = [
			'search_term' => 'required|min:3'
		];
		
		$validator = Validator::make(['search_term' => $search_term], $rules);
		
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();			
		}	
		
		$domains = Domain::where('status', 1)
			->where('url', 'LIKE', '%' . $search_term . '%')
			->orWhere('name', 'LIKE', '%' . $search_term . '%')
			->orWhere('description', 'LIKE', '%' . $search_term . '%')
			->paginate(6);
		
		return View::make('home.search_results')->with(compact('domains', 'search_term'));
	}
	
	public function searchAjax()
	{
		$response = '';
		
		$search_term = trim(e(Input::get('search_term')));
		
		$domains = Domain::where('status', 1)
			->where('name', 'LIKE', '%' . $search_term . '%')
			->orWhere('url', 'LIKE', '%' . $search_term . '%')
			->orWhere('description', 'LIKE', '%' . $search_term . '%')
			->take(5)
			->get(['id', 'name', 'thumb']);
		
		if(count($domains))
		{
			foreach($domains as $domain)
			{	
				$domain_name = strlen($domain->name) > 30 ? substr($domain->name, 0, 30) .'...' : $domain->name;
				
				$response .= '<div class="search-box">
					<a class="search-result-row" href="'. Domain::seoURL($domain->id) .'">
						<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
							<img class="img img-responsive thumbnail" 
								src="' . URL::asset('assets/thumbs/'.$domain->thumb) .'" alt="site preview" />
						</div>			
						<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
							'. $domain_name .'	
						</div>	
						<div class="clearfix"></div>
					</a>	
					</div>';
			}	
		}
		else
		{
			$response .= '<p>'. Lang::get('general.no_results', ['serch_term' => $search_term]) .'</p>';	
		}
		
		print($response);
	}
	
	public function getContact()
	{
		$sender_email = null;
		
		if(Auth::check())
		{
			$sender_email = Auth::user()->email;
		}	
		
		return View::make('home.contact')->with(compact('sender_email'));
	}
	
	public function postContact()
	{
		$rules = [
			'email' => 'required|email', 
			'name' => 'between:2,50', 
			'reason' => 'required|between:5,1000', 
			'g-recaptcha-response' => 'required|recaptcha'
			];
		
		$nice_input_names = array(
			'name' => trans('general.name'),
			'reason' => trans('general.reason'),
			'g-recaptcha-response' => 'captcha'
		);

		$validator = Validator::make(Input::all(), $rules, [], $nice_input_names);
		
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$data['body_message'] = '<p>' . trans('general.send_by') . ': ' . e(Input::get('name')) . '( ' .  e(Input::get('email')) . ' )</p>';
		$data['body_message'] .= '<p>' . trans('general.reason') . ': ' . e(Input::get('reason')). ' )</p>';
		
//		Mail::send('emails.contact', $data, function($message) 
//		{
//			$message->from(Config::get('app.no_reply_email'));
//
//			$message->to(Config::get('app.admin_email'))->subject(trans('general.email_from_site'));
//		});
		if(mail(Config::get('app.admin_email'), trans('general.email_from_site'), $data['body_message'], Input::get('email')))
		{		
			return Redirect::route('contact')->with('success', trans('general.message_sent'));
		}
		
		return Redirect::back()->with('error', 'Email not sent');
			
	}
}
