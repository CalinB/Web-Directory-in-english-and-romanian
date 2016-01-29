@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('directory.list_domain_help') }}
		</p>
		<p>
			<a class="right" href="{{ URL::route('domain.create') }}">{{ trans('directory.add_domain') }}</a>
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
		
		<?php $n = 0; ?>
		@foreach($domains as $domain)
			@if($domain->status == 1)
				<?php $n++; ?>
			@endif
		@endforeach
				
		
		<h3 class="bottom">
			@if($n == 0)
				{{ $n }} {{ Lang::get('general.search_result', ['search_term' => $search_term]) }}
			@else
				{{ $n }} {{ Lang::get('general.search_results', ['search_term' => $search_term]) }}
			@endif
		</h3>
		
		@if(count($domains))
		
			<?php
			$format_text = function($text, $limit = 150)
			{			
				if(strlen($text) > $limit)
				{	
					return substr($text, 0, $limit).' <span style="color:#428bca; font-size:11px;">'.trans('general.more').'</span>';
				}else{
					return $text;
				}	
			};
			
			$replace = function($search_term, $field, $length = 100)
			{
				return str_replace(
					[
						$search_term, 
						strtolower($search_term), 
						strtoupper($search_term), 
						ucfirst($search_term)
					],
					[
						'<span class="search-term">' . $search_term . '</span>', 
						'<span class="search-term">' . strtolower($search_term) . '</span>', 
						'<span class="search-term">' . strtoupper($search_term) . '</span>', 
						'<span class="search-term">' . ucfirst($search_term) . '</span>', 
					],
					$field
					//substr($field, 0, $length)
				);
			}	
			?>
			@foreach($domains as $domain)
				@if($domain->status == 1)
					<div class="col-md-6 bottom">
						<a class="a-no-dec" href="{{ Domain::seoURL($domain->id) }}">
							<div class="site-box">
								<p>{{ $replace($search_term, $domain->name) }}</p>
								<p class="grey">{{ $replace($search_term, $format_text($domain->description)) }}</p>
								<p class="small grey">{{ trans('directory.url') }}: {{ $replace($search_term, $domain->url, 80) }}</p>
								<p class="small grey">{{ trans('directory.page_rank') }}: {{ $domain->page_rank }}</p>
								<p class="small grey">{{ trans('directory.site_visits') }}: {{ $domain->hits }}</p>
								<p class="small grey">{{ trans('directory.last_visit') }}: {{ DirectoryHelpers::lastVisited($domain->last_visit) }}</p>
							</div>
						</a>
					</div>	
				@endif
			@endforeach
		@else
		<div class="col-md-4 bottom">
			<p>{{ Lang::get('general.no_results', ['serch_term' => $search_term]) }}</p>		
		</div>
		@endif

	</div>
	<div class="col-md-12">
		<div class="pagination">
			{{ $domains->appends('search_term', $search_term)->links() }}
		</div>	
	</div>
</div>	

@stop