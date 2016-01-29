/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function seoString(string) {
	
	var res1 = string.toLowerCase();
			
	res1 = res1.replace(/[^a-zA-Z0-9]/g,'-');
	res1 = res1.replace(/\-+/g,'-');
	
	var re = /-$/;
	res1 = res1.replace(re, "");
		
	return res1;
}

function showDiv(div_id, button) {
   document.getElementById(div_id).style.display = "block";
   document.getElementById(button).style.display = "none";
}

function ShowProgressAnimation(){
	$('#loading-div-background').show();
}

function hideProgressAnimation(){
	$('#loading-div-background').hide();
}

$(document).mouseup(function (e)
{
    var container = $("#search-results");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
});

$(document).ready(function () 
{	
	$('#serch_term').keyup(function ()
	{
		var search_route = $('#serch_term').data('route');
		var search_term  = $('#serch_term').val();
		
		if(search_term.length > 2)
		{	
			$.ajax({
				type: 'POST',
				url: search_route,
				data: { 'search_term': search_term },
				success: function(res){
					$('#search-results').show().html(res);
				}
			});
		}	
	});
	
	if( ! jQuery.browser.mobile) 
	{	
		$("#mobile-notice").show().effect( "slide", {times:10}, "slow" );
	}
	
	$.cookieBar({
		fixed: true
	});

	$('#choose-parent').hide();

	$('input[name="name"]').on('change keyup keydown paste select', function () {

		var res = seoString($(this).val());

		$('input[name="path"]').val(res);

	});

	$('input[name="is_root"]').on('change', function() {

		if($('#is-root-yes').is(':checked')) 
		{ 
			$("#choose-parent").hide(); 
		}
		if($('#is-root-no').is(':checked')) 
		{ 
			$("#choose-parent").show(); 
		}
	});
	if($('#is-root-yes').is(':checked')) 
	{ 
		$("#choose-parent").hide(); 
	}
	if($('#is-root-no').is(':checked')) 
	{ 
		$("#choose-parent").show(); 
	}
	
	$('input[name="url"]').on('focus', function() 
	{
		$(this).val('http://');
	});

});

$(window).scroll(function() {

    if ($(window).scrollTop() > 0)
	{
		$('#menubar-top').css('position', 'fixed');
	}
	else
	{
		$('#menubar-top').css('position', 'relative');
	}
});	
