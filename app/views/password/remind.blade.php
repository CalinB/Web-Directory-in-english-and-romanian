@extends('master')

@section('content')
<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('auth.reset_password_help') }}
		</p>	
		<p>
			<a href="{{ URL::route('resend-validation') }}">{{ trans('auth.resend_validation') }}</a>
		</p>
	</div>
	<div class="col-sm-7">

		@if(Session::has('error'))
			<div class="alert alert-danger">
				<p>{{ Session::get('error') }}<p>
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
		@if(Session::has('status'))
			<div class="alert alert-info">
				<p>{{ Session::get('status') }}</p>
			</div>	
		@endif
    
    {{ Form::open(['route' => 'password-remind.post']) }}
        <div class="form-group">
			{{ Form::label('inputEmail', 'Email', ['class' => 'required-field']) }}
			{{ Form::email('email', null, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email']) }}
			{{ $errors->first('email', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::captcha(array('theme' => 'blackglass')) }}
			{{ $errors->first('g-recaptcha-response', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
	
        <div class="form-group">
            {{ Form::submit(trans('general.send_email'), ['class' => 'btn btn-primary']) }}
        </div>
    {{ Form::close() }}

    </div>
</div>	

@stop

