@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('auth.new_password_help') }}
		</p>	
		<p>
			{{ trans('auth.register_help') }}
		</p>
		<p>
			<a href="{{ URL::route('resend-validation') }}">{{ trans('auth.resend_validation') }}</a>
		</p>
	</div>
	<div class="col-sm-7">

		<h2>{{ trans('auth.set_new_password') }}</h2>

		@if(Session::has('error'))
			<div class="alert alert-danger">
				<h2>{{ Session::get('error') }}</h2>
			</div>
		@endif
		@if(Session::has('info'))
			<div class="alert alert-info">
				<h2>{{ Session::get('info') }}</h2>
			</div>
		@endif
		@if(Session::has('success'))
			<div class="alert alert-success">
				<h2>{{ Session::get('success') }}</h2>
			</div>
		@endif

		{{ Form::open(['route' => 'password-reset.post']) }}
			<input type="hidden" name="token" value="{{ $token }}">

			<div class="form-group">
				{{ Form::label('inputEmail', 'Email', ['class' => 'required-field']) }}
				{{ Form::email('email', null, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email']) }}
				{{ $errors->first('email', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
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
			
			<div class="form-group">
				{{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
			</div>
		{{ Form::close() }}

		@if (Session::has('error'))
			<p style="color: red;">{{ Session::get('error') }}</p>
		@endif
	</div>
</div>	

@stop
