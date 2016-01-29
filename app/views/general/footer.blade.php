<div class="footer container-fluid">
	<div id="likebox-wrapper" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FLinksDirectorro%2F121444017933604&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=592019634262081" style="border:none; overflow:hidden; height:258px;"></iframe>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 statistics">
		<?php
		$max_views = Domain::where('status', 1)->max('hits');
		$most_viewed = Domain::where('status', 1)->where('hits', $max_views)->first();
		$max_votes = Domain::where('status', 1)->max('votes_up');
		$most_voted = Domain::where('status', 1)->where('votes_up', $max_votes)->first();
		$last_visited = Domain::where('status', 1)->orderBy('last_visit', 'DESC')->first();	
		
		$format_anchor = function($anchor, $limit = 100)
		{			
			if(strlen($anchor) > $limit)
			{	
				return substr($anchor, 0, $limit).'...';
			}else{
				return $anchor;
			}	
		};
		?>
		<h4 class="bottom">{{ trans('directory.sataistics') }}</h4>
		<p>
			{{ trans('directory.most_viewed') }}:
			<a href="{{ Domain::seoURL($most_viewed->id) }}">
				{{ $format_anchor($most_viewed->name) }}
			</a>			
		</p>	
		<p>
			{{ trans('directory.most_upvoted') }}:
			<a href="{{ Domain::seoURL($most_voted->id) }}">
				{{ $format_anchor($most_voted->name) }}
			</a>
		</p>
		<p>
			{{ trans('directory.last_visited') }}:
			<a href="{{ Domain::seoURL($last_visited->id) }}"> 
				{{ $format_anchor($last_visited->name) }}
			</a>
		</p>	
		<p>{{ trans('directory.domains_statistics_all') }}: {{ count(Domain::all()) }}</p>		
		<p>{{ trans('directory.pending_domains') }}: {{ count(Domain::where('status', 0)->get()) }}</p>
		<p>{{ trans('directory.categories') }}: {{ count(Category::all()) }}</p>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<?php
		$prefered_domain = Domain::where('status', 1)
			->where('created_at', '>', \Carbon\Carbon::today())//->startOfWeek())
			->orderBy('created_at')
			->first();
		
//		if('5.2.200.90' == $_SERVER['REMOTE_ADDR'])
//		{
//			var_dump($prefered_domain->name);
//		}
		
		if( ! $prefered_domain)
		{
			$prefered_domain = Domain::where('status', 1)
				->orderBy('created_at', 'DESC')
				->first();
		}
		?>
		<h4>Promovat</h4>
		<a class="a-no-dec" href="{{ Domain::seoURL($prefered_domain->id) }}">
			<div class="weekly-promoted">	
				<p>{{ $prefered_domain->name }}</p>
				<p class="grey">{{ substr($prefered_domain->description, 0, 150) }} {{ trans('general.more') }}</p>
			</div>	
		</a>	
	</div>	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
		Copyright &copy; {{ date('Y'), '&nbsp;', Lang::get('general.main-url') }}		
	</div>	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
		<a href="{{ URL::route('terms') }}">{{ trans('general.terms') }}</a>
	</div>
</div>