let touchEvent = 'ontouchstart' in window ? 'touchstart': 'click';

/** Detect zoom using resize event **/
/**--window.addEventListener('resize', () => {
  const browserZoomLevel = Math.round(window.devicePixelRatio * 100);
  if (browserZoomLevel>100){
    if (jQuery(window).width() < 800) {
      jQuery('.mobile-nav-bar .navi_icn').attr('tabindex','0');
      jQuery('.mobile-nav-bar .navi_icn').attr('aria-label','menu');
      jQuery('.mobile-nav-bar .navi_icn').on("keypress", function(e) {
        var code = e.keyCode || e.which;
        if(code == 13 || code == 32) { 
          if (jQuery('.mobile-nav-bar .navi_icn .fa-bars').length>0){
            jQuery('.mobile-nav-bar .navi_icn .fa-bars').trigger('click');
          } else
            jQuery('.mobile-nav-bar .navi_icn .fa-times').trigger('click');
        }
        jQuery(this).closest('.responsive-menu-section').find('.responsiv-menu_ul li:first-child a').attr('tabindex','0');
        jQuery(this).closest('.responsive-menu-section').find('.responsiv-menu_ul li:first-child a').focus();
      });
    }
  } 
})--**/

jQuery( document ).ready(function() {
    jQuery('#page_template').on('change', function() {
	  //alert(this.value);
	});

	jQuery(".fa-bars").click(function(){
		jQuery(".responsiv-menu_ul").css("display", "block");
		jQuery('.mobile-nav-icons i').toggleClass("fa-bars fa-times");
   	jQuery(".responsiv-menu").slideToggle("slow");
 	});

	jQuery(".fa-print").click(function(){
		window.print();
	});
  

  /** Hide Recaptcha Logo on Load **/
  setTimeout(function(){
    if (jQuery('.wpcf7').length){
      jQuery('.grecaptcha-badge').css({'visibilty':'visible','opacity':'1'})
    } else {
      jQuery('.grecaptcha-badge').css({'visibilty':'hidden','opacity':'0'})
    }
  },500);

  
  /*
    var heght = jQuery("#lnk_btn_cntnr_center").height();
    jQuery(".link_dwnlds").height(heght);

	var a_hght = jQuery(".link_dwnlds").children("div").children("a").height();
	a_hght = parseInt(a_hght) + parseInt(30);
	var a_margin = parseInt(heght) - parseInt(a_hght);
	a_margin = a_margin/2;
	jQuery(".link_dwnlds").children("div").children("a").css("margin-top", a_margin+"px");
  */
  
	/** Keyboard Navigation using Keydown event **/
	jQuery('.nav-menu > .menu-item > a').on('keydown',function(e){
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
	jQuery('.nav-menu > .menu-item > a').on('mouseenter' , function(){
	     if (jQuery(this).parent().has('.sub-menu')) {
		jQuery('.sub-menu').removeAttr('style');
	     }
	});
	jQuery('.nav-menu > .menu-item > a').on('focus' , function(){
	     if (jQuery(this).parent().has('.sub-menu').length==0) {
		jQuery('.sub-menu').hide();
	     } else {
		jQuery(this).parent().find('.sub-menu').show();
	     }
	});
	
  /** Add role to menu items on mobile **/
  jQuery('.mobile-nav-bar .responsiv-menu .responsiv-menu_ul').attr({
    'id' : 'responsiv_menu_ul',
    'role' : 'menu',
    'aria-labelledby' : 'mobile_nav_icons'
  });
  jQuery('.mobile-nav-bar .responsiv-menu .responsiv-menu_ul li').each(function(){
    jQuery(this).attr('role','none');
    jQuery(this).find('a').attr('role','menuitem');
    if (jQuery(this).hasClass('current_page_item'))
      jQuery(this).find('a').attr('tabindex','0');
    else
      jQuery(this).find('a').attr('tabindex','-1');
  });
  /** Keyboard navigation on mobile menu **/
  jQuery('.responsiv-menu_ul > .menu-item > a').on('keydown',function(e){
      jQuery('.responsiv-menu_ul .menu-item a').attr('tabindex','-1');
      if (e.which==40) { /* Down Arrow Key */
        if (jQuery(this).parent().is(":last-child")){
          jQuery(this).closest('ul.responsiv-menu_ul').find('> li:first-child > a').attr('tabindex','0').focus();
        } else {
          jQuery(this).parent().next().find('a').attr('tabindex','0').focus();
        }
      } else if (e.which==38) { /* Up Arrow Key */
        if (jQuery(this).parent().is(":first-child")){
          jQuery(this).closest('ul.responsiv-menu_ul').find('> li:last-child > a').attr('tabindex','0').focus(); 
        } else {
          if (jQuery(this).parent().prev().length>0)
            jQuery(this).parent().prev().find('a').attr('tabindex','0').focus();
          else
            jQuery(this).closest('.responsive-menu-section').find('.mobile-nav-icons').focus();
        }
      } else if (e.which==27){
        jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu').css("display","none");
        jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu .responsiv-menu_ul').css("display","none")
        jQuery(this).closest('.mobile-nav-bar').find('.navi_icn').removeAttr('aria-expanded');
        if (jQuery(this).closest('.mobile-nav-bar').find('.navi_icn i').hasClass('fa-times'))
            jQuery(this).closest('.mobile-nav-bar').find('.navi_icn i').removeClass('fa-times').addClass("fa-bars");
        jQuery(this).closest('.mobile-nav-bar').find('.navi_icn').attr('aria-label','open menu');
        jQuery(this).closest('.mobile-nav-bar').find('.navi_icn').focus();
      }
  });

	/** Mobile Menu **/
	if (jQuery('.responsiv-menu').length>0) {
	    jQuery('.responsiv-menu .responsiv-menu_ul > li.menu-item-has-children > a').after('<i class="fa fa-sort-asc mobile-parent-menu" aria-hidden="true"></i>');
	    jQuery('.responsiv-menu .responsiv-menu_ul > li.menu-item-has-children > .mobile-parent-menu').on('click' , function(){
	     if (jQuery(this).parent().has('.sub-menu').length==0) {
		jQuery('.sub-menu').hide();
	     } else {
		jQuery(this).parent().find('.sub-menu').toggle();
		if (jQuery('.responsiv-menu .responsiv-menu_ul > li.menu-item-has-children > .mobile-parent-menu').hasClass('fa-sort-asc')){
		    jQuery('.responsiv-menu .responsiv-menu_ul > li.menu-item-has-children > .mobile-parent-menu').removeClass('fa-sort-asc');
		    jQuery('.responsiv-menu .responsiv-menu_ul > li.menu-item-has-children > .mobile-parent-menu').addClass('fa-sort-desc');
		} else {
		    jQuery('.responsiv-menu .responsiv-menu_ul > li.menu-item-has-children > .mobile-parent-menu').removeClass('fa-sort-desc');
		    jQuery('.responsiv-menu .responsiv-menu_ul > li.menu-item-has-children > .mobile-parent-menu').addClass('fa-sort-asc');
		}
	     }
	});
	}

  if(jQuery(window).width()<800){
    const zoomLevel = Math.round(window.devicePixelRatio * 100);
    // Add Keyboard navigation on hamburger menu on mobile
    jQuery('.mobile-nav-bar .navi_icn').attr('tabindex','0');
    jQuery('.mobile-nav-bar .navi_icn').attr('aria-label','menu');
    jQuery('.mobile-nav-bar .navi_icn').on("keydown", function(e) {
      var code = e.which;
      /**--if(code == 13 || code == 32) { 
        if (jQuery('.mobile-nav-bar .navi_icn .fa-bars').length>0)
          jQuery('.mobile-nav-bar .navi_icn .fa-bars').trigger('click');
        else
          jQuery('.mobile-nav-bar .navi_icn .fa-times').trigger('click');
      }
      jQuery(this).closest('.responsive-menu-section').find('.responsiv-menu_ul li:first-child a').attr('tabindex','0');
      jQuery(this).closest('.responsive-menu-section').find('.responsiv-menu_ul li:first-child a').focus();--**/
      var key = e.key;
      console.log(key);
      if(key == "Enter" || key == " " || key == "ArrowDown" || key == "ArrowUp") { 
          //jQuery('.navi_bg .navi_icn .fa-bars').trigger('click');
          jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu').css("display","block")
          jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu .responsiv-menu_ul').css("display","block")
          jQuery(this).attr('aria-expanded','true');
          if (key == "ArrowUp"){
            jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu_ul > li:last-child a').attr('tabindex','0');
            jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu_ul > li:last-child a').focus();
          } else {
            jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu_ul > li:first-child a').attr('tabindex','0');
            jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu_ul > li:first-child a').focus();
          }
          if (jQuery('.mobile-nav-icons i').hasClass('fa-bars'))
            jQuery('.mobile-nav-icons i').addClass("fa-times").removeClass('fa-bars');
          jQuery(this).attr('aria-label','close menu');
      } else if (key == "Esc" || key == "Escape"){
        jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu').css("display","none");
        jQuery(this).closest('.mobile-nav-bar').find('.responsiv-menu .responsiv-menu_ul').css("display","none")
        jQuery(this).removeAttr('aria-expanded');
        if (jQuery('.mobile-nav-icons i').hasClass('fa-times'))
            jQuery('.mobile-nav-icons i').addClass("fa-bars").removeClass('fa-times');
        jQuery(this).focus();
        jQuery(this).attr('aria-label','open menu');
      }
    });

    var temp = jQuery('.wdm_results .res_info');
    jQuery('.cls_results').before(temp);
    jQuery('.wdm_results .res_info').remove();
    
    jQuery('div.wpsolr_facet_title').attr('data-toggle','collapse');
    jQuery('.wpsolr_facet_checkbox.wpsolr_facet_categories, .wpsolr_facet_checkbox.wpsolr_facet__wp_page_template_str').addClass("collapse");
    jQuery('div.wpsolr_facet_title.wpsolr_facet_categories').attr('data-target','.wpsolr_facet_checkbox.wpsolr_facet_categories');
    jQuery('div.wpsolr_facet_title.wpsolr_facet__wp_page_template_str').attr('data-target','.wpsolr_facet_checkbox.wpsolr_facet__wp_page_template_str');
    jQuery('.wpsolr_facet_checkbox.wpsolr_facet_categories, .wpsolr_facet_checkbox.wpsolr_facet__wp_page_template_str').collapse({
        toggle:false
    });
  }

    // set external links to open in new window and have distinct style
    jQuery('a').each(function() {
	var a = new RegExp('' + window.location.host + '|mailto' , 'i');
        if(!a.test(this.href)) {
            if(!jQuery(this).hasClass('no_target_change') && !jQuery(this).hasClass('tile-link')){
              jQuery(this).attr( 'target','_blank' );
              jQuery(this).addClass( 'external_link' );
            }
        }
    });
    
    jQuery('svg a').each(function() {
	if (jQuery(this).attr('target')) {
	    jQuery(this).removeAttr( 'target' );
	}
	if (jQuery(this).hasClass( 'external_link' )) {
	    jQuery(this).removeClass( 'external_link' );
	}
    });
    
    if (jQuery('#searchform.searchform a.external_link').length>0){
	jQuery('#searchform.searchform a.external_link').removeAttr('target');
	jQuery('#searchform.searchform a.external_link').removeClass( 'external_link' );
    }

    //Wrap youtube video with video container
    jQuery("iframe[src*='youtube.com']").wrap("<div class='oese-video-container'></div>");

    //Set the height of mega menu left to the height of the entire mega menu
    if (jQuery(".oii-mega-menu-left").length) {
	jQuery(".oii-mega-menu-left").height(jQuery(".oii-mega-menu").css('height'));
    }
    
    // Accordion Menu
    /*jQuery('.nav-menu li .sub-menu li a').hover(function(){
	if(!jQuery(this).next().is(":visible"))
	{
		jQuery(this).next().slideDown("slow");
	}
    });*/

    // Replace SVGs with PNG on unsupported browsers
    if (!Modernizr.svg) {
        jQuery('img.svg-replace[src*="svg"]').attr('src', function() {
            return jQuery(this).attr('src').replace('.svg', '.png');
        });
        //jQuery('*[class=".slideshow_container_style-light .slideshow_pagination ul li"]').css('background', 'url(../images/slider_pager.png) 0 0 no-repeat !important;');
        console.log('Replaced SVG images with PNG');
    }
    
    /** Add Checking of IoS **/
    var isIOS = (navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true: false );
    
    if (isIOS === true){
        var tempCss = jQuery('a').css('-webkit-tap-highlight-color');
        
        jQuery('body').css('-webkit-tap-highlight-color', 'rgba(0,0,0,0)');
                
        jQuery('a').css('-webkit-tap-highlight-color', tempCss);
    }
    
    if (jQuery('.tab-close-button').length>0){
        jQuery('.tab-close-button').removeAttr('target').removeClass('external_link');
        jQuery('.tab-close-button').css('cursor','pointer');
    }
    
    /** move cursor to top on pagination click **/
    jQuery(document).on("click", '.wdm_results .paginate_div li a.paginate', function(e){
        e.preventDefault();
        var offset = jQuery('.wdm_results').offset();
        window.scrollTo(offset.top, offset.left);
    });
    
    jQuery(document).ajaxComplete(function(event, request, settings){
        setTimeout(displayNext10Results(),1000);
        setTimeout(displayPrev10Results(),1000);
    });
    
    displayNext10Results();
    displayPrev10Results();
    
    /** Select State on Interactive Map Redirection **/
    jQuery('#SelectState').on("change", function(){
        var url = jQuery(this).val();
        window.location = url;
    });
    
    
    //add aria-labels to pagination buttons
    var addnavattrinterval;
    var addnavattr = false;
    setInterval(function(){  
    if(jQuery('.wpDataTables table.wpDataTable').hasClass('overlayed') && !addnavattr){
        addnavattr = true;
        addnavattrinterval = setInterval(function(){
          if(!jQuery('.wpDataTables table.wpDataTable').hasClass('overlayed') && addnavattr){
            addnavaccsttr();
          }
          addnavattr = false;
          clearInterval(addnavattrinterval);      
        },800);
      }
    }, 50);

    addnavaccsttr();
      
       
    
    setTimeout(function() {
      //add aria-label to state selection dropdown
      jQuery('#usa-html5-map-selector_0').attr('aria-label','US States Dropdown List');
      jQuery('#usa-html5-map-selector_0').attr({
      	'aria-label': 'US States Dropdown List',
      	'title': 'US States Dropdown List'	
      });
      jQuery('#usa-html5-map-selector_0').wrap('<label for="US States">US States:&nbsp;</label>');
  
      //ushtml5map Wrapper
      jQuery('select#usa-html5-map-selector_0').focus(function(){
      	jQuery('#oese-usahtml5map-wrapper').addClass('focused');
      });
      jQuery('select#usa-html5-map-selector_0').focusout(function(){
      	jQuery('#oese-usahtml5map-wrapper').removeClass('focused');
      });
  
      //wpDataTable Number of entries dropdown
      jQuery('#table_1_wrapper.wpDataTablesWrapper .dataTables_length button.dropdown-toggle').focus(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').addClass('focused');
      });
      jQuery('#table_1_wrapper.wpDataTablesWrapper .dataTables_length button.dropdown-toggle').focusout(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').removeClass('focused');
      });
      jQuery('.dropdown-menu > li > a').focus(function(){
        jQuery(this).closest('.length_menu').addClass('open');
      });
      
      jQuery(document).on('keydown','.wpDataTableFilterSection .wdt-select-filter .dropdown-toggle',function(e){
        var keyCode = (e.keyCode ? e.keyCode : e.which);
        if(keyCode == 13){
          setTimeout(function(){
            if (jQuery(e.target).closest('.wdt-select-filter').hasClass('show')) {
                jQuery(e.target).closest('.wdt-select-filter').addClass('open');
            }
          }, 1000);
        }
      });
      
      jQuery(document).on('keydown','.wpDataTableFilterSection .wdt-multiselect-filter .dropdown-toggle',function(e){
        var keyCode = (e.keyCode ? e.keyCode : e.which);
        if(keyCode == 13){
          setTimeout(function(){
            if (jQuery(e.target).closest('.wdt-multiselect-filter').hasClass('show')) {
                jQuery(e.target).parent('.wdt-multiselect-filter').addClass('open');
            }
          }, 1000);
        }
      });
      
      
        
  
      //wpDataTable Search Input
      jQuery('#table_1_wrapper.wpDataTablesWrapper .dataTables_filter input[type="search"]').focus(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').addClass('focused');
      });
      jQuery('#table_1_wrapper.wpDataTablesWrapper .dataTables_filter input[type="search"]').focusout(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').removeClass('focused');
      });
  
      //wpDataTable Report Column
      jQuery('#table_1_wrapper.wpDataTablesWrapper #table_1 tr td.column-report a').focus(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').addClass('focused');
      });
      jQuery('#table_1_wrapper.wpDataTablesWrapper #table_1 tr td.column-report a').focusout(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').removeClass('focused');
      });
  
      //wpDataTable Table header
      jQuery('#table_1_wrapper.wpDataTables table.wpDataTable tr th').focus(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').addClass('focused');
      });
      jQuery('#table_1_wrapper.wpDataTables table.wpDataTable tr th').focusout(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').removeClass('focused');
      });
  
      //wpDataTable Pagination buttons
      jQuery('div#table_1_paginate a.paginate_button').focus(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').addClass('focused');
      });
      jQuery('div#table_1_paginate a.paginate_button').focusout(function(){
      	jQuery('#table_1_wrapper.wpDataTablesWrapper').removeClass('focused');
      });
    }, 2000);
    
    
    
    
    /* FEATURE VIDEO START */
    jQuery(document).ready(function(){
      
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/player_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      
        var ytplayer = [];
        var focuscontainer;
        window.onYouTubePlayerAPIReady = function() {
            setTimeout(function(){            
                jQuery('.oese-featured-video-shrtcd-ytvideo').each(function(i, obj) {
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
                jQuery(document).on('click','.oese-video-close', function(e){
                  e.preventDefault ? e.preventDefault() : e.returnValue = false;
                  jQuery('.oese-featured-video-shrtcd-overlay').modal('hide');
                });
                jQuery(document).on('click','.oese-video-link',function(e){
                    var cnt = jQuery(this).attr('cnt');
                    if(typeof ytplayer[cnt] != 'undefined' && typeof ytplayer[cnt].playVideo == 'function'){
                      var modalid = jQuery(this).attr('data-tgt');
                      jQuery(modalid).addClass('show');
                      jQuery(modalid).modal('show');
                      ytplayer[cnt].playVideo();
                      focuscontainer = setInterval(function() {
                            jQuery('#oese-featured-video-shrtcd-overlay-'+cnt).focus();
                      }, 500);
                    }
                });
                jQuery(document).on('hide.bs.modal', '.oese-featured-video-shrtcd-overlay', function () {
                    var cnt = jQuery(this).attr('cnt');
                    ytplayer[cnt].pauseVideo();
                    clearInterval(focuscontainer);
                });
                jQuery('.oese-featured-video-shrtcd-overlay').on('mouseup',function(e){
                  e.preventDefault ? e.preventDefault() : e.returnValue = false;
                  var txtClass = jQuery(e.target).attr("class");
                })          
            }, 500);
        }
    });  
    
    
});

function addnavaccsttr(){
  jQuery('.paginate_button.first').attr({'data-value': 'Navigate to first page','aria-label': 'Navigate to first page','title': 'Navigate to first page'})
  jQuery('.paginate_button.previous').attr({'data-value': 'Navigate to previous page','aria-label': 'Navigate to previous page','title': 'Navigate to previous page'})
  jQuery('.paginate_button.next').attr({'data-value': 'Navigate to next page','aria-label': 'Navigate to next page','title': 'Navigate to next page'})
  jQuery('.paginate_button.last').attr({'data-value': 'Navigate to last page','aria-label': 'Navigate to last page','title': 'Navigate to last page'})    
  jQuery('.dataTables_paginate>span').children('a.paginate_button').each(function(e) {
    var pageno = jQuery(this).text();
    jQuery(this).attr({'data-value': 'Navigate to page '+pageno,'aria-label': 'Navigate to page '+pageno,'title': 'Navigate to page '+pageno,	});
  });
}

function displayNext10Results() {
    /** Insert Next 10 results button on the fly **/
    if (jQuery('.paginate_div #pagination-flickr').is(":visible")) {
        var nextPage = jQuery('.cls_search form .ui-widget input[id="paginate"]').val();
        if (nextPage==0) {
            nextPage = 1;
        }
        
        nextPage = parseInt(nextPage) + 1;
        var next10 = '<li><a class="paginate show next" href="javascript:void(0)" id="' + nextPage + '">Next 10 Results</a></li>';
        jQuery('.paginate_div #pagination-flickr').append(next10);
    }
}

function displayPrev10Results() {
    /** Insert Prev 10 results button on the fly **/
    if (jQuery('.paginate_div #pagination-flickr').is(":visible")) {
        var curPage = jQuery('.cls_search form .ui-widget input[id="paginate"]').val();
        if (curPage==0 || curPage==1)
            return;
        
        prevPage = parseInt(curPage) - 1;
        var prev10 = '<li><a class="paginate show prev" href="javascript:void(0)" id="' + prevPage + '">Previous 10 Results</a></li>';
        jQuery('.paginate_div #pagination-flickr').prepend(prev10);
    }
}

// Event Tracker Function
function oese_trackEvent(eventCategory, eventAction, eventLabel, eventValue = null) {
    eventLabel = eventLabel.toString();

    // To make all google event param in lower case
    eventLabel      = eventLabel.toLowerCase();
    eventAction     = eventAction.toLowerCase();
    eventCategory   = eventCategory.toLowerCase();
    
    if (typeof ga != 'undefined' && ga != null){
        if(eventValue == null)
          return ga('send', 'event',eventCategory,eventAction,eventLabel)
        else
          eventValue = eventValue.toLowerCase()
          return ga('send', 'event',eventCategory,eventAction,eventLabel,eventValue)
    }
    return 0;
}



/* -------------- */
/* WDT-RESPONSIVE
/* -------------- */

jQuery(document).ready(function(){
  var wpdtTimerArray = []; 
  var wpdtAccssArray = []; 
  var wpdtInstanceCntr = 0; 
  var wpdtLiveAdded = 0;
  jQuery('.wpdt-c').each(function(i, obj) {
    wpdtTimerArray[wpdtInstanceCntr] = setTimeout(function(){
      if(jQuery(obj).find('table.wpDataTable').length){
        wpdtExists = 1;
        clearTimeout(wpdtTimerArray[wpdtInstanceCntr]);
        var wpdtMainWrapper = jQuery(obj);
        wpdtMainWrapper.find('table.wpDataTable').wrap('<div class="wdtResponsiveWrapper"></div>');
        
        wpdtMainWrapper.find('.wpDataTablesWrapper .dataTables_length').addClass('wpnn_wpdt_action_item');
        wpdtMainWrapper.find('.wpDataTablesWrapper .dataTables_filter').addClass('wpnn_wpdt_action_item');
        wpdtMainWrapper.find('.wpDataTablesWrapper .dataTables_compare_message').addClass('wpnn_wpdt_action_item');
        
        wpdtMainWrapper.find('.wpnn_wpdt_action_item').wrapAll('<div class="wpnn_wpdt_action_wrapper table'+wpdtInstanceCntr+'" />');
        
        jQuery(obj).addClass('wpdt_main_wrapper');
        jQuery(obj).attr('id','wpdt_main_wrapper_'+wpdtInstanceCntr);
        
        jQuery( window ).scroll(function(){
          wpdt_freeze_header_func(wpdtMainWrapper);
        });

        jQuery(window).resize(function(){
          wpdt_freeze_header_func(wpdtMainWrapper);
        });
        
        if(wpdtLiveAdded == 0){
          jQuery('body').prepend('<div aria-live="polite" aria-atomic="true" class="wpdt-accessibility-liveregion visuallyhidden"></div>');
          jQuery(document).on('focus','.wdt-select-filter ul.dropdown-menu li a',function(){
              var wpdt_cbx_label = jQuery(this).closest('.wpDataTableFilterSection').find('label').text();
              var wpdt_opt_text = jQuery(this).closest('ul.dropdown-menu').find('li.active span.text').text();
              if(jQuery(this).attr('aria-selected') == "true"){
                if(wpdt_opt_text.trim() > ''){
                  jQuery('.wpdt-accessibility-liveregion').text(wpdt_opt_text+' selected');
                }else{
                  jQuery('.wpdt-accessibility-liveregion').text('Please select from the list below');
                }
              }else{
                if(wpdt_opt_text.trim() != ''){
                  jQuery('.wpdt-accessibility-liveregion').text(wpdt_opt_text);
                }else{
                  jQuery('.wpdt-accessibility-liveregion').text('Empty Choice');
                }
              }
          });
          
          jQuery(document).on('focus','.wdt-multiselect-filter ul.dropdown-menu li a',function(){
              var wpdt_cbx_label = jQuery(this).closest('.wpDataTableFilterSection').find('label').text();
              var wpdt_opt_text = jQuery(this).find('span.text').text();
              if(jQuery(this).attr('aria-selected') == "true"){
                jQuery('.wpdt-accessibility-liveregion').text(wpdt_opt_text+' selected press enter to remove from list');
              }else{
                  jQuery('.wpdt-accessibility-liveregion').text(wpdt_opt_text+' press enter to add to list');
              }
              
          });
          
        }
        wpdtLiveAdded = 1;

          
        //ACCESSIBILITY
        // aria-label for dropdown boxes in the filter section
        var listboxobserver = new MutationObserver(function(mutations) {
          for (let mutation of mutations) {
             if (mutation.type === 'childList') {
               jQuery(mutation.target).find('li').attr('role','presentation');
             }
             if (mutation.type === 'attributes') {
               jQuery(mutation.target).siblings('.bs-searchbox').find('input').attr('aria-expanded',jQuery(mutation.target).attr('aria-expanded'));
             }
          }
        });
        
        if(jQuery(obj).find('.wpDataTableFilterBox').length){
          jQuery(obj).find('.wpDataTableFilterSection').find('button.dropdown-toggle').each(function(index,obj){
              var button_lbl = jQuery(obj).closest('.wpDataTableFilterSection').find('label').text();
              jQuery(obj).attr('aria-label',button_lbl);
              jQuery(obj).siblings('.wdt-filter-control').attr('aria-label',button_lbl);
              jQuery(obj).removeAttr('role');
              var wpdt_instance_id = parseInt(jQuery(obj).closest('.wpdt_main_wrapper').attr('id').replace('wpdt_main_wrapper_',''));
              var dtidx = '_'+wpdt_instance_id+'_'+jQuery(obj).siblings('.wdt-filter-control').attr('data-index');
              jQuery(obj).siblings('.wdt-filter-control').attr('id','combobox'+dtidx);
              jQuery(obj).attr('aria-owns','combobox'+dtidx);            
              jQuery(obj).siblings('.dropdown-menu').removeAttr('role').find('.bs-searchbox').find('input').attr('role','combobox').attr('aria-owns','listbox'+dtidx).attr('aria-expanded','false');
              jQuery(obj).siblings('.dropdown-menu').find('ul.dropdown-menu').attr('id','listbox'+dtidx).attr('aria-label', button_lbl.replace(':',''));            
              listboxobserver.observe(document.querySelector('#listbox'+dtidx), {childList: true,attributes: true});            
          });
          
          jQuery(obj).find('.wpDataTableFilterSection').find('select.wdt-select-filter').each(function(index,obj){
              var select_lbl = jQuery(obj).closest('.wpDataTableFilterSection').find('label').text();
              jQuery(obj).attr('aria-label',select_lbl);
          });
        }
        
        
        
        jQuery.each(wpDataTables, function(index, item) {
          var cur_wpdt_instance = wpdtMainWrapper.find('table.wpDataTable').attr('id');
          if(cur_wpdt_instance == index){
            var wpdt_obj = jQuery('#'+cur_wpdt_instance);
            var pgnt_obj = jQuery('#'+cur_wpdt_instance+'_paginate');

            pgnt_obj.find('a.paginate_button.disabled').attr('tabindex','-1');
            wpdt_obj.find('tr td a.external_link').attr('tabindex','0');
            wpdt_obj.find('tr td a.external_link button').attr('tabindex','-1');
            
            pgnt_obj.find('.paginate_button').remove('span');
            pgnt_obj.find('.paginate_button.current').append('<span>Current Page</span>');
            
            item.addOnDrawCallback( function(wpdt_gbl_instance_cntr){

              setTimeout(function(){
                pgnt_obj.find('a.paginate_button').attr('tabindex','0');
                pgnt_obj.find('a.paginate_button.disabled').attr('tabindex','-1');
                
                wpdt_obj.find('tr td.column-masterdetail a.master_detail_column_btn').attr('tabindex','0');
                wpdt_obj.find('tr td a.external_link').attr('tabindex','0');
                wpdt_obj.find('tr td a.external_link button').attr('tabindex','-1');
                
                pgnt_obj.find('.paginate_button').remove('span');
                pgnt_obj.find('.paginate_button.current').append('<span>Current Page</span>');
                
              },500);
            })
          }
        });

        wpdtInstanceCntr++;
      }
    },100);

  });
  
});

/* ----------------------- */
/* FIXED WPDT TABLE HEADER */
/* ----------------------- */

function wpdt_freeze_header_func(obj){
  var wpdt_target_table_wrapper = obj.find('.wdtResponsiveWrapper').closest('.wpDataTablesWrapper');
  var wpdt_sticky_padding = 10;
  if( jQuery('#wpadminbar').length > 0 ){
    obj.find('.wdtResponsiveWrapper').addClass('admin');
    //wpdt_sticky_padding = parseInt(jQuery('html').css('marginTop')) + 10;
    wpdt_sticky_padding = parseInt(jQuery('#wpadminbar').outerHeight()) + 10;
  }else{
    obj.find('.wdtResponsiveWrapper').removeClass('admin');
  }
  
  var compare_message_height = 0;
  if(wpdt_target_table_wrapper.find('.dataTables_compare_message').length > 0){
    var compare_message_elm = wpdt_target_table_wrapper.find('.dataTables_compare_message');
    compare_message_height = (compare_message_elm.outerHeight() + parseInt(compare_message_elm.css('marginBottom'))) - 18;
  }else{
    compare_message_height = compare_message_height + 10; 
  }
  
  var wpdt_table_top = wpdt_target_table_wrapper.offset().top;
  var elm = wpdt_target_table_wrapper.find('div.dt-buttons'); /*jQuery('.wpDataTablesWrapper>div.dt-buttons');*/
  var wpdt_buttons_section_height = parseInt(elm.outerHeight()) + parseInt(elm.css('marginBottom'));
  var wpdt_message_height = 0;
  var wpdt_tblhdr_above_elements = jQuery(window).scrollTop() - (wpdt_table_top + (wpdt_buttons_section_height + compare_message_height));
  
  if(wpdt_tblhdr_above_elements > 0){
    obj.find('.wpnn_wpdt_action_wrapper').css("padding-top", wpdt_sticky_padding+'px');
  }else{
    obj.find('.wpnn_wpdt_action_wrapper').css("padding-top", '0px');
  }
  
	obj.find('.wdtResponsiveWrapper table thead tr th').css({'top' : wpdt_tblhdr_above_elements + 'px'});  
}


/* -------------------------------- */
/* Footer fixed positioning on 404  */
/* -------------------------------- */
jQuery( document ).ready(function() {
  if(jQuery("body").hasClass("error404")){
      jQuery("html").addClass('fullheight');
  }
});