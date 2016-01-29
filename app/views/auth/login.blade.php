@extends('master')

@section('content')

<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('auth.login_help') }}
		</p>
		<p>
			<a href="{{ URL::route('password-remind') }}">{{ trans('auth.password_forgotten') }}</a>
		</p>
		<p>
			<a href="{{ URL::route('resend-validation') }}">{{ trans('auth.resend_validation') }}</a>
		</p>
	</div>
	
	<div class="col-md-7">

		<h2>{{ trans('auth.login') }}</h2>

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

		{{ Form::open(['route' => 'login.post']) }}

			<div class="form-group">
				{{ Form::label('inputEmail', 'Email', ['class' => 'required-field']) }}
				{{ Form::email('email', null, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email']) }}
				{{ $errors->first('email', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="form-group">
				{{ Form::label('inputPassword', trans('auth.password'), ['class' => 'required-field']) }}
				{{ Form::password('password', ['class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => trans('auth.password')]) }}
				{{ $errors->first('password', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="checkbox">
				<label><input type="checkbox" name="remeber_me"> {{ trans('auth.remeber_me') }}</label>
			</div>

			{{ Form::submit('Login', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
	</div>

</div>
@stop