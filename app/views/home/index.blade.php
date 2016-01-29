@extends('master')

@section('description')
	{{ trans('general.meta_description') }}
@stop

@section('keywords')
	{{ trans('general.meta_keywords') }}
@stop

@section('content')

<div class="row">
	@if(Session::has('success'))
		<p class="alert alert-success">{{ Session::get('success') }}</p>
	@endif
	@if(Session::has('error'))
		<p class="alert alert-danger">{{ Session::get('error') }}</p>
	@endif
	@if(isset($errors))
		@foreach($errors as $error)
			<p class="alert alert-danger">{{ $error }}</p>
		@endforeach	
	@endif
	
	<p class="bottom">{{ trans('directory.last_domains') }}</p>   
	@if(isset($domains))
	
			<?php  
			$i = -1; 
			$format_text = function($text, $limit = 150)
			{			
				if(strlen($text) > $limit)
				{	
					return substr($text, 0, $limit).' <span style="color:#428bca; font-size:11px;">'.trans('general.more').'</span>';
				}else{
					return $text;
				}	
			};
			?>

			@foreach($domains as $domain)
			<?php $i++; ?>

			@if($i == 4)
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- responsive_2 -->
				<ins class="adsbygoogle"
					 style="display:block"
					 data-ad-client="ca-pub-7330234373627752"
					 data-ad-slot="8578189805"
					 data-ad-format="auto"></ins>
				<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
			</div>
			@endif

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<a class="a-no-dec" href="{{ Domain::seoURL($domain->id) }}">
					<div class="site-box">
						<p>{{ $domain->name }}</p>
						<p class="grey">{{ $format_text($domain->description) }}</p>
						<p class="small grey">{{ trans('directory.site_visits') }}: {{ $domain->hits }}</p>
						<p class="small grey">{{ trans('directory.last_visit') }}: {{ DirectoryHelpers::lastVisited($domain->last_visit) }}</p>
						<p class="small grey">{{ trans('directory.comments') }}: {{ $domain->totalActiveComments()->count() }}</p>
					</div>
				</a>
			</div>	
			@endforeach
			<div class="clearfix visible-lg"></div>
	
	@endif
</div>	

<div class="row">
	<div class="col-md-12 text-center">
		<a href="{{ URL::route('domain.list') }}"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;{{ trans('directory.domains_all') }}</a>
	</div>
</div>

@stop