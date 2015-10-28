var inquire
/**
 * ------------------------------------------------------------------------
 * User Information Modal
 * @code begin
 * ------------------------------------------------------------------------
 */
    /**
     * Cookie
     * Description
     */
    function Cookie() {
	/**
	 * Get Cookie
	 * Description
	 *
	 * @param {string} name The cookie name.
	 */
	this.get = function(name) {
	    var n = name + "=";
	    var ca = document.cookie.split(';');

	    for(var i = 0; i < ca.length; i++) {
		var c = ca[i]

		while (c.charAt(0) == ' ') {
		    c = c.substring(1)
		}

		if (c.indexOf(n) == 0)
		    return c.substring(n.length, c.length);
	    }

	    return "";
	}
	/**
	 * Set Cookie
	 * Description
	 *
	 * @param {string} name The cookie name.
	 * @param {string} value The cookie value.
	 * @param {integer} expires The cookie expiration in days.
	 */
	this.set = function(name, value, expires, domain, path) {
	    var d = new Date()
		d.setTime(d.getTime() + (expires * 24 * 60 *60 * 1000))

	    var cookie = []
		cookie.push(name + '=' + value);
		cookie.push('expires=' + d.toUTCString())

	    if (domain)
		cookie.push('domain=' + domain)

	    if (path)
		cookie.push('path=' + path)
	    /*console.log(cookie.join('; '))*/
	    document.cookie = cookie.join('; ')
	}

	/**
	 * Delete Cookie
	 **/
	this.del = function(name) {
	    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	}
    }
    /**
     * Querystring
     * Description
     */
    function Querystring()
    {
	var object = this

	this.get = function(name) {
	    var all = object.all()

	    if ( ! jQuery.isEmptyObject(all))
	    {
		for(var index in all)
		{
		    if (index == name)
			return all[index]
		}
	    }

	    return ''
	}

	this.all = function() {
	    var q = []

	    var search = window.location.search.substr(1).split('&')

	    if (search.length) {
		jQuery.each(search, function(key, pair) {
		    var p = pair.split('=')
		    q[p[0]] = p[1]
		})
	    }

	    return q
	}
    }
    /**
     * Document Ready for User Information Modal
     * Description
     */
    jQuery(document).ready(function() {
	var querystring = new Querystring()
	var cookie = new Cookie()

	if (querystring.get('action')=='video-playlist' || (querystring.get('action')=='analysis-result' && cookie.get('GAT-late-email-set')=="1") ) {
	    if (cookie.get('GAT-inquire-user-information')=="1") {
		jQuery('#gat-user-info-modal').data('initiate', 'auto')
		jQuery('#gat-user-info-modal').modal('show')
	    }
	}

	/**
	 * Hidden GAT User Information Modal Event Handler
	 * Description
	 */
	jQuery('.modal-container').delegate('#gat-user-info-modal', 'hidden.bs.modal', function(event) {
	    if(jQuery('#gat-user-info-modal').data('initiate') == 'auto')
	    {
		var path = window.location.pathname
		var len = path.length

		if (path.substr(len - 1, len) == '/')
		    path = path.substr(0, len - 1)

		var domain = '.' + window.location.host

		cookie.set('GAT-inquire-user-information', '0', 10, domain, path)
	    }
	})

	jQuery('#show-gat-user-info-modal').click(function() {
	    jQuery('#gat-user-info-modal').data('initiate', 'manual')

	    jQuery('#gat-user-info-modal').modal('show')
	})

	 jQuery('#gat-user-info-modal').on('hidden.bs.modal', function () {
	    var path = window.location.pathname
	    var len = path.length

	    if (path.substr(len - 1, len) == '/')
		path = path.substr(0, len - 1)

	    var domain = '.' + window.location.host
	    cookie.set('GAT-inquire-user-information', '0', 10, domain, path)

	    if (cookie.get('GAT-late-email-set')=="1") {
		cookie.del('GAT-late-email-set');
		cookie.set('GAT-late-email-set', '0', 10, domain, path);
	    }
	})

	/**
	 * Submit User Information Button Event Handler
	 * Description
	 */
	jQuery('#gat-user-info-modal #submit-gat-user-info').on("click",function() {
	    var button = this

	    jQuery('#gat-user-info-modal input[name="email"]').parents('.form-group').removeClass('has-error')

	    var email = jQuery('#gat-user-info-modal input[name="email"]')
	    var state = jQuery('#gat-user-info-modal select[name="state"]')
	    var district = jQuery('#gat-user-info-modal select[name="district"]')

	    if (email.val() || state.val() || district.val()) {
		var proceed = true

		if (email.val()) {
		    var regex = /^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;

		    if (regex.exec(email.val()) === null) {
			proceed = false
			jQuery('#gat-user-info-modal input[name="email"]').parents('.form-group').addClass('has-error')
		    }

		    if (proceed) {
			jQuery('#gat-user-info-modal input[name="email"], #gat-user-info-modal input[name="state"], #gat-user-info-modal input[name="district"]').prop('disabled', true)
			jQuery(button).button('loading')

			var data = jQuery('#gat-user-info-modal form').serializeArray()

			    data.push({
				name: 'action',
				value: 'register_user_info'
			    }, {
				name: 'email',
				value: email.val()
			    })

			jQuery.ajax({
			    url: ajaxurl,
			    type: 'post',
			    data: data,
			    success: function(reply) {
				try {
				    reply = jQuery.parseJSON(reply)

				    if ('success' == reply.status) {
						var user_email = email.val();
						email = email.val().split('@')

						var e = '';
						for(var i = 0; i < email[0].length; i++)
						    e = e + (i == 0 ? email[0].charAt(0) : '*')

						jQuery('.gat-user-email').html(e + '@' + email[1])
						var path = window.location.pathname
						var len = path.length

						if (path.substr(len - 1, len) == '/')
						    path = path.substr(0, len - 1)

						var domain = '.' + window.location.host
						cookie.set('GAT-inquire-user-information', '0', 10, domain, path)

						if (jQuery('#email_playlist_form').find('input#email').length) {
						     jQuery('#email_playlist_form').find('input#email').val(user_email);
						}

						if (cookie.get('GAT-late-email-set')=="1") {
						    cookie.del('GAT-late-email-set');
						    cookie.set('GAT-late-email-set', '0', 10, domain, path);
						    /*jQuery('#email_playlist_form').find('input#email').val(user_email);*/
						    jQuery('#email_playlist_form .gat_email_results_button').trigger('click');
						}
				    }
				} catch(e) {

				}
			    }
			})
			.always(function() {
			    jQuery('#gat-user-info-modal input[name="email"], #gat-user-info-modal select[name="state"], #gat-user-info-modal select[name="district"]').prop('disabled', false)
			    jQuery(button).button('reset')

			    jQuery('#gat-user-info-modal').modal('hide')
			})
		    }
		}
	    }
	    else
	    {
		jQuery('#gat-user-info-modal').modal('hide')
	    }
	})

	/**
	 * Submitting popup form handler
	 **/
	jQuery('#gat-user-info-form').submit(function(){
	    jQuery('#gat-user-info-modal #submit-gat-user-info').trigger("click");
	    return false;
	});

	/**
	 * Email My Playlist button handler
	 **/
	jQuery('#email_playlist_form').submit(function(){
	    var path = window.location.pathname
	    var len = path.length

	    if (path.substr(len - 1, len) == '/')
			path = path.substr(0, len - 1)

	    var domain = '.' + window.location.host;
	    var email = jQuery(this).find('input#email');

	    if (email.val()=="") {
			cookie.set('GAT-inquire-user-information', '1', 10, domain, path);
			cookie.set('GAT-late-email-set', '1', 10, domain, path);
	    }
	});

	/** Activate JScrollPane for non Webkit Browser **/
	if (jQuery('.gat-library-videos').length>0) {
	    if (!jQuery.browser.webkit && !jQuery.browser.msie) {
		jQuery('.gat-library-videos').jScrollPane({showArrows:true});
	    }
	}

	/** Scroll Navigation Buttons at the left and right portion of the list **/
	if (jQuery('.video-list').length>0) {
	    jQuery(window).resize(function(){
		jQuery('.gat-library-videos').trigger("scroll");
	    });

	    jQuery('.vlist').each(function(){
		if (jQuery(this).find('.gat-library-videos').innerWidth() >= jQuery(this).find('.gat-library-videos')[0].scrollWidth ) {
		    jQuery(this).find('.scroll-right').addClass('scroll-disabled');
		}
	    });

	    /** Enable/Disable Scroll Buttons when using scrollbar **/
	    jQuery('.gat-library-videos').scroll(function() {
		if (jQuery(this).scrollLeft() >  0 ) {
		    jQuery(this).parent().find('.scroll-left').removeClass('scroll-disabled');
		} else {
		    jQuery(this).parent().find('.scroll-left').addClass('scroll-disabled');
		}

		if ((jQuery(this).scrollLeft() + jQuery(this).innerWidth()) >= jQuery(this)[0].scrollWidth ) {
		    jQuery(this).parent().find('.scroll-right').addClass('scroll-disabled');
		}   else {
		    if (jQuery(this).parent().find('.scroll-right').hasClass('scroll-disabled')) {
			jQuery(this).parent().find('.scroll-right').removeClass('scroll-disabled');
		    }
		}
	    });

	    /** Scroll Left button click event handler **/
	    jQuery('.scroll-left').click(function() {
		var scrollLength = jQuery(this).parent().width() - 40;
		jQuery(this).parent().find('.gat-library-videos').scrollLeft(jQuery(this).parent().find('.gat-library-videos').scrollLeft() - scrollLength);
		jQuery(this).parent().find('.gat-library-videos').trigger("scroll");
	    });

	    /** Scroll Right button click event handler **/
	    jQuery('.scroll-right').click(function() {
		var scrollLength = jQuery(this).parent().width() - 40;
		jQuery(this).parent().find('.gat-library-videos').scrollLeft(jQuery(this).parent().find('.gat-library-videos').scrollLeft() + scrollLength);
		jQuery(this).parent().find('.gat-library-videos').trigger("scroll");
	    });
	}
    })
/**
 * ------------------------------------------------------------------------
 * User Information Modal
 * @code end
 * ------------------------------------------------------------------------
 */

/**
 * Clear Analysis
 * Description
 */
jQuery(document).ready(function() {
    jQuery('#clear-analysis #do-clear-analysis').click(function(event) {
	event.preventDefault()

	var clear = confirm('Are you sure you want to clear your Analysis on this browser?')

	if (clear) {
	    if (typeof window.onbeforeunload === 'function') {
		window.onbeforeunload = null
	    }

	    jQuery('#clear-analysis').submit();
	}
    })

    inquire = jQuery('input[name="inquire"]').detach()
})
/**
 * Unload Confirmation
 * Description
 */
jQuery(document).ready(function() {
    jQuery('input[name="domain_submit"], input[name="gat_results"]').click(function() {
	if (typeof window.onbeforeunload === 'function') {
	    window.onbeforeunload = null
	}
    })
})
//for hide and show text
jQuery(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 250;  // How many characters are shown by default
    var moretext = "[...]";
    var lesstext = "[Read Less]";
    jQuery('.gat_moreContent').each(function() {
        var content = jQuery(this).html();
	var html = '<p>'+ content + '</p>';
        jQuery(this).html(html);
        /*if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = '<p>'+ c + '<span class="morecontent"><span>' + h + '</span></span><label class="morelink">' + moretext + '</label></p>';
            jQuery(this).html(html);
        }*/
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
		/*add_focus(this);*/
	});
	jQuery('.rating_scaleli').focusout(function(e) {
		remove_focus(this);
	});

	if(!('ontouchstart' in window || 'onmsgesturechange' in window))
	{
		jQuery('.rating_scaleli').mouseover(function(e) {
			add_focus(this);
		});
		jQuery('.rating_scaleli').mouseout(function(e) {
			remove_focus(this);
		});
	}

	/** Load Default Video **/
	var defvideo = jQuery('.defaultvideo');
	gat_play_utubevdo(defvideo);

	/*jQuery(".cntrollorbtn").click(function(){
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
	});*/

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

	/* Checked if all questions are answered before submitting */
	jQuery('.gat_btn_submit').click(function(){
	    if (jQuery('ul.gat_domain_rating_scale:not(:has(:radio:checked))').length) {
		var radioB = jQuery('ul.gat_domain_rating_scale:not(:has(:radio:checked)):first');
		jQuery('.question-error').remove();
		jQuery('ul.gat_domain_rating_scale:not(:has(:radio:checked))').parents('div.dimension_question').prepend('<div class="question-error red-text">Please select an answer before submitting.</div>');
		radioB.find('li:first').focus();
		alert('Please answer all of the questions on this page before proceeding.');
		return false;
	    }
	});

	/* Sticky Progress Box */
	var $sidebar   = jQuery("#progress-box"),
	    $window    = jQuery(window),
	    offset     = $sidebar.offset(),
	    topPadding = 15;

	$window.scroll(function() {
	    if ($sidebar.length>0) {
		if ($window.scrollTop() > offset.top) {
		    $sidebar.stop().animate({
			marginTop: $window.scrollTop() - offset.top + topPadding
		    },0);
		} else {
		    $sidebar.stop().animate({
			marginTop: 0
		    },10);
		}
	    }
	});

	/* Analysis Result Bar Graph Hover Effect */
	jQuery('[data-toggle="tooltip"]').tooltip({trigger:'hover focus', html:true});

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
		jQuery(ref).css("background-color", "#00529f");
		jQuery(ref).css("color", "#fff");
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
		jQuery(ref).css("color", "");
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
		jQuery(this).css("color", "");
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

	    jQuery(ref).children("input").val(jQuery(ref).attr("data-rating")).attr("checked",true);
	    var desc = jQuery(ref).children(".rating_scale_description").text();
	    jQuery(ref).parents("ul").next("div.gat_scaledescription_cntnr").text(desc);
	}

	if (inquire.length) {
	    if (jQuery('.rating_scaleli.selectedli').length) {
		if (jQuery('input[name="inquire"]').length == 0)
		    inquire.appendTo('form#assessment_data')
	    } else {
		inquire = jQuery('input[name="inquire"]').detach()
	    }
	}

	var formdata = jQuery('#assessment_data').serialize();
	jQuery.ajax({
		url: ajaxurl,
		type: "post",
		data: formdata+"&action=save_assessment",
		success: function(msg)
		{
		    if (typeof window.onbeforeunload !== 'function') {
			window.onbeforeunload = function() {
			    return 'If you leave this page now, your new or changed answers won’t be recorded. To save your answers, click Stay on This Page, then click the Continue button to proceed to the next page.'
			}
		    }

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
			/*jQuery(ref).parents(".form-group").next(".form-group").html(msg);*/
			jQuery(ref).parents(".select-group").next(".select-group").find(".form-group").html(msg);
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