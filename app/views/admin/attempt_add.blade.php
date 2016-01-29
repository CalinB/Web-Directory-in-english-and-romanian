@extends('master')

@section('content')
<div class="row">
	<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">

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

		{{ Form::open(['route' => 'domain.create.post']) }}
		
		{{ Form::hidden('id', $attempt->id) }}
		
		<div class="form-group">
			{{ Form::label(trans('directory.select_category')) }}	
						
			<?php echo Acl::categorySelect($attempt->category_id) ?>
			
			{{ $errors->first('category_id', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			
			<p>{{ HTML::link('category/create', trans('directory.add_category')) }}</p>
			
			{{ $errors->first('parent_id', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label('inputName', trans('directory.name'), ['class' => 'required-field']) }}	
			<p class="small">{{ trans('directory.domain_name_rules') }}</p>
			{{ Form::text('name', $attempt->name, ['class' => 'form-control', 'id' => 'inputName', 'placeholder' => trans('directory.name')]) }}
			{{ $errors->first('name', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>	
		<div class="form-group">
			{{ Form::label('inputUrl', trans('directory.url'), ['class' => 'required-field']) }}
			{{ Form::text('url', $attempt->url, ['class' => 'form-control']) }}
			{{ $errors->first('url', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			{{ $errors->first('format_url', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>	
		<div class="form-group">
			{{ Form::label('inputDescription', trans('directory.description'), ['class' => 'required-field']) }}
			<p class="small">{{ trans('directory.domain_description_rules') }}</p>
			{{ Form::textarea('description', $attempt->description, ['class' => 'form-control', 'rows' => '5']) }}
			{{ $errors->first('description', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label(trans('directory.keywords')) }}	
			{{ Form::textarea('keywords', $attempt->keywords, ['class' => 'form-control', 'rows' => '3']) }}
			{{ $errors->first('keywords', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>

		<div class="form-group">
			{{ Form::submit(trans('general.update'), ['class' => 'btn btn-primary', 'onClick' => 'ShowProgressAnimation();']) }}
		</div>
		{{ Form::close() }}
	</div>	
</div>	

@stop