@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('directory.list_category_help') }}
		</p>
		<p>
			<a class="right" href="{{ URL::route('category.create') }}">{{ trans('directory.add_category') }}</a>
		</p>
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
	
	<div class="col-md-7">
		
		<a href="{{ URL::route('category.create') }}">{{ trans('directory.add_category') }}</a>
		
		<div class="row">
			<div class="col-sm-6">
				<h3>{{ trans('directory.categories') }}</h3>
			</div>
		</div>
		<div class="row">
			
			<?php echo Acl::renderCategoryHTMLTree() ?>
			
		</div>
	</div>
</div>	
@stop