@extends('master')

@section('content')

<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('user.account_edit_help') }}
		</p>
		<p>
			<a href="{{ URL::route('password-remind') }}">{{ trans('auth.password_forgotten') }}</a>
		</p>
	</div>

	<div class="col-md-7">
		<h3>{{ trans('user.account_edit_form') }}</h3>

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

		{{ Form::open(['route' => 'user.edit.post']) }}

			<div class="form-group">
				<div class="alert alert-info">
					<p class="small"><span class="glyphicon glyphicon-info-sign"></span> {{ trans('user.email_change_info') }}</p>
				</div>>	
				{{ Form::label('inputEmail', 'Email', ['class' => 'required-field']) }}
				{{ Form::email('email', $user->email, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email']) }}		    
				{{ $errors->first('email', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="form-group">
				{{ Form::label('firstname', trans('auth.firstname')) }}
				{{ Form::text('firstname', $user->firstname, ['class' => 'form-control', 'id' => 'firstname', 'placeholder' => trans('auth.firstname')]) }}
				{{ $errors->first('firstname', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			<div class="form-group">
				{{ Form::label('lastname', trans('auth.lastname')) }}
				{{ Form::text('lastname', $user->lastname, ['class' => 'form-control', 'id' => 'lastname', 'placeholder' => trans('auth.lastname')]) }}
				{{ $errors->first('lastname', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			</div>

			{{ Form::submit(trans('general.update'), ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}

	</div>	
	
</div>	

@stop