jQuery(document).ready(function(e) {
   jQuery('.rating_scaleli').keypress(function(e) {
		if (e.which == 13)
		{
			select_rating(this);
		}
	});
	jQuery('.rating_scaleli').focus(function(e) {
		add_focus(this);
	});
	jQuery('.rating_scaleli').focusout(function(e) {
		remove_focus(this);
	});
	jQuery('.rating_scaleli').mouseover(function(e) {
		add_focus(this);
	});
	jQuery('.rating_scaleli').mouseout(function(e) {
		remove_focus(this);
	});
});

function add_focus(ref)
{
	var area = true; 
	jQuery(ref).parents("ul").children("li.rating_scaleli").each(function(index, element)
	{
        if(jQuery(this).hasClass("selectedli"))
		{
			area = false;
		}
    });
	if(area == true)
	{
		var desc = jQuery(ref).children(".rating_scale_description").text();
		jQuery(ref).css("background-color", "#0CF");
		jQuery(ref).parents("ul").next("div.gat_scaledescription_cntnr").css("display", "block").text(desc);
	}
}

function remove_focus(ref)
{
	var area = true; 
	jQuery(ref).parents("ul").children("li.rating_scaleli").each(function(index, element)
	{
        if(jQuery(this).hasClass("selectedli"))
		{
			area = false;
		}
    });
	if(area == true)
	{
		jQuery(ref).css("background-color", "");
		jQuery(ref).parents("ul").next("div.gat_scaledescription_cntnr").css("display", "none");
	}
}

function select_rating(ref)
{
	jQuery(ref).parents("ul").children("li.rating_scaleli").each(function(index, element)
	{
		if(jQuery(this).attr("data-rating") != jQuery(ref).attr("data-rating"))
		{
			jQuery(this).removeClass("selectedli");
			jQuery(this).parents("ul").next("div.gat_scaledescription_cntnr").removeClass("selectedarea");
			jQuery(this).css("background-color", "");
			jQuery(this).children("input").val('');
		}
	});
	if(jQuery(ref).hasClass("selectedli"))
	{
		jQuery(ref).removeClass("selectedli");
		jQuery(ref).parents("ul").next("div.gat_scaledescription_cntnr").removeClass("selectedarea");
		jQuery(ref).parents("ul").next("div.gat_scaledescription_cntnr").text('');
		jQuery(ref).children("input").val('');
	}
	else
	{
		jQuery(ref).addClass("selectedli");
		jQuery(ref).parents("ul").next("div.gat_scaledescription_cntnr").addClass("selectedarea");
		
		jQuery(ref).children("input").val(jQuery(ref).attr("data-rating"));
		var desc = jQuery(ref).children(".rating_scale_description").text();
		jQuery(ref).parents("ul").next("div.gat_scaledescription_cntnr").text(desc);
	}
	var formdata = jQuery('#assessment_data').serialize();
	jQuery.ajax({
		url: ajaxurl,
		type: "post",
		data: formdata+"&action=save_assessment",
		success: function(msg)
		{
			jQuery(".gat_indicatorwidget").children(".meter").children("span").css("width", msg+"%").text(msg+"%");
		}
	});
}
function priority_submit(ref)
{
	var value = jQuery(ref).val();
	var action =jQuery("#gat_priorityfrm").attr("action");
	window.location = action+''+value;
}
function gat_districtcode(ref)
{
	var state = jQuery(ref).val();
	jQuery.ajax({
		url: ajaxurl,
		type: "post",
		data: "state="+state+"&action=gat_districtcode",
		success: function(msg)
		{
			jQuery(ref).parents(".form-group").next(".form-group").html(msg);
		}
	});
}