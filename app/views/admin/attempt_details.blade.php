@extends('master')

@section('content')

<?php
//dd(is_object($attempt));
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
		<div class="row">
			<h2 class="bottom">
				<span class="glyphicon glyphicon-link"></span><a href="{{ $attempt->url }}" target="_blank">{{ $attempt->name }}</a>
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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
				<p class="bottom">{{ trans('directory.category') }}: {{ $category }}</p>
				<p class="bottom">{{ trans('directory.added_date') }}: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($attempt->created_at))->formatLocalized('%d %B %Y') }}</p>
				<p class="bottom">{{ trans('directory.url') }}: {{ $attempt->url }}</p>
			</div>	
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php
				$desc = strlen(str_replace(' ', '', $attempt->description)) - 200;
				?>
				<p>{{ trans('directory.description') }} [ {{ $desc }} ]:</p>
				<p class="bottom" style="clear: both; float: left; background-color: #FFF; padding: 10px;">				
					{{ $attempt->description }}
				</p>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p>{{ trans('directory.keywords') }}:</p>
				<p class="bottom">{{ $attempt->keywords }}</p>
			</div>
			
			<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h2>Actiuni attempt</h2>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">	
					<a onClick="return confirm('Are you sure?');" href="{{ URL::route('attempt.delete', [$attempt->id]) }}" class="btn btn-info"> 
						{{ trans('general.delete') }}
					</a>	
				</div>	
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<a href="{{ URL::route('attempt.add', [$attempt->id]) }}" class="btn btn-info"> 
						Adaug&#259;
					</a>
				</div>
			</div>
			
			<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">	
				<h2>Domenii similare [ {{ $similar_domains->count() }} ]</h2>
				@if($similar_domains->count())
					<table class="table-striped">
						<tr>
							<th>ID</th>
							<th>Status</th>
							<th>Name</th>
							<th>URL</th>
							<th>Description</th>
							<th>Created at</th>
						</tr>	
					@foreach($similar_domains as $similar_domain)
						<tr>
							<td>{{ $similar_domain->id }}</td>
							<td style="text-align: center;">{{ $similar_domain->status }}</td>
							<td>{{ $similar_domain->name }}</td>
							<td>{{ $similar_domain->url }}</td>
							<td>{{ $similar_domain->description }}</td>
							<td>{{ $similar_domain->created_at }}</td>
						</tr>
					@endforeach
					</table>
				@endif
			</div>
		</div>				
	</div>
</div>

@stop