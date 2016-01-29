<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"  lang="{{ LaravelLocalization::getCurrentLangCode() }}">
	<head>
		<?php $b = Breadcrumbs::generate() ?>
		<title>{{ (Route::currentRouteName() == 'home') ? trans('general.main-description') : end($b)->title }}</title>		

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="<?php echo substr(trim($__env->yieldContent('description')), 0, 155); ?>" />
		<meta name="keywords" content="<?php echo substr(trim($__env->yieldContent('keywords')), 0, 155); ?>" />
		<meta name="Author" content="Your name" />
		<meta name="Robots" content="index,follow">
		<meta name="revisit-after" content="1 days">

		<link rel="author" href="https://plus.google.com/114183900135001854492" />
		<link type="text/css" rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/css/jquery.cookiebar.css') }}" />
		<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/css/style.css?v=1.1.4') }}" />

		
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.cookiebar-'.LaravelLocalization::getCurrentLocale().'.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('assets/js/detectmobilebrowser.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('assets/js/js.js') }}"></script>

		<!-- Google analytics -->
		<script type="text/javascript">

		</script>
	</head>
	<?php
	$current_page = (null != Route::current()) ? Route::current()->getName() : '';

	$category_pages = ['category.list', 'category.details', 'category.create', 'category.edit', 'category.delete'];
	$domain_pages = ['domain.list', 'domain.details', 'domain.create', 'domain.edit', 'domain.delete'];
	?>	
	<body class="">
		<div id="fb-root"></div>
		<script>
		// paste fb code
		</script>

		@include('general.nav-top')

		<div class="container">
			<div class="jumbotron">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<h1>{{ trans('general.main-description') }}</h1>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div id="mobile-notice" style="display: none;">
								<span class="glyphicon glyphicon-phone"></span> {{ trans('general.mobile_friendly') }}
							</div>	
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						{{ Breadcrumbs::renderIfExists() }}
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						some advertising
					</div>
				</div>

				@yield('content')		  

			</div>
			
			@include('general.footer')
						
		</div>	

		<div id="loading-div-background">			
			<div id="loading-div">
				{{ HTML::image('assets/img/ajax_loader.gif', 'Loading...', array('id' => 'loading')) }}
			</div>
		</div>
		<script type="application/ld+json">
		{
		   "@context": "http://schema.org",
		   "@type": "WebSite",
		   "url": "http://www.linksdirector.ro/",
		   "potentialAction": {
			 "@type": "SearchAction",
			 "target": "http://www.linksdirector.ro/search?search_term={search_term}",
			 "query-input": "required name=search_term"
		   }
		}
		</script>
	</body>

</html>
