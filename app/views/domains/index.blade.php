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
	  
	@if(isset($domains))	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			{{ Form::open(['route' => 'domain.list', 'method' => 'GET', 'class' => 'form-horizontal']) }}
			<div class="form-group">
				{{ Form::select('sort_by', [
					0 => trans('directory.sort_by'),
					'newest' => trans('directory.added_newest'), 
					'oldest' => trans('directory.added_oldest'), 
					'page_rank' => trans('directory.page_rank'), 
					'most_viewed' => trans('directory.most_viewed'), 
					'most_upvoted' => trans('directory.most_upvoted')
					], $sort_by, 
					['onChange' => 'this.form.submit();', 'class' => 'form-control col-md-6', 'id' => 'sortBy', 
						'placeholder' => trans('directory.name')]) }}
			</div>
			{{ Form::close() }}
		</div>	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  text-center pagination">	
			{{ $domains->links() }}
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row bottom">
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
			</div><div class="row bottom">
			@endif

			<div class="col-md-3">
				<a class="a-no-dec" href="{{ Domain::seoURL($domain->id) }}">
					<div class="site-box">
						<p>{{ $domain->name }}</p>
						<p class="grey">{{ $format_text($domain->description) }}</p>
						<p class="small grey">{{ trans('directory.url') }}: {{ substr($domain->url, 0, 30) }}</p>
						<p class="small grey">{{ trans('directory.page_rank') }}: {{ $domain->page_rank }}</p>
						<p class="small grey">{{ trans('directory.site_visits') }}: {{ $domain->hits }}</p>
						<p class="small grey">{{ trans('directory.last_visit') }}: {{ DirectoryHelpers::lastVisited($domain->last_visit) }}</p>
						<p class="small grey">{{ trans('directory.comments') }}: {{ $domain->totalActiveComments()->count() }}</p>
					</div>
				</a>
			</div>		
			@endforeach			
			</div>
			<div class="clearfix visible-lg"></div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagination text-center">
			{{ $domains->links() }}
		</div>
	@endif
</div>	
@stop