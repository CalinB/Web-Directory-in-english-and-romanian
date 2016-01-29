<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */
Route::get('sitemap.xml', function()
{
	$content = View::make('general.sitemap');

	return Response::make($content, '200')->header('Content-Type', 'text/xml');
});

Route::get('generatesitemap', function() {
	
	return Artisan::call('generatesitemap');
});

Route::group(array(
	'prefix' => LaravelLocalization::setLocale(),
	'before' => 'LaravelLocalizationRedirectFilter' // LaravelLocalization filter
		), function() 
	{	
	Route::get('/', [
		'as' => 'home',
		'uses' => 'HomeController@index'
	]);
	Route::get('terms', [
		'as' => 'terms',
		function()
		{
			return View::make('home.terms');
		}
	]);
	Route::get('contact', [
		'as' => 'contact',
		'uses' => 'HomeController@getContact'
	]);
	Route::get('search', [
		'as' => 'search',
		'uses' => 'HomeController@search'
	]);
	Route::post('contact', [
		'as' => 'contact.post',
		'uses' => 'HomeController@postContact'
	]);
	Route::get('users/login', [
		'as' => 'login',
		'uses' => 'AuthController@getLogin'
	]);
	Route::post('users/login', [
		'before' => 'csrf',
		'as' => 'login.post',
		'uses' => 'AuthController@postLogin'
	]);
	Route::get('users/logout', [
		'as' => 'logout',
		'uses' => 'AuthController@getLogout'
	]);
	Route::get('users/register', [
		'as' => 'register',
		'uses' => 'AuthController@getRegister'
	]);
	Route::post('users/register', [
		'as' => 'register.post',
		'uses' => 'AuthController@postRegister'
	]);

	Route::get('users/resend-validation', [
		'as' => 'resend-validation',
		'uses' => 'AuthController@getResendValidationEmail'
	]);
	Route::post('users/resend-validation', [
		'as' => 'resend-validation.post',
		'uses' => 'AuthController@postResendValidationEmail'
	]);
	
	Route::get('users/register/verify/{confirmation_code}', [
		'as' => 'verify-register',
		'uses' => 'AuthController@verifyRegister'
	]);

	// password reset
	Route::get('password/remind', [
		'as' => 'password-remind',
		'uses' => 'RemindersController@getRemind'
	]);
	Route::post('password/remind', [
		'as' => 'password-remind.post',
		'uses' => 'RemindersController@postRemind'
	]);
	Route::get('password/reset/{token?}', [
		'as' => 'password-reset',
		'uses' => 'RemindersController@getReset'
	]);
	Route::post('password/reset', [
		'as' => 'password-reset.post',
		'uses' => 'RemindersController@postReset'
	]);
	// categories
	Route::group(array('prefix' => 'category'), function()
	{
		Route::get('list', [
			'as' => 'category.list',
			'uses' => 'CategoriesController@listCategories'
		]);
		Route::get('details/{path}', [
			'as' => 'category.details',
			'uses' => 'CategoriesController@details'
		]);
		Route::get('create', [
			'as' => 'category.create',
			'uses' => 'CategoriesController@create'
		]);
		Route::post('create', [
			'as' => 'category.create.post',
			'uses' => 'CategoriesController@createHandle'
		]);
		Route::get('edit/{id}', [
			'before' => 'auth|isAdmin:Category',
			'as' => 'category.edit',
			'uses' => 'CategoriesController@edit'
		]);
		Route::post('edit', [
			'before' => 'auth',
			'as' => 'category.edit.post',
			'uses' => 'CategoriesController@editHandle'
		]);		
		Route::get('approve/{id}', [
			'before' => 'auth',
			'as' => 'category.approve',
			'uses' => 'CategoriesController@approveHandle'
		]);
		Route::get('disapprove/{id}', [
			'before' => 'auth',
			'as' => 'category.disapprove',
			'uses' => 'CategoriesController@disapproveHandle'
		]);
		Route::get('delete/{id}', [
			'before' => 'auth',
			'as' => 'category.delete',
			'uses' => 'CategoriesController@delete'
		]);
		Route::post('delete', [
			'before' => 'auth',
			'as' => 'category.delete.post',
			'uses' => 'CategoriesController@deleteHandle'
		]);
		
	});
	// domains
	Route::group(array('prefix' => 'domain'), function()
	{
		Route::get('list/{category_id?}', [
			'as' => 'domain.list',
			'uses' => 'DomainsController@listDomains'
		]);
		Route::get('{name}/{id}', [
			'as' => 'domain.details',
			'uses' => 'DomainsController@details'
		]);
		Route::get('create', [
			'as' => 'domain.create',
			'uses' => 'DomainsController@create'
		]);
		Route::post('create', [
			'as' => 'domain.create.post',
			'uses' => 'DomainsController@createHandle'
		]);
		Route::get('e/{id}/edit', [
			'before' => 'auth',
			'as' => 'domain.edit',
			'uses' => 'DomainsController@edit'
		]);
		Route::post('edit', [
			'before' => 'auth',
			'as' => 'domain.edit.post',
			'uses' => 'DomainsController@editHandle'
		]);
		Route::get('d/{id}/approve', [
			'before' => 'auth',
			'as' => 'domain.approve',
			'uses' => 'DomainsController@approveHandle'
		]);
		Route::get('d/{id}/disapprove', [
			'before' => 'auth',
			'as' => 'domain.disapprove',
			'uses' => 'DomainsController@disapproveHandle'
		]);
		Route::get('d/{id}/delete', [
			'before' => 'auth',
			'as' => 'domain.delete',
			'uses' => 'DomainsController@deleteHandle'
		]);
	});
	// comments
	Route::get('comments-pending', [
		'before' => 'auth',
		'uses' => 'AdminController@pendingComments',
		'as' => 'comments-pending'
	]);
	Route::get('add/comment/{domain_id}', [
		//'before' => 'auth',
		'uses' => 'CommentsController@getCreateComment',
		'as' => 'add-comment'
	]);
	Route::post('add/comment', [
		//'before' => 'auth',
		'uses' => 'CommentsController@createComment',
		'as' => 'add-comment.post'
	]);
	Route::get('comments/domain/{id}/edit', [
		'before' => 'auth',
		'uses' => 'CommentsController@getEditComment',
		'as' => 'comment-edit'
	]);
	Route::post('edit/comment', [
		'before' => 'auth',
		'uses' => 'CommentsController@editComment',
		'as' => 'comment-edit.post'
	]);
	Route::post('comment/delete', [
		'before' => 'auth',
		'uses' => 'CommentsController@deleteComment',
		'as' => 'comment-delete'
	]);
	Route::post('approve-disapprove-comment', [
		'before' => 'auth',
		'as' => 'approve-disapprove-comment',
		'uses' => 'CommentsController@approveDisapproveHandle'
	]);
	
	// users
	Route::group(array('prefix' => 'user'), function()
	{
		Route::get('account', [
			'as' => 'user.account',
			'uses' => 'UserController@account'
		]);
		Route::get('edit', [
			'before' => 'auth|superAdmin',
			'as' => 'user.edit',
			'uses' => 'UserController@edit'
		]);
		Route::post('edit', [
			'before' => 'auth|superAdmin',
			'as' => 'user.edit.post',
			'uses' => 'UserController@editHandle'
		]);
		Route::post('delete', [
			'before' => 'auth|superAdmin',
			'as' => 'user.delete',
			'uses' => 'UserController@delete'
		]);
		Route::get('my-websites', [
			'as' => 'domain.user',
			'uses' => 'UserController@listUserDomains'
		]);
	});
	
	Route::group(['prefix' => 'admin', 'before' => 'auth|superAdmin'], function() 
	{		
		Route::get('domains/pending', [
			'as' => 'domains-pending',
			'uses' => 'AdminController@getPendingDomains'
		]);
		Route::get('domains/attempts', [
			'as' => 'domains-attempts',
			'uses' => 'AdminController@getAttempts'
		]);
		Route::get('attempt/{id}', [
			'as' => 'attempt.details',
			'uses' => 'AdminController@attemptDetails'
		]);
		Route::get('attempt-add/{id}', [
			'as' => 'attempt.add',
			'uses' => 'AdminController@attemptAdd'
		]);				
		Route::get('attempt/delete/{id}', [
			'as' => 'attempt.delete',
			'uses' => 'AdminController@attemptDelete'
		]);
		Route::get('comments-all', [
			'before' => 'auth',
			'uses' => 'AdminController@allComments',
			'as' => 'comments-all'
		]);
	});	
});
Route::post('vote', [
	'as' => 'vote.site',
	'uses' => 'DomainsController@vote'
]);
Route::get('get/site/votes/{type}/{id}', [
	'as' => 'get.site.votes',
	function($type, $id)
	{
		return Domain::find($id)->{$type};
	}
]);

Route::post('search', [
	'as' => 'search.post',
	'uses' => 'HomeController@searchAjax'
]);

Route::get('generate-sitemap', function() {
	ini_set('memory_limit', '2048M');
		
	$domains = Domain::where('status', 1)->get(['id', 'updated_at']);
	$categories = Category::where('status', 1)->get(['path', 'updated_at']);
	$langs = LaravelLocalization::getSupportedLocales();
	// create new sitemap object
	$sitemap = App::make("sitemap");

	// set cache (key (string), duration in minutes
	// (Carbon|Datetime|int), turn on/off (boolean))
	// by default cache is disabled
	//$sitemap->setCache('laravel.sitemap', 3600);		
	$i = 0;
	$ci = 0;
	foreach($domains as $domain)
	{
		$translations = array(
			array(
				'url' => LaravelLocalization::getLocalizedURL('ro', Domain::seoURL($domain->id), 'ro'),
				'language' => 'ro'
			),
			array(
				'url' => LaravelLocalization::getLocalizedURL('en', Domain::seoURL($domain->id), 'en'),
				'language' => 'en'
			)
		);

		foreach($langs as $lang_code => $lang_details)
		{			

			$sitemap->add(
				LaravelLocalization::getLocalizedURL($lang_code, Domain::seoURL($domain->id)), // loc
				date('c', strtotime($domain->updated_at)), // datetime modified
				1.0, // priority from 0.0 to 1.0
				'daily', // frequency
				null, // title
				null, // images array() (url|caption)
				$translations // translations array() (url|language)
			);
		}
		$i++;
	}
	foreach($categories as $category)
	{
		$ctranslations = array(
			array(
				'url' => LaravelLocalization::getLocalizedURL('ro', URL::route('category.details', [$category->path]), 'ro'),
				'language' => 'ro'
			),
			array(
				'url' => LaravelLocalization::getLocalizedURL('en', URL::route('category.details', [$category->path]), 'en'),
				'language' => 'en'
			)
		);

		foreach($langs as $lang_code => $lang_details)
		{			

			$sitemap->add(
				LaravelLocalization::getLocalizedURL($lang_code, URL::route('category.details', [$category->path])), // loc
				date('c', strtotime($category->updated_at)), // datetime modified
				1.0, // priority from 0.0 to 1.0
				'daily', // frequency
				null, // title
				null, // images array() (url|caption)
				$ctranslations // translations array() (url|language)
			);
		}
		$ci++;
	}
	$r = $sitemap->store('xml');
});