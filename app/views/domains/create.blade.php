@extends('master')

@section('content')
<div class="row">
	
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 aside">
		<h2>{{ trans('general.info') }}</h2>
		<p>
			{{ Lang::get('directory.add_domain_help', ['register_url' => HTML::decode(HTML::link('users/register', '<span class="glyphicon glyphicon-user"></span> ' . trans('auth.sign_up')))]) }}
		</p>
	</div>	
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

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
		
		<div class="form-group">
			{{ Form::label(trans('directory.select_category')) }}	
						
			<?php 
			$category_id = Session::get('category_id');
			
			$selected = null;
			if($category_id != 0)
			{
				$selected = $category_id;
			}
			echo isset($selected) ? Acl::categorySelect($selected) : Acl::categorySelect(); 
			?>
			
			{{ $errors->first('category_id', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			
			<p>{{ HTML::link('category/create', trans('directory.add_category')) }}</p>
			
			{{ $errors->first('parent_id', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label('inputUrl', trans('directory.url'), ['class' => 'required-field', 'placeholder' => trans('directory.url')]) }}
			{{ Form::text('url', null, ['class' => 'form-control']) }}
			{{ $errors->first('url', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
			@if(Session::has('url_error'))
				<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>{{ Session::get('url_error') }}</div>
			@endif	
		</div>
		<div class="form-group">
			{{ Form::label('inputName', trans('directory.name').' (ancor&#259;)', ['class' => 'required-field']) }}
			<p class="alert alert-info">
				<span class="glyphicon glyphicon-exclamation-sign"></span>
				{{ trans('directory.anchor_info') }}
			</p>
			<p class="small">{{ trans('directory.domain_name_rules') }}</p>
			{{ Form::text('name', null, ['class' => 'form-control', 'id' => 'inputName', 'placeholder' => trans('directory.name')]) }}
			{{ $errors->first('name', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>			
		<div class="form-group">
			{{ Form::label('inputDescription', trans('directory.description'), ['class' => 'required-field']) }}			
			<p class="alert alert-info">
				<span class="glyphicon glyphicon-exclamation-sign"></span>
				{{ trans('directory.description_info') }}
			</p>
			
			<p class="small">{{ trans('directory.domain_description_rules') }}</p>
			{{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => trans('directory.description')]) }}
			{{ $errors->first('description', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		<div class="form-group">
			{{ Form::label(trans('directory.keywords')) }}	
			{{ Form::textarea('keywords', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => trans('directory.keywords')]) }}
			{{ $errors->first('keywords', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		
		@if( ! Auth::check())
		<div class="form-group">
			{{ Form::captcha(array('theme' => 'blackglass')) }}
			{{ $errors->first('g-recaptcha-response', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
		</div>
		@endif
		<div class="form-group">
			{{ Form::submit(trans('general.add'), ['class' => 'btn btn-primary', 'onClick' => 'ShowProgressAnimation();']) }}
		</div>
		{{ Form::close() }}		
	</div>	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">			
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
	<div class="modal fade" id="note-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">				
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Te rog cite&#x219;te<span id="product-name"></span></h4>				
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="submit-note"></div>
				</div>
				<div class="modal-body">	
					<p class="alert alert-info">
						<span class="glyphicon glyphicon-exclamation-sign"></span>
						Nu pierde timpul cu &#238;nscrisul &#238;n acest director dac&#259; nu ai de g&#226;nd 
						s&#259; cite&#x219;ti condi&#539;iile de aprobare!
						<br /><br /><br />
						<button data-dismiss="modal" class="btn btn-success" onclick="document.cookie='informed=yes'">De acord</button>
						<button class="btn btn-danger" onclick="location.href = 'http://www.google.com';">Nu sunt de acord</button>
					</p>	
				</div>
			</div>
		</div>
	</div>
</div>	

<script type="text/javascript">
	$(window).load(function()
	{
		if (document.cookie.indexOf("informed") < 0) 
		{
			$('#note-modal').modal('show');
		}		
	});	
</script>

@stop