<div id="add-comment" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<h3>{{ trans('directory.add_comment') }} {{ trans('general.for') }} {{ $domain->name }}</h3>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">							
							<div class="alert alert-success" id="success-info" style="display: none;"></div>
						</div>
						<form id="add-form" action="#">
							{{ Form::hidden('domain_id', $domain->id) }}
							<div class="form-group">
								{{ Form::label('inputComment', trans('directory.comment'), ['class' => 'required-field']) }}
								<p class="small">{{ trans('directory.comment_rules') }}</p>
								{{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}
								{{ $errors->first('comment', '<div class="alert alert-danger small"><a href="#" class="close" data-dismiss="alert">&times;</a>:message</div>') }}
							</div>
							<div class="form-group">
								<button id="submit-comment" disabled="disabled" class="btn btn-primary" onClick="ShowProgressAnimation();">
									{{ trans('general.add') }}
								</button>
							</div>
						</form>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<span class="glyphicon glyphicon-info-sign"></span>
						{{ trans('directory.add_comment_info') }}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close') }}</button>
			</div>
		</div>

	</div>
</div>
<script>
	$('textarea[name=comment]').keyup(function() 
	{
		var comment_length = $('textarea[name=comment]').val().length;
		
		if(comment_length > 10)
		{
			$('#submit-comment').prop('disabled', false);
		}
		else
		{
			$('#submit-comment').prop('disabled', true);
		}	
	});	
	
	$('#submit-comment').click(function(e)
	{
		e.preventDefault();
		
		var comment_length = $('textarea[name=comment]').val().length;
		
		if(comment_length < 10)
		{
			$('#success-info').html('<?php echo trans('directory.comment_rules') ?>');
		}
		else
		{	
			$.ajax({
				url: "<?php echo URL::route('add-comment.post') ?>",
				type: "POST",
				data: $("#add-form").serialize(),
				success: function (response) {
					$("#add-form").hide();
					hideProgressAnimation();
					$('#success-info').html(response);
					$('#success-info').show();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			});
		}
	});
</script>