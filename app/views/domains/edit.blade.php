@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ Lang::get('directory.add_domain_help', ['register_url' => HTML::decode(HTML::link('users/register', '<span class="glyphicon glyphicon-user"></span> ' . trans('auth.sign_up')))]) }}
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

		{{ Form::open(['route' => 'domain.edit.post']) }}
		
		{{ Form::hidden('id', $domain->id) }}
		
		<div class="form-group">
			{{ Form::label(trans('directory.select_category')) }}	
						
			<?php echo Acl::categorySelect($domain->category_id) ?>
			
			{{ $errors->first('category_id', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			
			<p>{{ HTML::link('category/create', trans('directory.add_category')) }}</p>
			
			{{ $errors->first('parent_id', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label('inputName', trans('directory.name'), ['class' => 'required-field']) }}	
			<p class="small">{{ trans('directory.domain_name_rules') }}</p>
			{{ Form::text('name', $domain->name, ['class' => 'form-control', 'id' => 'inputName', 'placeholder' => trans('directory.name')]) }}
			{{ $errors->first('name', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>	
		<div class="form-group">
			{{ Form::label('inputUrl', trans('directory.url'), ['class' => 'required-field']) }}
			{{ Form::text('url', $domain->url, ['class' => 'form-control']) }}
			{{ $errors->first('url', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			{{ $errors->first('format_url', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>	
		<div class="form-group">
			{{ Form::label('inputDescription', trans('directory.description'), ['class' => 'required-field']) }}
			<p class="small">{{ trans('directory.domain_description_rules') }}</p>
			{{ Form::textarea('description', $domain->description, ['class' => 'form-control', 'rows' => '5']) }}
			{{ $errors->first('description', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label(trans('directory.keywords')) }}	
			{{ Form::textarea('keywords', $domain->keywords, ['class' => 'form-control', 'rows' => '3']) }}
			{{ $errors->first('keywords', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		
		@if( ! Auth::check())
		<div class="form-group">
			{{ Form::captcha(array('theme' => 'blackglass')) }}
			{{ $errors->first('g-recaptcha-response', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		@endif
		<div class="form-group">
			{{ Form::submit(trans('general.update'), ['class' => 'btn btn-primary', 'onClick' => 'ShowProgressAnimation();']) }}
		</div>
		{{ Form::close() }}
	</div>	
</div>	

@stop