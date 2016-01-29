<?php

class UserController extends BaseController {
	
	protected $user;

	public function __construct()
	{
		$this->user = Auth::user();
	}
	
	public function account()
	{
		$user = Auth::user();
		
		$domains = count(Acl::getAdminEntitiesIDs('Domain'));
		
		return View::make('user.account')->with(compact('user', 'domains'));
	}
	
	public function edit()
	{
		$user = Auth::user();
		
		return View::make('user.edit')->with(compact('user'));
	}
	
	public function editHandle()
	{
		$user = Auth::user();
		
		$nice_input_names = array(
			'firstname' => trans('auth.firstname'),
			'lastname' => trans('auth.lastname'),
		);

		$data = [
			'firstname' => e(Input::get('firstname')),
			'lastname' => e(Input::get('lastname'))
		];
		$rules = [
			'firstname' => 'alpha|min:2',
			'lastname' => 'alpha|min:2'
		];
		
		$email_changed = false;
		
		if(e(Input::get('email')) != $user->email)
		{
			$data['email'] = e(Input::get('email')); 
			$rules['email'] = 'required|email|unique:users,email,' . $user->id;
			$email_changed = true;
		}
		
		$validator = $validator = Validator::make($data, $rules, [], $nice_input_names);

		if ($validator->passes())
		{
			$user->firstname = e(Input::get('firstname'));
			$user->lastname = e(Input::get('lastname'));
			
			if($email_changed)
			{	
				$confirmation_code = str_random(30);
				
				$user->email = e(Input::get('email'));
				$user->confirmed = 0;
				$user->confirmation_code = $confirmation_code;
			
				$data = [
					'body_message' => trans('auth.welcome_body'),
					'confirmation_code' => $confirmation_code
				];
				
				$email_tpl = trans('auth.welcome') . ' ' . $data['body_message'] . ' ' . ' ' . URL::route('verify-register', [ $data['confirmation_code'] ]);
				
				if(mail(e(Input::get('email')), trans('auth.welcome_subject'), HTML::decode($email_tpl)))
				{		
					$user->save();
					
					return Redirect::route('logout');
				}
			}
			
			$user->save();
			
			return Redirect::back()->with('success', trans('user.account_updated'));
		}

		return Redirect::back()->withErrors($validator)->withInput();
	}
	
	public function delete()
	{
		Acl::deleteAdmin();
		
		$user = Auth::user();
		
		$user->delete();
		
		return Redirect::route('home')->with('success', trans('user.account_deleted'));
	}
	
	public function listUserDomains()
	{		
		$has_domains = count(Acl::getAdminEntitiesIDs('Domain'));
		
		if( ! empty($has_domains))
		{
			$user_domains = Domain::whereIn('id', Acl::getAdminEntitiesIDs('Domain'))->paginate(8);
			
			return View::make('user.domains')->with(compact('user_domains'));
		}
		
		return View::make('user.account')->with('error', 'Nu ai nici un site inscris!');
	}
}