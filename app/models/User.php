<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait,
	 RemindableTrait;

	const NORMAL_USER = 'user';
	const ADMIN_USER = 'admin';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	public static $register_rules = [
		'firstname' => 'alpha|min:2',
		'lastname' => 'alpha|min:2',
		'email' => 'required|email|unique:users',
		'password' => 'required|alpha_num|between:6,20|confirmed|regex:"^(?=.*[a-z])(?=.*\d)[a-zA-Z\d]{6,20}$"',
		'password_confirmation' => 'required|alpha_num|between:6,20',
		'terms' => 'required',
		'g-recaptcha-response' => 'required|recaptcha',
	];
	
	public static $login_rules = [
		'email' => 'required|exists:users',
		'password' => 'required'
	];
	
	public static $resend_validation_rules = [
		'email' => 'required|exists:users',
		'g-recaptcha-response' => 'required|recaptcha',
	];
	
	public static $pass_reset_rules = [
		'email' => 'required|email|exists:users',
		'password' => 'required|alpha_num|between:6,20|confirmed|regex:"^(?=.*[a-z])(?=.*\d)[a-zA-Z\d]{6,20}$"',
		'password_confirmation' => 'required|alpha_num|between:6,20',
		'g-recaptcha-response' => 'required|recaptcha',
	];

	public function isAdmin()
	{		
		if($this->acl == $this::ADMIN_USER)
		{
			return true;
		}	
		
		return false;
	}
}
