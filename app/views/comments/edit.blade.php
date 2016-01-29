@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('directory.add_comment_info') }}
		</p>
	</div>	
	<div class="col-md-7">

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

		<h3>{{ trans('directory.edit_comment') }} {{ trans('general.for') }} {{ $comment->domain->name }}</h3>
		
		{{ Form::open(['route' => 'comment-edit.post']) }}
			{{ Form::hidden('id', $comment->id) }}
			<div class="form-group">
				{{ Form::label('inputComment', trans('directory.comment'), ['class' => 'required-field']) }}
				{{ Form::textarea('comment', $comment->comment, ['class' => 'form-control', 'rows' => '5']) }}
				{{ $errors->first('comment', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>
			<div class="form-group">
				{{ Form::submit(trans('general.edit'), ['class' => 'btn btn-primary', 'onClick' => 'ShowProgressAnimation();']) }}
			</div>
		
		{{ Form::close() }}
	</div>	
</div>	

@stop