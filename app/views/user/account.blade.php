@extends('master')

@section('content')

<div class="row">
	
	<div class="col-md-3 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ trans('user.account_help') }}
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
	
	<div class="col-md-8">
		
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
		
		<div class="row">
			<p>Email: {{ $user->email }}</p>
			<p>{{ trans('auth.lastname') }}: {{ $user->lastname }}</p>
			<p>{{ trans('auth.firstname') }}: {{ $user->firstname }}</p>
			<p>{{ trans('user.my_websites') }}: <a href="{{ URL::route('domain.user') }}">{{ $domains }}</a></p>
			
			
			<p><a href="{{ URL::route('user.edit') }}"> 
				<span class="glyphicon glyphicon-edit"></span> {{ trans('user.edit_account') }}
			</a></p>
			
			{{ Form::open(['route' => 'user.delete']) }}
				<!--span class="glyphicon glyphicon-trash"></span--> {{ Form::submit(trans('user.delete_account'), 
							['onClick' => 'return confirm("' . trans('user.confirm_delete') . '");', 'class' => 'btn btn-primary']) }}
			{{ Form::close() }}	
		
		</div>
	</div>	
</div>	

@stop