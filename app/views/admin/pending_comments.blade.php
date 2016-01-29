@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('directory.list_domain_help') }}
		</p>
	</div>
	
	<div class="col-md-8">
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
		
		<h3 class="bottom">{{ trans('directory.comments') }}</h3>

		@foreach($comments as $comment)
		<div class="col-sm-6 bottom">
			<p>
				<a href="{{ Domain::seoURL($comment->domain_id) }}">{{ Domain::find($comment->domain_id)->name }}</a>
			</p>
			<p>{{ $comment->comment }}</p>
			<div class="col-xs-4">
				<a class="btn btn-info" href="{{ URL::route('comment-edit', [$comment->id]) }}">Edit</a>
			</div>	
			{{ Form::open(['route' => 'approve-disapprove-comment', 'class' => 'col-xs-4']) }}	
				{{ Form::hidden('id', $comment->id) }}

				@if($comment->status == 0)					 
					{{ Form::submit(trans('general.approve'), ['class' => 'btn btn-info']) }}
					{{ Form::hidden('status', 1) }}
				@else
					{{ Form::submit(trans('general.disapprove'), ['class' => 'btn btn-info']) }}
					{{ Form::hidden('status', 0) }}
				@endif
			{{ Form::close() }}
			
			{{ Form::open(['route' => 'comment-delete', 'class' => 'col-xs-4']) }}	
				{{ Form::hidden('id', $comment->id) }}

				{{ Form::submit(trans('general.delete'), ['class' => 'btn btn-info']) }}
			{{ Form::close() }}
		</div>	
		@endforeach
            </div>    
	</div>
	<div class="col-md-12">
		<div class="pagination">
			{{ $comments->links() }}
		</div>	
	</div>
</div>	
@stop