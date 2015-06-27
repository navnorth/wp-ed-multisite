//for hide and show text
jQuery(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 250;  // How many characters are shown by default
    var moretext = "[...]";
    var lesstext = "[Read Less]";
    jQuery('.gat_moreContent').each(function() {
        var content = jQuery(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = '<p>'+ c + '<span class="morecontent"><span>' + h + '</span></span><label class="morelink">' + moretext + '</label></p>';
            jQuery(this).html(html);
        }
    });
    jQuery(".morelink").click(function(){
        if(jQuery(this).hasClass("less"))
		{
            jQuery(this).removeClass("less");
            jQuery(this).html(moretext);
        } else {
            jQuery(this).addClass("less");
            jQuery(this).html(lesstext);
        }
        jQuery(this).prev().children().toggle();
        jQuery(this).prev().toggle();
        return false;
    });
});
jQuery(document).ready(function(e) {
   
   jQuery('.gat_error').delay(2000).fadeOut();
   
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
	
	jQuery(".cntrollorbtn").click(function(){
		var id = jQuery(this).attr("data-resultedid");
		if(jQuery(this).children("i.fa").hasClass("fa-play") || jQuery(this).children("i.fa").hasClass("fa-check"))
		{
			jQuery(".gat_reslt_listvideos").children("li").children(".gat_videodetails").children("span.cntrollorbtn").each(function()
			{
				if( id == jQuery(this).attr("data-resultedid"))
				{		}
				else
				{
					jQuery(this).parents("li").children(".unclickable").css("display", "block");
					jQuery(this).parents("li").children(".unclickable").attr("title","Please pause/stop current video to play this video!");
				}
        	});
		}
		else
		{
			jQuery(".gat_reslt_listvideos").children("li").children(".gat_videodetails").children("span.cntrollorbtn").each(function()
			{
				if( id == jQuery(this).attr("data-resultedid"))
				{		}
				else
				{
					jQuery(this).parents("li").children(".unclickable").css("display", "none");
					jQuery(this).parents("li").children(".unclickable").attr("title","");
				}
        	});
		}
		gat_play_utubevdo(this);
	});
        
        /*Override URL shared by Simple Share Buttons*/
	jQuery(".ssba-wrap a").each(function(){
	    var shareUrl = jQuery(this).attr('href');
	    var linkClass = jQuery(this).attr('class');
	    /* Current Url */
	    var origUrl = window.location.href;
	    var index = 0;
	    var newURL = origUrl;
	    /* Find query string starting operator ? */
	    index = origUrl.indexOf('?');
	    if(index == -1){
		index = origUrl.indexOf('#');
	    }
	    /* if ? is found, remove string succeeding characters including the ? sign */
	    if(index != -1){
		newURL = origUrl.substring(0, index);
	    }
	    var newShareUrl = shareUrl;
	    var sUrl = shareUrl;
	    switch (linkClass){
		case 'ssba_facebook_share':
		    index = shareUrl.indexOf('u=');
		    newShareUrl = shareUrl.substring(index+2,shareUrl.length);
		    sUrl = shareUrl.replace(newShareUrl,newURL);
		    break;
		case 'ssba_google_share':
		    index = shareUrl.indexOf('url=');
		    newShareUrl = shareUrl.substring(index+4,shareUrl.length);
		    sUrl = shareUrl.replace(newShareUrl,newURL);
		    break;
		case 'ssba_pinterest_share':
		    break;
		case 'ssba_twitter_share':
		    index = shareUrl.indexOf('url=');
		    var index2 = shareUrl.indexOf('&text');
		    newShareUrl = shareUrl.substring(index+4,index2);
		    sUrl = shareUrl.replace(newShareUrl,newURL);
		    break;
		default:
		    index = shareUrl.indexOf('url=');
		    newShareUrl = shareUrl.substring(index+4,shareUrl.length);
		    sUrl = shareUrl.replace(newShareUrl,newURL);
		    break;
	    }
	    jQuery(this).attr('href',sUrl);
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
function gat_play_utubevdo(ref)
{
	if(jQuery(".loadvideo").find("div.unclickablevideo").length != 0)
    {
		jQuery("div.unclickablevideo").remove();
	}
 
	var utubeid = jQuery(ref).attr("data-youtubeid");
	utubeid = String(utubeid);
	var currenid = jQuery(ref).attr("data-resultedid");
	jQuery("#player").attr("data-resultedid", currenid );
	
	if(jQuery(ref).children("i.fa").hasClass("fa-play"))
	{
		jQuery(ref).children("i.fa").removeClass("fa-play");
		jQuery(ref).children("i.fa").addClass("fa-pause")
		//player.loadVideoById(utubeid);
		var seek_to = jQuery(ref).attr("data-seekto");
		seek_to = new Number(seek_to);
		seek_to = seek_to.toFixed(2);
		player.loadVideoById(utubeid, seek_to);
		//player.seekTo(seek_to);
	}
	else if(jQuery(ref).children("i.fa").hasClass("fa-pause"))
	{
		jQuery(ref).children("i.fa").removeClass("fa-pause");
		jQuery(ref).children("i.fa").addClass("fa-play")
		trackrecordbyid(currenid);
		player.stopVideo();
	}
	else if(jQuery(ref).children("i.fa").hasClass("fa-check"))
	{
		jQuery(ref).children("i.fa").removeClass("fa-check");
		jQuery(ref).children("i.fa").addClass("fa-pause")
		//player.loadVideoById(utubeid);
		var seek_to = jQuery(ref).attr("data-seekto");
		seek_to = new Number(seek_to);
		seek_to = seek_to.toFixed(2);
		player.loadVideoById(utubeid, seek_to);
		//player.seekTo(seek_to);
	}
	jQuery(".gat_reslt_listvideos").children("li").children(".gat_videodetails").children(".meter").each(function() {
        if(jQuery(this).hasClass("currentmeter"))
		{
			jQuery(this).removeClass("currentmeter");
		}
    });
	jQuery(ref).next(".meter").addClass("currentmeter");
}
function trackrecordbyid(resultedid)
{
	var videocrrnttime = player.getCurrentTime();
	var videottltime = player.getDuration();
	jQuery.ajax({
		url: ajaxurl,
		type: "post",
		data: "resultedid="+resultedid+"&videocrrnttime="+videocrrnttime+"&videottltime="+videottltime+"&action=gat_trackrecord",
		dataType:"json",
		success: function(msg)
		{
		jQuery(".gat_reslt_listvideos").children("li").children(".gat_videodetails").children(".currentmeter").children("span").css("width", msg.complete+"%").text(msg.complete+"%");
		jQuery(".gat_reslt_listvideos").children("li").children(".gat_videodetails").children(".currentmeter").prev("span").attr("data-seekto",msg.seek);
		jQuery(".gat_reslt_listvideos").children("li").children(".gat_videodetails").children(".currentmeter").prev("span").children("i.fa").removeClass("fa-pause").addClass("fa-play");
		}
	});
}