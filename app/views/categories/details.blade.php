@extends('master')

@section('description')
	{{ $category->description }}
@stop
@section('keywords')
	{{ $category->keywords }}
@stop

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ Lang::get('directory.details_category_help', ['category' => $category->name]) }}
		</p>
		@if(Acl::isAdmin($category))
			<p><a href="{{ URL::route('category.edit', [$category->id]) }}"> 
				<span class="glyphicon glyphicon-edit"></span> {{ trans('general.edit') }}
			</a></p>
		@endif
		@if(Acl::isSuperAdmin())
			<p><a href="{{ URL::route('category.delete', [$category->id]) }}"> 
				<span class="glyphicon glyphicon-trash"></span> {{ trans('general.delete') }}
			</a></p>	
		@endif
		@if(Acl::isSuperAdmin())
			@if($category->status == 0)
			<p>
				<a href="{{ URL::route('category.approve', [$category->id]) }}"> 
					<span class="glyphicon glyphicon-ok"></span> {{ trans('general.approve') }}
				</a>
			</p>
			@else
			<p>
				<a href="{{ URL::route('category.disapprove', [$category->id]) }}"> 
					<span class="glyphicon glyphicon-remove"></span> {{ trans('general.disapprove') }}
				</a>
			</p>
			@endif
		@endif
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- responsive_add -->
		<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-7330234373627752"
			 data-ad-slot="7101456601"
			 data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>	
	<div class="col-md-8">	
			
		@if(Session::has('success'))
			<div class="alert alert-success">{{ Session::get('success') }}</div>
		@endif
		@if(Session::has('error'))
			<div class="alert alert-danger">{{ Session::get('error') }}</div>
		@endif
		@if(isset($errors))
			@foreach($errors as $error)
				<div class="alert alert-danger">{{ $error }}</div>
			@endforeach	
		@endif
		
		<p>{{ trans('directory.name') }}</p>
		<h3 class="bottom">{{ $category->name }}</h3>
		
		<p>{{ trans('directory.description') }}</p>
		<p class="bottom">{{ $category->description }}</p>
		
		<p>{{ trans('directory.keywords') }}</p>
		<p class="bottom">{{ $category->keywords }}</p>
		
		<p>
			{{ trans('directory.category_domains_no') }}: <a href="{{ URL::route('domain.list', [$category->id]) }}">{{ count($category->domains) }}</a>
		</p>
				
					
		<div class="clearfix visible-lg"></div>
	</div>
	<div class="col-md-12">
		<div class="col-md-12 pagination">
			{{ $catgory_domains->links() }}
		</div>	
	</div>
</div>	

@stop