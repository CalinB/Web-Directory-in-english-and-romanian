@extends('master')

@section('content')

<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('auth.register_help') }}
		</p>
		<p>
			<a href="{{ URL::route('password-remind') }}">{{ trans('auth.password_forgotten') }}</a>
		</p>	
		<p>
			<a href="{{ URL::route('resend-validation') }}">{{ trans('auth.resend_validation') }}</a>
		</p>
	</div>

	<div class="col-md-7">
		<h3>{{ trans('auth.sign_up_form') }}</h3>

		@if(Session::has('error'))
			<div class="alert alert-danger">
				<p>{{ Session::get('error') }}</p>
			</div>
		@endif
		@if(Session::has('info'))
			<div class="alert alert-info">
				<p>{{ Session::get('info') }}</p>
			</div>
		@endif
		@if(Session::has('success'))
			<div class="alert alert-success">
				<p>{{ Session::get('success') }}</p>
			</div>
		@endif

		{{ Form::open(['route' => 'register.post']) }}

			<div class="form-group">
				{{ Form::label('inputEmail', 'Email', ['class' => 'required-field']) }}
				{{ Form::email('email', null, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email']) }}		    
				{{ $errors->first('email', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="form-group">
				{{ Form::label('firstname', trans('auth.firstname')) }}
				{{ Form::text('firstname', '', ['class' => 'form-control', 'id' => 'firstname', 'placeholder' => trans('auth.firstname')]) }}
				{{ $errors->first('firstname', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="form-group">
				{{ Form::label('lastname', trans('auth.lastname')) }}
				{{ Form::text('lastname', '', ['class' => 'form-control', 'id' => 'lastname', 'placeholder' => trans('auth.lastname')]) }}
				{{ $errors->first('lastname', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="form-group">
				{{ Form::label('inputPassword', trans('auth.password'), ['class' => 'required-field']) }}
				{{ Form::password('password', ['class' => 'form-control required', 'id' => 'inputPassword', 'placeholder' => trans('auth.password')]) }}
				{{ $errors->first('password', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="form-group">
				{{ Form::label('inputRePassword', trans('auth.re_password'), ['class' => 'required-field']) }}
				{{ Form::password('password_confirmation', ['class' => 'form-control required', 'id' => 'inputRePassword', 'placeholder' => trans('auth.re_password')]) }}
				{{ $errors->first('password_confirmation', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>
			<div class="form-group">
				{{ Form::captcha(array('theme' => 'blackglass')) }}
				{{ $errors->first('g-recaptcha-response', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>
			<div class="checkbox">
				<label class="required-field"><input type="checkbox" name="terms"><a href="{{ URL::route('terms') }}">{{ trans('auth.terms_agree') }}</a></label>
				{{ $errors->first('terms', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			{{ Form::submit(trans('auth.sign_up'), ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}

	</div>	
	
</div>	

@stop