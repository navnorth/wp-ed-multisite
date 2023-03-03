/*
var edit_post_layout_metaboxes_timer = setInterval(function(){
  if ( jQuery('.edit-post-layout__metaboxes').length > 0 ){
    jQuery('.edit-post-layout__metaboxes').hide();
    clearInterval(edit_post_layout_metaboxes_timer);
  }
}, 100);
*/
jQuery( document ).ready(function() {
    jQuery('#page_template').on('change', function() {
	  //alert(this.value);
	 });
    // Enable Crazy Egg Script Checkbox change handler
    jQuery('#wp_oese_theme_include_crazy_egg_script').on("change", function(){
      jQuery('#wp-oese-theme-settings .settings-error').hide();
      if (this.checked){
        jQuery('#wp_oese_theme_crazy_egg_script_address').removeAttr("readonly");
      } else {
        jQuery('#wp_oese_theme_crazy_egg_script_address').attr("readonly", true);
        jQuery('#wp_oese_theme_crazy_egg_script_address').focus();
      }
    });
    jQuery('#wp_oese_theme_crazy_egg_script_address').on('blur', function(e){
      var errorDisplay = jQuery('#wp-oese-theme-settings').find(".settings-error");
      var errText = jQuery('#wp-oese-theme-settings').find(".settings-error").text();
      if (jQuery('#wp_oese_theme_include_crazy_egg_script').is(":checked") && (!jQuery(this).val())) {
        jQuery(this).addClass('required');

        if (errText.length>0)
          errText += " Crazy Egg Script cannot be empty!";
        else
          errText = "Crazy Egg Script cannot be empty!";

        errorDisplay.text(errText);
        errorDisplay.show()
        errorDisplay.removeClass('hidden').css("color","#ff0000");
      } else {
        jQuery(this).removeClass('required');
      }
    });

    //Enable UA Tracking Script Change Handler
    jQuery('#wp_oese_theme_include_UA_tracking_script').on("change", function(){
      jQuery('#wp-oese-theme-settings .settings-error').hide();
      if (this.checked==true){
        jQuery('#wp_oese_theme_ga_propertyid').removeAttr("readonly");
      } else {
        jQuery('#wp_oese_theme_ga_propertyid').attr("readonly", true);
        jQuery('#wp_oese_theme_ga_propertyid').focus();
      }
    });
    jQuery('#wp_oese_theme_ga_propertyid').on('blur', function(e){
      var errorDisplay = jQuery('#wp-oese-theme-settings').find(".settings-error");
      var errText = jQuery('#wp-oese-theme-settings').find(".settings-error").text();
      if (jQuery('#wp_oese_theme_include_UA_tracking_script').is(":checked") && (!jQuery(this).val())) {
        jQuery(this).addClass('required');

        if (errText.length>0)
          errText += " UA Property ID cannot be empty!";
        else
          errText = "UA Property ID cannot be empty!";

        errorDisplay.text(errText);
        errorDisplay.show()
        errorDisplay.removeClass('hidden').css("color","#ff0000");
      } else {
        jQuery(this).removeClass('required');
      }
    });

    //Enable GA4 Tracking Script Change Handler
    jQuery('#wp_oese_theme_include_GA4_tracking_script').on("change", function(){
      jQuery('#wp-oese-theme-settings .settings-error').hide();
      if (this.checked){
        jQuery('#wp_oese_theme_ga4_propertyid').removeAttr("readonly");
      } else {
        jQuery('#wp_oese_theme_ga4_propertyid').attr("readonly", true);
        jQuery('#wp_oese_theme_ga4_propertyid').focus();
      }
    });
    jQuery('#wp_oese_theme_ga4_propertyid').on('blur', function(e){
      var errorDisplay = jQuery('#wp-oese-theme-settings').find(".settings-error");
      var errText = jQuery('#wp-oese-theme-settings').find(".settings-error").text();
      if (jQuery('#wp_oese_theme_include_GA4_tracking_script').is(":checked") && (!jQuery(this).val())) {
        jQuery(this).addClass('required');

        if (errText.length>0)
          errText += " GA4 Property ID cannot be empty!";
        else
          errText = "GA4 Property ID cannot be empty!";

        errorDisplay.text(errText);
        errorDisplay.show()
        errorDisplay.removeClass('hidden').css("color","#ff0000");
      } else {
        jQuery(this).removeClass('required');
      }

    });
    jQuery('#wp_oese_theme_ga4_propertyid,#wp_oese_theme_ga_propertyid,#wp_oese_theme_crazy_egg_script_address').on('change', function(e){
      jQuery(this).removeClass('required');
      var errorDisplay = jQuery('#wp-oese-theme-settings').find(".settings-error");
      errorDisplay.text("");
      errorDisplay.hide()
    });

    jQuery('.contact-edit').on("click", function(e){
        e.preventDefault();
        if (confirm('Are you sure that you want to change the global Contact page selection?')==true){
            jQuery('#wp_oese_theme_contact_page').show();
            jQuery(this).hide();
            jQuery('.contact-edit-link').hide();
        }
    });
    jQuery('.oese-tabs').tabs();
    
    //image-edit update button fix
    jQuery(document).ready( function($){
      let mediaEditorUpdateButtonTimer;
      jQuery(document).on('click','.imgedit-submit input.imgedit-submit-btn',function(e){
        mediaEditorUpdateButtonTimer = setInterval(function(){
          let meditelm = jQuery('.media-frame-toolbar .media-toolbar .media-toolbar-primary button.media-button');
          let cls1 = meditelm.hasClass('button-primary');
          let cls2 = meditelm.hasClass('media-button-select');
          if(!cls1 && cls2){
            meditelm.addClass('button-primary');
            meditelm.text('Update');
            clearInterval(mediaEditorUpdateButtonTimer);
          }
        }, 500);
      }),wp.media.view.Modal.prototype.on('close', function(data) {
          clearInterval(mediaEditorUpdateButtonTimer);
      });
    });   
    
})



/* ******************** */
/* PERMALINK VALIDATION */
/* ******************** */
jQuery( document ).ready(function() {
  var posttype = getPostType();
  if(posttype != 'undefined' && (posttype == 'page' || posttype == 'post')){
    //Save Draft Button
    if(jQuery('#minor-publishing-actions #save-action #save-post').length){
      var btnText = jQuery('#minor-publishing-actions #save-action #save-post').attr('value');
      jQuery('#minor-publishing-actions #save-action #save-post').hide();
      jQuery('<input type="submit" name="save" id="secondary-save-post" value="'+btnText+'" class="button">').insertAfter(jQuery('#minor-publishing-actions #save-action #save-post'));
    }
    //Publish Button
    if(jQuery("#publish").length){
      var btnText = jQuery("#publish").attr('value');
      jQuery("#publish").hide();
      jQuery('#publishing-action').append('<input type="submit" name="publish" id="secondary-publish" class="button button-primary button-large" value="'+btnText+'">')
    }
  }
  //Save Draft Title Field Enter Key Event
  jQuery(document).on('keydown','input[name="post_title"]',function(e){
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if(keycode == '13'){
      e.preventDefault ? e.preventDefault() : e.returnValue = false;
    }
  })
  //Secondary Update Button Click Event
  jQuery(document).on('click','#secondary-save-post',function(e){
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    if(!jQuery('body').hasClass('home')){
      jQuery('input[name="post_title"]').trigger('blur');    
      var checkExist = setInterval(function() {
         if (jQuery('span#editable-post-name').length) {
            clearInterval(checkExist);
            interceptPublish('dft');
         }
      }, 100); // check every 100ms
    }else{
      jQuery("#publish").click();
    } 
  })
  //Publish Button Click Event
  jQuery(document).on('click','#secondary-publish',function(e){
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    
    var element = document.getElementById("oese-preview-draft-publish-warning");
    if(typeof(element) != 'undefined' && element != null){
      var r = confirm('WARNING: Publishing this preview will overwrite its original version.\r\n\r\nIf you only wish to save this revision for review, please cancel this prompt and click "Save Draft" button instead.');
      if (r == true) {
        if(!jQuery('body').hasClass('home')){
          jQuery('input[name="post_title"]').trigger('blur');    
          var checkExist = setInterval(function() {
             if (jQuery('span#editable-post-name').length) {
                clearInterval(checkExist);
                interceptPublish('pub');
             }
          }, 100); // check every 100ms    
        }else{
          jQuery("#publish").click();
        } 
      }
    }else{
      if(!jQuery('body').hasClass('home')){
        jQuery('input[name="post_title"]').trigger('blur');    
        var checkExist = setInterval(function() {
           if (jQuery('span#editable-post-name').length) {
              clearInterval(checkExist);
              interceptPublish('pub');
           }
        }, 100); // check every 100ms    
      }else{
        jQuery("#publish").click();
      }
    }
    
    
    /*
    var element = document.getElementById("oese-preview-url-input");
    if(typeof(element) != 'undefined' && element != null){
      var r = confirm("WARNING: Publishing this revision will overwrite its original.");
      if (r == true) {    
        if(!jQuery('body').hasClass('home')){
          jQuery('input[name="post_title"]').trigger('blur');    
          var checkExist = setInterval(function() {
             if (jQuery('span#editable-post-name').length) {
                clearInterval(checkExist);
                interceptPublish('pub');
             }
          }, 100); // check every 100ms    
        }else{
          jQuery("#publish").click();
        }  
      }
    }else{
      if(!jQuery('body').hasClass('home')){
        jQuery('input[name="post_title"]').trigger('blur');    
        var checkExist = setInterval(function() {
           if (jQuery('span#editable-post-name').length) {
              clearInterval(checkExist);
              interceptPublish('pub');
           }
        }, 100); // check every 100ms    
      }else{
        jQuery("#publish").click();
      }  
    }
    */
    
  })
  //Notice Dismiss
  jQuery(document).on('click','.oese-permalink-validation-notice-dismiss',function(e){
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    jQuery('.oese-prohibitedpermalinktext.notice').hide(100,function(){
      jQuery('.oese-prohibitedpermalinktext.notice').remove();
    });    
  })

  //Override fix for metabox expand/collapse
  var oese_template_changed = false;
  jQuery(document).on('change','.components-select-control__input', function() {
      oese_template_changed = true;
      console.log(oese_template_changed);
      var editorContainer     = jQuery( 'body' ),
      templateSelectClass = '.editor-page-attributes__template select';
      let template = jQuery(this).val();
      let pageTemplate = template
              .substr( template.lastIndexOf( '/' ) + 1, template.length )
              .replace( /\.php$/, '' )
              .replace( /\./g, '-' );
      editorContainer
        .removeClass( function( index, className ) {
          return ( className.match( /\bpage-template-|page-templates_[^ ]+/ ) || [] ).join( ' ' );
        } )
        .addClass( 'page-template-' + pageTemplate );

  });
  
  
})



jQuery(window).bind("load", function() {  
  
  oese_template_metaboxes_event_unbind_func();
  
  jQuery('.edit-post-layout__metaboxes').show();
  jQuery(document).on('mouseup','button.handlediv',function(e){
      var expand = jQuery(this).attr('aria-expanded');
      var postbox = jQuery(this).closest('.postbox');
      var closed = postbox.hasClass('closed');
      // manual condition instead of toggle as the latter doesn't work on test server
      if (expand ==='true'){
        postbox.find('.inside').hide();
        jQuery(this).attr('aria-expanded','false');
        jQuery(this).closest('.postbox').addClass('closed');
      }else{
        postbox.find('.inside').show();
        jQuery(this).attr('aria-expanded','true');
        jQuery(this).closest('.postbox').removeClass('closed');
      }
  })
  
  //Reinstantiate unbind on template change
  function oese_initiate_tempalte_switch_observer(){
    setTimeout(function(){
      oese_create_tempalte_switch_observer(document.querySelector(".edit-post-layout__metaboxes"));
    }, 500);
  }

  var oese_template_change_observer_func = new MutationObserver(function(mutations) {
    oese_template_metaboxes_event_unbind_func();
  });
  
  function oese_create_tempalte_switch_observer(elementToObserve){
    oese_template_change_observer_func.observe(elementToObserve, {childList: true, subtree: true });
  }
  
  function oese_template_metaboxes_event_unbind_func(){
    jQuery('button.handlediv').off('click');
    jQuery('.toggle-indicator').off('click');
    jQuery('h2.hndle.ui-sortable-handle').off('click');
    //jQuery('.postbox').off('click');
  }
  
  let TemplateSwitchIntervalCntr = 0;
  let TemplateSwitchInterval = setInterval(function(){
    TemplateSwitchIntervalCntr++;
    if(jQuery('.edit-post-layout__metaboxes').length){
      clearInterval(TemplateSwitchInterval);
      oese_initiate_tempalte_switch_observer();
      jQuery('.handle-order-lower').removeClass('hidden');
      jQuery('.handle-order-higher').removeClass('hidden');
    }else{
      if(TemplateSwitchIntervalCntr > 1800){
        clearInterval(TemplateSwitchInterval);
      }
    }
  }, 100);
  
});


var itvl;
function interceptPublish(typ){
    
    if(jQuery('input#new-post-slug').length){
        var slug = jQuery('input#new-post-slug').val(); 
    }else{
        var slug = jQuery('span#editable-post-name').text(); 
    }
    var prhbt = ["admin", "login", "user"];  
    var found = false;
    prhbt.forEach(function(item) {
        var idx = slug.indexOf(item);
        if(idx == 0){//found in the beginning
          found = true;
        }
    });
    if(found){
      var html = '<div class="oese-prohibitedpermalinktext notice notice-error is-dismissible" style="display:none;"><p>Please make sure the permalink doesn\'t begin with words such as <strong>admin, login, and user</strong> as they are known to cause issues</p><button type="button" class="oese-permalink-validation-notice-dismiss notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
      if (!jQuery('.oese-prohibitedpermalinktext').length){
        jQuery(html).insertAfter('hr.wp-header-end');
        jQuery('.oese-prohibitedpermalinktext').show(100);
      }
    }else{
      if(typ == 'pub'){
        jQuery("#publish").click();
      }else if(typ == 'dft'){
        jQuery("#save-post").click();
      }
    }

}

function getPostType(){
    var postType; var ret;
    var attrs = jQuery( 'body' ).attr( 'class' ).split( ' ' );
    jQuery( attrs ).each(function() {
      if (this.indexOf("post-type-") >= 0){
				postType = this.split( 'post-type-' );
        postType = postType[ postType.length - 1 ];	
				ret = postType;	
			}	
		});
  return ret;
}

function ispagehome(){
  var ret = false;
  if ( jQuery('body').hasClass('home')) {
      ret = true;
  }
  return ret;
}


// WP dataTables
jQuery(document).ready(function(){
  jQuery('div.wpdt-c').each(function(i, obj) {
    wpdtAdminTimer = setTimeout(function(){
      if(jQuery(obj).find('table.wpDataTable').length){
        clearTimeout(wpdtAdminTimer);
        var wpdtMainWrapper = jQuery(obj);
        wpdtMainWrapper.find('table.wpDataTable').wrap('<div class="wdtResponsiveWrapper"></div>');
        jQuery(obj).addClass('wpdt_main_wrapper');
        jQuery(obj).attr('id','wpdt_main_wrapper_'+0);
      }
    },100);
  });
});
