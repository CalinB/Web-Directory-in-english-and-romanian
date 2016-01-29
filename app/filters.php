<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */
$locale = [
	'ro' => ['ro.utf-8', 'ro_RO.UTF-8', 'ro_RO.utf-8', 'ro', 'ro_RO'],
	'en' => ['en.utf-8', 'en_US.UTF-8', 'en_US.utf-8', 'en', 'en_US']
];

setlocale(LC_TIME, $locale[LaravelLocalization::getCurrentLocale()]);

App::missing(function($exception) {
	return Response::view('home.index', array('error' => 'Not found'), 404);
});

App::before(function($request) {
	//
});


App::after(function($request, $response) {
	//
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		} else
		{
			return Redirect::route('login');
		}
	}
});

Route::filter('auth.basic', function() {
	return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
	if (Auth::check())
		return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('admin', function() {
	if ( ! Auth::user()->isAdmin())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		} else
		{
			return Redirect::route('login');
		}
	}
});

Route::filter('isAdmin', function($route, $request, $entity_name) 
{
	$entity_id = $route->getParameter('id');
	
	if ( ! Acl::isAdminFilter($entity_name, $entity_id))
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		} 
		else
		{
			return Redirect::route('home')->with('error', 'Unauthorized');
		}
	}	
});

Route::filter('superAdmin', function() 
{	
	if( ! Acl::isSuperAdmin())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		} 
		else
		{
			return Redirect::route('home')->with('error', 'Unauthorized');
		}
	}	
});