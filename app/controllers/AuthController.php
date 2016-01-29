<?php

class AuthController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getLogin()
	{
		if (Auth::check())
		{
			return Redirect::route('home');
		}

		return View::make('auth.login');
	}

	public function postLogin()
	{
		$nice_input_names = ['password' => trans('auth.password')];

		$validator = Validator::make(['email' => Input::get('email'), 'password' => Input::get('password')], User::$login_rules, [], $nice_input_names);

        if($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }
		
		try
		{
			$user = User::where('email', Input::get('email'))->first();
			
			if( ! $user->status)
			{
				return Redirect::back()->with('error', trans('auth.account_suspended'));
			}
			
			if( ! $user->confirmed)
			{
				return Redirect::back()->with('error', trans('auth.email_unconfirmed'));
			}
		}
		catch (Exception $ex)
		{
			return Redirect::route('login')->with('error', 'User not found!');
		}

        $credentials = [
            'email' => e(Input::get('email')),
            'password' => e(Input::get('password'))
        ];

        if (Auth::attempt($credentials, (bool)Input::get('remeber_me')))
        {
			return Redirect::intended('/');            
        }

		return Redirect::back()->withInput()->with('error', trans('auth.login_error'));        
	}
	
	public function getRegister()
	{
		if (Auth::check())
		{
			return Redirect::route('home');
		}

		return View::make('auth.register');
	}

	public function postRegister()
	{
		$nice_input_names = array(
			'firstname' => trans('auth.firstname'),
			'lastname' => trans('auth.lastname'),
			'password' => trans('auth.password'),
			'password_confirmation' => trans('auth.re_password'),
			'g-recaptcha-response' => 'captcha'
		);

		$validator = $validator = Validator::make(Input::all(), User::$register_rules, [], $nice_input_names);

		if ($validator->passes())
		{
			$confirmation_code = str_random(30);
			
			$user = new User;
			$user->firstname = e(Input::get('firstname'));
			$user->lastname = e(Input::get('lastname'));
			$user->email = e(Input::get('email'));
			$user->password = Hash::make(Input::get('password'));
			$user->confirmation_code = $confirmation_code;
			
			if($user->save())
			{	
				$data = [
					'body_message' => trans('auth.welcome_body'),
					'confirmation_code' => $confirmation_code
				];

//				Mail::send('emails.welcome', $data, function($message) 
//				{
//					$message->from(Config::get('app.no_reply_email'));
//
//					$message->to(Input::get('email'))->subject(trans('auth.welcome_subject'));
//				});
				
				$email_tpl = trans('auth.welcome') . ' ' . $data['body_message'] . ' '
						. ' ' . URL::route('verify-register', [ $data['confirmation_code'] ]);
				
				if(mail(e(Input::get('email')), trans('auth.welcome_subject'), HTML::decode($email_tpl), Input::get('email')))
				{		
					return Redirect::to('users/login')->with('success', trans('auth.register_success'));
				}				
				
			}
			
			return Redirect::back()->with('error', trans('auth.register_fail'));
		}

		return Redirect::back()->withErrors($validator)->withInput();
	}
	
	public function getResendValidationEmail()
	{
		return View::make('auth.resend_validation');
	}
	
	public function postResendValidationEmail()
	{
		$validator = Validator::make(Input::all(), User::$resend_validation_rules, [], ['g-recaptcha-response' => 'captcha']);
		
		if($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

		$user = User::where('email', Input::get('email'))->first();

		$confirmation_code = str_random(30);

		$user->confirmation_code = $confirmation_code;

		if($user->save())
		{	
			$data = [
				'body_message' => trans('auth.welcome_body'),
				'confirmation_code' => $confirmation_code
			];

//			Mail::send('emails.welcome', $data, function($message) 
//			{
//				$message->from(Config::get('app.no_reply_email'));
//
//				$message->to(Input::get('email'))->subject(trans('auth.welcome_subject'));
//			});
			
			$email_tpl = trans('auth.welcome') . ' ' . $data['body_message'] . ' '
						. ' ' . URL::route('verify-register', [ $data['confirmation_code'] ]);
				
			if(mail(e(Input::get('email')), trans('auth.welcome_subject'), HTML::decode($email_tpl)))
			{		
				return Redirect::to('users/login')->with('success', trans('auth.resend_success'));
			}	
			
		}
	}
	
	public function verifyRegister($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return Redirect::route('login')->with('error', trans('auth.invalid_code'));
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return Redirect::route('login')->with('error', trans('auth.invalid_code'));
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return Redirect::route('login')->with('success', trans('auth.confirm_success'));
    }
	
	public function getLogout() 
	{
		Auth::logout();
		
		return Redirect::route('home')->with('success', trans('auth.logout'));
	}

}
