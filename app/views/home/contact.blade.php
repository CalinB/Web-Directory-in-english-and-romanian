@extends('master')

@section('content')

<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('general.contact_help') }}
		</p>
	</div>
	
	<div class="col-md-7">

		<h3>{{ trans('general.contact_form') }}</h3>

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

		{{ Form::open(['route' => 'contact.post']) }}

			<div class="form-group">
				{{ Form::label('inputEmail', 'Email', ['class' => 'required-field']) }}
				{{ Form::email('email', $sender_email, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email']) }}
				{{ $errors->first('email', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>
			<div class="form-group">
				{{ Form::label('inputName', trans('general.name')) }}
				{{ Form::text('name', '', ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('general.name')]) }}
				{{ $errors->first('name', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>
			<div class="form-group">
				{{ Form::label('inputReason', trans('general.reason'), ['class' => 'required-field']) }}
				{{ Form::textarea('reason', null, ['class' => 'form-control', 'placeholder' => trans('general.reason')]) }}
				{{ $errors->first('reason', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>
			<div class="form-group">
				{{ Form::captcha(array('theme' => 'blackglass')) }}
				{{ $errors->first('g-recaptcha-response', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>
			
			{{ Form::submit(trans('general.send'), ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
	</div>

</div>

@stop