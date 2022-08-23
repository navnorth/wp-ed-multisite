/** Detect zoom using resize event **/
/**--window.addEventListener('resize', () => {
  const browserZoomLevel = Math.round(window.devicePixelRatio * 100);
  if (browserZoomLevel>100){
  	if (jQuery(window).width() < 769) {
			jQuery('.navi_bg .navi_icn').attr('tabindex','0');
			jQuery('.navi_bg .navi_icn').attr('aria-label','menu');
			jQuery('.navi_bg .navi_icn').on("keypress", function(e) {
				var code = e.keyCode || e.which;
				if(code == 13 || code == 32) { 
	   				jQuery('.navi_bg .navi_icn .fa-bars').trigger('click');
	 			}
			});
		}
  }
})--**/

jQuery( document ).ready(function() {
    jQuery('#page_template').on('change', function() {
	  //alert(this.value);
	});
	
	jQuery(".fa-bars").click(function(){
		jQuery(".menu-primary-menu-container").css("display", "block");
		jQuery(".responsiv-menu_ul").css("display", "block");
   		jQuery(".responsiv-menu").slideToggle("slow");
 	});
	jQuery(".fa-print").click(function(){
		window.print();
	});

	/** Keyboard Navigation using Keydown event **/
	jQuery('.menu-item > a').on('keydown',function(e){
	    if (e.which==40) { /* Down Arrow Key */
		/* Check if current menu item has a child menu */
		if (jQuery(this).parent().has('.sub-menu').length > 0) {
		    subMenu = jQuery(this).parent().find('.sub-menu');
		    subMenu.show();
		    subMenu.focus();
		} else {
		    jQuery(this).parent().next().find('a').focus();
		}
	       return false;
	    }
	    if (e.which==38) { /* Up Arrow Key */
		/* Check if sub menu is visible, then hide*/
		 if (jQuery(this).parent().has('.sub-menu').is(':visible')) {
		    jQuery(this).parent().find('.sub-menu').hide();
		    jQuery(this).parent().find('.sub-menu').removeAttr('style');
		}
		return false;
	    }
	});
	jQuery('.menu-item > a').on('mouseenter' , function(){
	     if (jQuery(this).parent().has('.sub-menu')) {
		jQuery('.sub-menu').removeAttr('style');
	     }
	});
	jQuery('.menu-item > a').on('focus' , function(){
	     if (jQuery(this).parent().has('.sub-menu').length>0) {
		jQuery('.sub-menu').removeAttr('style');
	     }
	});

	/** Add role to menu items on mobile **/
  jQuery('.mobile-nav-bar .responsiv-menu .responsiv-menu_ul').attr({
    'id' : 'responsiv_menu_ul',
    'role' : 'menu',
    'aria-labelledby' : 'mobile_nav_icons'
  });
  jQuery('.responsiv-menu .responsiv-menu_ul li').each(function(){
    jQuery(this).attr('role','none');
    jQuery(this).find('a').attr('role','menuitem');
    if (jQuery(this).hasClass('current_page_item'))
      jQuery(this).find('a').attr('tabindex','0');
    else
      jQuery(this).find('a').attr('tabindex','-1');
  });
  /** Keyboard navigation on mobile menu **/
  jQuery('.responsiv-menu_ul .menu-item > a').on('keydown',function(e){
      jQuery('.responsiv-menu_ul .menu-item a').attr('tabindex','-1');
      if (e.which==40) { /* Down Arrow Key */
      	if (jQuery(this).parent().find('.sub-menu').length)
      		jQuery(this).parent().find('.sub-menu > li:first-child > a').attr('tabindex','0').focus();
      	else{
      		if (jQuery(this).parent().is(":last-child")){
      			if (jQuery(this).closest('.menu-item-has-children').length)
      				jQuery(this).closest('.menu-item-has-children').next().find('> a').attr('tabindex','0').focus();
      			else
      				jQuery(this).closest('ul.responsiv-menu_ul').find('> li:first-child > a').attr('tabindex','0').focus();
      		} else
        		jQuery(this).parent().next().find('> a').attr('tabindex','0').focus();
      	}
      } else if (e.which==38) { /* Up Arrow Key */
      	if (jQuery(this).parent().is(":first-child")){
      		if (jQuery(this).closest('.menu-item-has-children').length)
      			jQuery(this).closest('.menu-item-has-children').find('> a').attr('tabindex','0').focus();
      		else
      			jQuery(this).closest('ul.responsiv-menu_ul').find('li:last-child > a').attr('tabindex','0').focus();
      	} else {
      		if (jQuery(this).parent().prev().find('.sub-menu').length)
      			jQuery(this).parent().prev().find('.sub-menu > li:last-child > a').attr('tabindex','0').focus();
      		else
        		jQuery(this).parent().prev().find('> a').attr('tabindex','0').focus();
      	}
      } else if (e.which==27){
      	jQuery(this).closest('.navi_bg').find('.responsiv-menu').css("display","none");
 				jQuery(this).closest('.navi_bg').find('.responsiv-menu .responsiv-menu_ul').css("display","none")
 				jQuery(this).closest('.navi_bg .navi_icn').removeAttr('aria-expanded');
 				jQuery(this).closest('.navi_bg .navi_icn').focus();
      }
  });
	
	/* Nav menu focus handler */
	jQuery('.main-menu ul li a').on('focus', function(){
		var nav =  jQuery('.main-menu');
		/* main menu with submenus */
	    if (jQuery(this).parent().has('.sub-menu').length>0) {
			jQuery(this).parent().find('.sub-menu').toggle();
	    } else {
	    	/* main menu without submenus*/
	    	if (jQuery(this).closest('.sub-menu').length==0){
	    		nav.find('.sub-menu').toggle(false);
	    	}
	    }
	});
	
	if (jQuery(window).width()<=600) {
	    jQuery('.form-group.gray_bg').before('<a href="javascript:void(0)" class="mobile-search-btn"><span class="fa-stack"><i class="fa fa-search" aria-hidden="true"></i></span></a>');
	    jQuery('.mobile-search-btn').on('click', function(){
			if (jQuery('.form-group.gray_bg').is(":visible")) {
			    jQuery('.form-group.gray_bg').hide();
			    jQuery('.top_strp').css({"margin-top":"0"});
			    jQuery('.navi_icn').css({"margin-top":"-48px"})
			    jQuery('#content').css({"margin-top":"0"});
			} else {
			    jQuery('.form-group.gray_bg').show();
			    jQuery('.top_strp').css({"margin-top":"50px"});
			    //jQuery('.navi_icn').css({"margin-top":"-93px"})
			    jQuery('#content').css({"margin-top":"45px"});
			}
	    });
	}
	
	//Wrap youtube video with video container
	jQuery("iframe[src*='youtube.com']").wrap("<div class='video-container'></div>");
	
	jQuery('.slideshow_description').addClass("dot-ellipsis dot-resize-update dot-load-update");
	
	//Update top level menu styles dynamically
	jQuery('.main-menu ul li a').each(function(){
	    if(jQuery(this).attr('href')=='#') {
		jQuery(this).css( { 'cursor':'default' });
	    }
	});
	
    // Replace SVGs with PNG on unsupported browsers
	if (!Modernizr.svg) {
		jQuery('img.svg-replace[src*="svg"]').attr('src', function() {
			return jQuery(this).attr('src').replace('.svg', '.png');
		});
		//jQuery('*[class=".slideshow_container_style-light .slideshow_pagination ul li"]').css('background', 'url(../images/slider_pager.png) 0 0 no-repeat !important;');
		console.log('Replaced SVG images with PNG');
	}

	/** enable keyboard navigation on mobile menu **/
  if (jQuery(window).width() < 769) {
  	const browserZoomLevel = Math.round(window.devicePixelRatio * 100);
		jQuery('.navi_bg .navi_icn').attr('tabindex','0');
		jQuery('.navi_bg .navi_icn').attr('aria-label','menu');
		jQuery('.navi_bg .navi_icn').on("keydown", function(e) {
			var code = e.which;
			var key = e.key;
			if(key == "Enter" || key == " " || key == "ArrowDown" || key == "ArrowUp") { 
   				//jQuery('.navi_bg .navi_icn .fa-bars').trigger('click');
   				jQuery(this).closest('.navi_bg').find('.responsiv-menu').css("display","block")
   				jQuery(this).closest('.navi_bg').find('.responsiv-menu .responsiv-menu_ul').css("display","block")
   				jQuery(this).attr('aria-expanded','true');
   				if (key == "ArrowUp"){
		 				jQuery(this).closest('.navi_bg').find('.responsiv-menu_ul > li:last-child a').attr('tabindex','0');
		      	jQuery(this).closest('.navi_bg').find('.responsiv-menu_ul > li:last-child a').focus();
		      } else {
		      	jQuery(this).closest('.navi_bg').find('.responsiv-menu_ul > li:first-child a').attr('tabindex','0');
		      	jQuery(this).closest('.navi_bg').find('.responsiv-menu_ul > li:first-child a').focus();
		      }
 			} else if (key == "Esc" || key == "Escape"){
 				jQuery(this).closest('.navi_bg').find('.responsiv-menu').css("display","none");
 				jQuery(this).closest('.navi_bg').find('.responsiv-menu .responsiv-menu_ul').css("display","none")
 				jQuery(this).removeAttr('aria-expanded');
 				jQuery(this).focus();
 			}
		});
	}

	/** hide recaptcha logo when contact form slider is disabled **/
	setTimeout(function(){
		if (jQuery('#contact-slider').length || jQuery('.wpcf7').length){
			jQuery('.grecaptcha-badge').css({'visibilty':'visible','opacity':'1'})
		} else {
			jQuery('.grecaptcha-badge').css({'visibilty':'hidden','opacity':'0'})
		}
	},500);
});

/*
jQuery(window).load(function(){
    var heght = jQuery("#lnk_btn_cntnr_center").children("div.col-md-8").height();
    jQuery(".link_dwnlds").height(heght);

    var a_hght = jQuery(".link_dwnlds").children("div").children("a").height();
    a_hght = parseInt(a_hght) + parseInt(30);
    var a_margin = parseInt(heght) - parseInt(a_hght);
    a_margin = a_margin/2;
    jQuery(".link_dwnlds").children("div").children("a").css("margin-top", a_margin+"px");
});
*/
function openWindow(url, title, width, height) {
  var left = (screen.width - width) / 2;
  var top = (screen.height - height) / 4;
  var popupWindow = window.open(url,
			      title,
			      'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left);
}






/* FEATURE VIDEO START */
jQuery(document).ready(function(){
  var tag = document.createElement('script');
  var apiurl = jQuery('.oet-featured-video-shrtcd-overlay').attr('apiurl');
  //tag.src = ytplayerapiurl;
  tag.srv = 'https://www.youtube.com/player_api';
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
});


var ytplayer = [];
var focuscontainer;


window.onYouTubePlayerAPIReady = function() { //simple implementation
    
    setTimeout(function(){
      
      jQuery('.oet-featured-video-shrtcd-ytvideo').each(function(i, obj) {
        var cnt = jQuery(this).attr('cnt');
        var playid = jQuery(this).attr('id');
        var vidid = jQuery(this).attr('vidid');
        var hght = jQuery(this).attr('hght');
        var orgn = jQuery(this).attr('orgn');
        var frametitle = jQuery(this).attr('frametitle');
        ytplayer[cnt] = new YT.Player(playid, {
          height: hght,
          width: '766',  
          playerVars: { 
            autoplay: 0,
            enablejsapi: 1,
            origin: orgn,
            rel: 0
          },
          videoId: vidid,
          events: {
            //Inline function to get the featured video attributes
            'onStateChange': function(e) {
                if (e.data == 1) { //play
                  ga('send','event','Featured Video: '+frametitle,'Play', vidid);
                }
                if (e.data == 2) { //paused
                  ga('send','event','Featured Video: '+frametitle, 'Pause', vidid);
                }
                if (e.data == 0) { //ended
                  ga('send', 'event','Featured Video: '+frametitle, 'Finished', vidid);
                }
              }
          }
          
        });
      });
      
      
      jQuery(document).on('click','.stry-video-close', function(){
        jQuery('.oet-featured-video-shrtcd-overlay').modal('hide');
      });

      jQuery(document).on('click','.oet-video-link',function(e){
          var cnt = jQuery(this).attr('cnt');
          if(typeof ytplayer[cnt] != 'undefined' && typeof ytplayer[cnt].playVideo == 'function'){
            var modalid = jQuery(this).attr('data-tgt');
            jQuery(modalid).modal('show');
            ytplayer[cnt].playVideo();
            focuscontainer = setInterval(function() {
                  //jQuery('#oet-featured-video-shrtcd-overlay-'+cnt).focus();
            }, 500);
          }
      });

      jQuery(document).on('hide.bs.modal', '.oet-featured-video-shrtcd-overlay', function () {
          var cnt = jQuery(this).attr('cnt');
          ytplayer[cnt].pauseVideo();
          clearInterval(focuscontainer);
      });
      
    }, 500);
}



/* FEATURE VIDEO END */

function openHamburgerMenu(){

}

function closeHamburgerMenu(){

}
