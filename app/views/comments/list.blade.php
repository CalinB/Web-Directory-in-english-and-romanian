<?php

	$comments = Comment::where('domain_id', $domain->id);
	
	if( ! Acl::isSuperAdmin())
	{
		$comments = $comments->where('status', 1);
	}
	
	$comments = $comments->orderBy('created_at', 'DESC')->get();
?>

<div class="col-md-12 bottom" style="background-color: #FFF;">
	<h4 style="margin-bottom: 20px;">{{ trans('directory.comments') }} ( {{ $comments->count() }} )</h4>	
</div>
@if(empty($comments))
	{{ trans('directory.no_comments') }}
@else

	@foreach($comments as $comment)
		<div class="bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 20px 0;">
			<?php
			$adder = (User::find($comment->user_id)) ? User::find($comment->user_id)->firstname : trans('general.anonymous_user');
			?>
			{{ trans('general.in') }} {{ date("d-m-Y", strtotime($comment->created_at)) }} {{ $comment->user_id }} {{ $adder }} {{ trans('general.wrote') }}:<br />
			<q>{{ $comment->comment }}</q>
			<br />
			@if(Acl::isSuperAdmin())
				<div class="col-xs-4">
					<a href="{{ URL::route('comment-edit', [$comment->id]) }}" class="btn btn-info"> 
						{{ trans('general.edit') }}
					</a>
				</div>	
				{{ Form::open(['route' => 'approve-disapprove-comment', 'class' => 'col-xs-4 form-horizontal']) }}	
					{{ Form::hidden('id', $comment->id) }}

					@if($comment->status == 0)					 
						{{ Form::submit(trans('general.approve'), ['class' => 'btn btn-info']) }}
						{{ Form::hidden('status', 1) }}
					@else
						{{ Form::submit(trans('general.disapprove'), ['class' => 'btn btn-info']) }}
						{{ Form::hidden('status', 0) }}
					@endif
				{{ Form::close() }}
				
				{{ Form::open(['route' => 'comment-delete', 'class' => 'col-xs-4 form-horizontal']) }}	
					{{ Form::hidden('id', $comment->id) }}

					{{ Form::submit(trans('general.delete'), ['class' => 'btn btn-info']) }}
				{{ Form::close() }}	
			@endif	
		</div>
	@endforeach
@endif