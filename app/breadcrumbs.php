<?php

// auth 
Breadcrumbs::register('', function($breadcrumbs) 
{
	$breadcrumbs->push(trans('general.home'), route('home'));
});
Breadcrumbs::register('home', function($breadcrumbs) {
	$breadcrumbs->push(trans('general.home'), route('home'));
});
Breadcrumbs::register('search', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('general.search'), route('search'));
});
Breadcrumbs::register('terms', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('general.terms'), route('terms'));
});
Breadcrumbs::register('contact', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('general.contact'), route('contact'));
});
Breadcrumbs::register('login', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Login', route('login'));
});
Breadcrumbs::register('register', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('auth.sign_up'), route('register'));
});
Breadcrumbs::register('password-remind', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('auth.password_reset'), route('password-remind'));
});
Breadcrumbs::register('password-reset', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('auth.password_reset'), route('password-remind'));
});
Breadcrumbs::register('resend-validation', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('auth.resend_validation'), route('resend-validation'));
});

// categories
Breadcrumbs::register('category.list', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('directory.categories'), route('category.list'));
});
Breadcrumbs::register('category.create', function($breadcrumbs) {
	$breadcrumbs->parent('category.list');
	$breadcrumbs->push(trans('directory.add_category'), route('category.create'));
});
Breadcrumbs::register('category.details', function($breadcrumbs, $path) {
	$breadcrumbs->parent('category.list');
	
	$category = Category::where('path', $path)->first();

	if (isset($category))
	{
		foreach ($category->getAncestorsAndSelf() as $descendant)
		{
			$breadcrumbs->push($descendant->name, route('category.details', $descendant->path));
		}
	}
});
Breadcrumbs::register('category.edit', function($breadcrumbs, $id) {
	
	$category = Category::find($id);
	
	$breadcrumbs->parent('category.list');
	$breadcrumbs->push($category->name, route('category.details', $category->path));
	$breadcrumbs->push(trans('directory.edit_category'), route('category.edit'));
});

// domains
Breadcrumbs::register('domain.list', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('directory.domains'), route('domain.list'));
});
Breadcrumbs::register('domain.create', function($breadcrumbs) {
	$breadcrumbs->parent('domain.list');
	$breadcrumbs->push(trans('directory.add_domain'), route('domain.create'));
});
Breadcrumbs::register('domain.details', function($breadcrumbs, $name, $id) {
	
	$breadcrumbs->parent('domain.list');
	
	$domain = Domain::find($id);

	if ( ! empty($domain))
	{
		$breadcrumbs->push($domain->name, route('domain.details', $name));
	}
});
Breadcrumbs::register('domains-pending', function($breadcrumbs) {
	$breadcrumbs->parent('domain.list');
	$breadcrumbs->push(trans('directory.pending_domains'), route('domains-pending'));
});
Breadcrumbs::register('domain.user', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('user.my_websites'), route('domain.user'));
});

Breadcrumbs::register('domain.edit', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('directory.edit_domain'), route('domain.edit'));
});

Breadcrumbs::register('domain.approve', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Aprobari domenii', route('domain.approve'));
});

//attempts
Breadcrumbs::register('domains-attempts', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Attempts', route('domains-attempts'));
});
Breadcrumbs::register('attempt.details', function($breadcrumbs, $id) {
	
	$breadcrumbs->parent('domains-attempts');
	
	$attempt = Attempt::find($id);

	if ( ! empty($attempt))
	{
		$breadcrumbs->push($attempt->name, route('attempt.details'));
	}
});
Breadcrumbs::register('attempt.add', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Add Attempt', route('attempt.add'));
});

Breadcrumbs::register('attempt.delete', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Delete Attempt', route('attempt.delete'));
});
// comments

Breadcrumbs::register('comments-all', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Coments all', route('comments-all'));
});
Breadcrumbs::register('add-comment', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('directory.add_comment'), route('add-comment'));
});
Breadcrumbs::register('comment-edit', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('directory.edit_omment'), route('comment-edit'));
});
Breadcrumbs::register('comments-pending', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('directory.pending_comments'), route('comments-pending'));
});
// users
Breadcrumbs::register('user.account', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push(trans('user.my_account'), route('user.account'));
});
Breadcrumbs::register('user.edit', function($breadcrumbs) {
	$breadcrumbs->parent('user.account');
	$breadcrumbs->push(trans('user.edit_account'), route('user.edit'));
});