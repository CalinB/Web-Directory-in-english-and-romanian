@extends('master')

@section('description')
	{{ $domain->description }}
@stop
@section('keywords')
	{{ $domain->keywords }}
@stop

@section('content')
      
<div class="row">	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ Lang::get('directory.details_domain_help', ['domain' => $domain->name]) }}
		</p>
		<p>
			<a href="{{ URL::route('domain.create') }}">{{ trans('directory.add_domain') }}</a>
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
		<div class="row">
			<h2 class="bottom">
				<span class="glyphicon glyphicon-link"></span><a href="{{ $domain->url }}" target="_blank">{{ $domain->name }}</a>
			</h2>			
		</div>	
		<div class="row">	
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
		</div>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<img class="img img-responsive thumbnail" src="{{URL::asset('assets/thumbs/'.$domain->thumb)}}" alt="site preview" />
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">				
				<p class="bottom">{{ trans('directory.category') }}: {{ HTML::link('category/details/' . $category->path, $category->name) }}</p>
				<p class="bottom">{{ trans('directory.page_rank') }}: {{ $domain->page_rank }}</p>
				<p class="bottom">{{ trans('directory.alexa_rank') }}: {{ DirectoryHelpers::getAlexaRank($domain->url) }}</p>
				<p class="bottom">{{ trans('directory.google_indexed_pages') }}: {{ DirectoryHelpers::getGoogleCount($domain->url) }}</p>
				<p class="bottom">{{ trans('directory.added_date') }}: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($domain->created_at))->formatLocalized('%d %B %Y') }}</p>
				<p class="bottom">{{ trans('directory.url') }}: {{ $domain->url }}</p>
				<p class="bottom">{{ trans('directory.site_visits') }}: {{ $domain->hits }}</p>	
				<p class="bottom">{{ trans('directory.last_visit') }}: {{ DirectoryHelpers::lastVisited($domain->last_visit) }}</p>
			</div>	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bottom">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="col-xs-5 text-right">
						<a href="#" class="vote" data-vote="votes_up">
							<span class="glyphicon glyphicon-thumbs-up"></span></a>&nbsp;&nbsp;<span id="votes-up">{{ $domain->votes_up }}</span>
					</div>	
					<div class="col-xs-5">
						<a href="#" class="vote" data-vote="votes_down">
							<span class="glyphicon glyphicon-thumbs-down"></span></a>&nbsp;&nbsp;<span id="votes-down">{{ $domain->votes_down }}</span>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<!-- Place this tag where you want the su badge to render -->
					<su:badge layout="2"></su:badge>

					<!-- Place this snippet wherever appropriate -->
					<script type="text/javascript">
					  (function() {
						var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
						li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
					  })();
					</script>
					<a class="twitter-share-button" href="https://twitter.com/share">Tweet</a>
					<script>
					window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
					</script>
					<div class="fb-share-button" data-href="{{ Request::url() }}" data-layout="button_count"></div>	
				</div>	
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p>{{ trans('directory.description') }}:</p>
				<p class="bottom" style="clear: both; float: left; background-color: #FFF; padding: 10px;">				
					{{ $domain->description }}
				</p>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p>{{ trans('directory.keywords') }}:</p>
				<p class="bottom">{{ $domain->keywords }}</p>
			</div>
				
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				@include('comments.create')
				<button type="button" style="margin: 10px 0;" class="btn btn-info" 
						data-toggle="modal" data-target="#add-comment">
					{{ trans('directory.add_comment') }}
				</button>
				@include('comments.list')
			</div>
			
			<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">	
				<h2>Actiuni site</h2>
				@if(Acl::isSuperAdmin())
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">	
						@if($domain->status == 0)
						<a href="{{ URL::route('domain.approve', ['id' => $domain->id]) }}" class="btn btn-info"> 
							{{ trans('general.approve') }}
						</a>
						@else
						<a href="{{ URL::route('domain.disapprove', [$domain->id]) }}" class="btn btn-info"> 
							{{ trans('general.disapprove') }}
						</a>
						@endif
					</div>
				@endif	
				@if(Acl::isAdmin($domain))					
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">	
						<a href="{{ URL::route('domain.edit', [$domain->id]) }}" class="btn btn-info"> 
							{{ trans('general.edit') }}
						</a>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">	
						<a onClick="return confirm('Are you sure?');" href="{{ URL::route('domain.delete', [$domain->id]) }}" class="btn btn-info"> 
							{{ trans('general.delete') }}
						</a>	
					</div>
				@endif				
			</div>
		</div>				
	</div>
</div>	

<script type="text/javascript">
	$(document).ready(function() {
		
		$('.vote').click(function(e) {
			
			e.preventDefault();
			
			var existing_vote_up = parseInt('<?php echo $domain->votes_up ?>');
			var existing_vote_down = parseInt('<?php echo $domain->votes_down ?>');
			var vote_type = $(this).data('vote');
			
			$.ajax({
				type: 'POST',
				url: "<?php echo URL::route('vote.site') ?>",
				data: { 
					'vote_type': vote_type,
					'id' : <?php echo $domain->id ?>
				},
				success: function(){
					if(vote_type === 'votes_up')
					{	
						var new_votes_up = "<?php echo URL::to('get/site/votes/votes_up/' . $domain->id) ?>";
						//$('#votes-up').html(new_votes_up);
						$('#votes-up').html(existing_vote_up + 1);
					}	
					if(vote_type === 'votes_down')
					{	
						$('#votes-down').html(existing_vote_down + 1);
					}
				}
			});
		});
	});
	
</script>

<?php
$domain->last_visit = \Carbon\Carbon::now();
$domain->save();
?>

@stop