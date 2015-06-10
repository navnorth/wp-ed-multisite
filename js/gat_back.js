function initareaodoo()
{
	return false;
	/*tinymce.init({
 		selector: "div.gat_editablediv",
		theme: "modern",
		plugins: [
			["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker"],
			["searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking"],
			["save table contextmenu directionality emoticons template paste"]
		],
		inline: true,
		toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image     | print preview media",
		statusbar: false
	});*/
}
function add_dimension(ref)
{
	var editorid = jQuery(ref).attr("data-editorid");
	var id = parseInt(editorid, 10);
	jQuery(ref).attr("data-editorid", id+1)
	jQuery.ajax({
			url: ajaxurl,
			type: "post",
			data: "editorid="+editorid+"&count="+(id+1)+"&action=addfield_call",
			success: function(msg)
			{
				update_anchor("add");
				jQuery(".gat_wrpr").append(msg);
			}
		});
}
function delete_dimension(ref)
{
	var dimensionid = jQuery(ref).attr("data-dimensionid");
	if(typeof dimensionid != 'undefined')
	{
		jQuery.ajax({
			url: ajaxurl,
			type: "post",
			data: "dimensionid="+dimensionid+"&action=delete_dimensions",
			success: function(msg)
			{
				jQuery(ref).parents(".gat_dimention_wrpr").addClass("removedele");
				jQuery(ref).parents(".removedele").removeClass("gat_dimention_wrpr");
				jQuery(ref).parents(".removedele").remove()
			}
		});
	}
	else
	{
		jQuery(ref).parents(".gat_dimention_wrpr").addClass("removedele");
		jQuery(ref).parents(".removedele").removeClass("gat_dimention_wrpr");
		jQuery(ref).parents(".removedele").remove()
	}
	update_anchor("delete");
	update_count();
}
function update_anchor(arg)
{
	var i = 1;
	var length = jQuery(".gat_dimention_wrpr").length;
	jQuery(".gat_dimention_wrpr").each(function()
	{
		if(i == 1)
		{
			jQuery(this).children(".gat_cntrlr_wrpr").children(".order").children(".order_anch").each(function() {
				if(jQuery(this).attr("data-order") == 'down')
				{
					jQuery(this).addClass("down");
				}
				if(jQuery(this).attr("data-order") == 'up')
				{
					jQuery(this).removeClass("up");
				}
			});
		}
		else
		{
			if(arg != 'add' && length == i)
			{
				jQuery(this).children(".gat_cntrlr_wrpr").children(".order").children(".order_anch").each(function() {
					if(jQuery(this).attr("data-order") == 'up')
					{
						jQuery(this).addClass("up");
					}
					if(jQuery(this).attr("data-order") == 'down')
					{
						jQuery(this).removeClass("down");
					}
				});
			}
			else
			{
				jQuery(this).children(".gat_cntrlr_wrpr").children(".order").children(".order_anch").each(function() {
					if(jQuery(this).attr("data-order") == 'down')
					{
						jQuery(this).addClass("down");
					}
					if(jQuery(this).attr("data-order") == 'up')
					{
						jQuery(this).addClass("up");
					}
				});
			}
		}
		i++;
	});
}
function update_count()
{
	var i = 1;
	jQuery(".gat_dimention_wrpr").each(function()
	{
		jQuery(this).children(".gat_cntrlr_wrpr").children(".count").text(i);
		i++;
	});
	jQuery(".gat_btnwrpr").children("a").attr("data-editorid", i-1)
}
function add_video(ref)
{
	var count = jQuery(ref).attr("data-count");
	var i = 0;
	jQuery(ref).parents(".gat_fldwrpr").children(".gat_fldinsidewrpr").children(".gat_table").children("tbody").children("tr").each(function(index, element) {
        i++;
    });
	var dimension = "dimension_"+count;
	jQuery(ref).parents(".gat_fldwrpr").children(".gat_fldinsidewrpr").children(".gat_table").children("tbody").append('<tr><td><input type="text" name="'+dimension+'_videolabel[]" value="" /></td><td><input type="text" name="'+dimension+'_videoid[]" value="" /></td><td><input type="checkbox" name="'+dimension+'_ratingscale'+i+'[]" value="1" /></td><td><input type="checkbox" name="'+dimension+'_ratingscale'+i+'[]" value="2" /></td><td><input type="checkbox" name="'+dimension+'_ratingscale'+i+'[]" value="3" /></td><td><input type="checkbox" name="'+dimension+'_ratingscale'+i+'[]" value="4" /></td><td><a href="javascript:" onclick="delete_video(this)" class="button button-primary">Delete</a></td></tr>');
}
function delete_video(ref)
{
	jQuery(ref).parents("tr").remove();
}
function orderchange(ref)
{
    var order = jQuery(ref).attr("data-order");
	if(order == 'up')
	{
		jQuery(ref).parents('.gat_dimention_wrpr').insertBefore(jQuery(ref).parents('.gat_dimention_wrpr').prev());
		update_anchor("up")
		update_count();
	}
	if(order == 'down')
	{
		jQuery(ref).parents('.gat_dimention_wrpr').insertAfter(jQuery(ref).parents('.gat_dimention_wrpr').next());
		update_anchor("down")
		update_count();
	}
}
function domain_order(ref)
{
	var order = jQuery(ref).attr("data-order");
	if(order == 'up')
	{
		jQuery(ref).parents('tr').insertBefore(jQuery(ref).parents('tr').prev());
	}
	if(order == 'down')
	{
		jQuery(ref).parents('tr').insertAfter(jQuery(ref).parents('tr').next());
	}
	
	var i = 1;
	var length = jQuery(ref).parents("table").children("tbody").children("tr").length;
	jQuery(ref).parents("table").children("tbody").children("tr").each(function()
	{
       if(i == 1)
	   {
		   jQuery(this).children("td:first-child").children('a').removeClass("dmnordr_up");
		   jQuery(this).children("td:nth-child(2)").children('a').addClass("dmnordr_dwn");
	   }
	   else
	   {
		   if(i == length)
		   {
			   jQuery(this).children("td:first-child").children('a').addClass("dmnordr_up");
		   	   jQuery(this).children("td:nth-child(2)").children('a').removeClass("dmnordr_dwn");
		   }
		   else
		   {
			   jQuery(this).children("td:first-child").children('a').addClass("dmnordr_up");
		   	   jQuery(this).children("td:nth-child(2)").children('a').addClass("dmnordr_dwn");
		   }
	   }
	   i++;
    });
}
function delete_domain(ref)
{
	var domainid = jQuery(ref).attr("data-id");
	jQuery.ajax({
		url: ajaxurl,
		type: "post",
		data: "domainid="+domainid+"&action=delete_domain",
		success: function(msg)
		{
			location.reload();
		}
	});
}