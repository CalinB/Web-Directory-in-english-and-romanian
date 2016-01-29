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
		<span class="alert alert-success">{{ Session::get('success') }}</span>
	@endif
	@if(Session::has('error'))
		<span class="alert alert-danger">{{ Session::get('error') }}</span>
	@endif
	@if(isset($errors))
		@foreach($errors as $error)
			<span class="alert alert-danger">{{ $error }}</span>
		@endforeach	
	@endif
	
	<p class="bottom">{{ trans('user.my_websites') }}</p>  
	
		<div class="col-md-12">
			<div class="col-md-12 pagination">
				{{ $user_domains->links() }}
			</div>	
		</div>
		<div class="col-md-12">
			<div class="row bottom">
			<?php  
			$i = -1;
			?>

			@foreach($user_domains as $domain)
			<?php $i++; ?>

			@if($i == 4)
			</div><div class="row bottom">
			@endif

			<div class="col-md-3">

				<p><a href="{{ Domain::seoURL($domain->id) }}"><span class="glyphicon glyphicon-link"></span> {{ $domain->name }}</a></p>
				<p>{{ substr($domain->description, 0, 150) }} <a href="{{ URL::route('domain.details', $domain->id) }}">{{ trans('general.more') }}</a></p>
				
				<span class="small grey">{{ trans('directory.url') }}: {{ $domain->url }}</span>
				<br />
				<span class="small grey">{{ trans('directory.added_date') }}: {{ HTML::decode($domain->created_at->format('d-m-Y')) }}</span>
				<br />
				<span class="small grey">{{ trans('directory.page_rank') }}: {{ $domain->page_rank }}</span>
				<br />
				<p class="small grey">{{ trans('directory.site_visits') }}: {{ $domain->hits }}</p>
				
			</div>	
			@endforeach			
			</div>
			<div class="clearfix visible-lg"></div>
		</div>
		<div class="col-md-12">
			<div class="col-md-12 pagination">
				{{ $user_domains->links() }}
			</div>	
		</div>
	
</div>	
@stop