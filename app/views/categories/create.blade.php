@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('directory.add_category_help') }}
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

		<h3>{{ trans('directory.add_category') }}</h3>

		{{ Form::open(['route' => 'category.create.post']) }}
		<div class="form-group">
			<span class="required-field">{{ trans('directory.is_root') }}? </span>
			{{ Form::label('is-root-yes', trans('general.yes')) }} {{ Form::radio('is_root', 'yes', '', ['id' => 'is-root-yes']) }}
			{{ Form::label('is-root-no', trans('general.no')) }} {{ Form::radio('is_root', 'no', '', ['id' => 'is-root-no']) }}	
			{{ $errors->first('is_root', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group" id="choose-parent">
			{{ Form::label(trans('directory.parent_category')) }}	
			
			{{ Acl::renderCategoryHTMLSelect() }}
			
			{{ $errors->first('parent_id', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label('inputName', trans('directory.name'), ['class' => 'required-field']) }}	
			{{ Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName', 'placeholder' => trans('directory.name')]) }}
			{{ $errors->first('name', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>	
		<div class="form-group">
			{{ Form::label('inputPath', trans('directory.path'), ['class' => 'required-field']) }}
			{{ Form::text('path', null, ['class' => 'form-control']) }}
			{{ $errors->first('path', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>	
		<div class="form-group">
			{{ Form::label(trans('directory.description')) }}	
			{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) }}
			{{ $errors->first('description', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label(trans('directory.keywords')) }}	
			{{ Form::textarea('keywords', null, ['class' => 'form-control', 'rows' => '3']) }}
			{{ $errors->first('keywords', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::submit(trans('general.add'), ['class' => 'btn btn-primary', 'onClick' => 'ShowProgressAnimation();']) }}
		</div>
		{{ Form::close() }}
	</div>	
</div>	

@stop