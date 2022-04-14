function showPublicationMetabox(){
  var select = jQuery('#page_template,.edit-post-sidebar .components-panel__body.is-opened [data-wp-component="Flex"].components-select-control .components-select-control__input, .edit-post-sidebar .components-panel__body.is-opened .editor-page-attributes__template.components-select-control .components-select-control__input');
  if (select.length){
    jQuery('#story_metabox').toggle(select.val()=='page-templates/story-template.php');
    jQuery('#publication_metabox').toggle(select.val()=='page-templates/publication-template.php');
  }
}

jQuery( document ).ready(function() {
  //enable/disable during load
  if (jQuery("#enablecontactslider").is(':checked')) {
    jQuery('#contactsliderpage').prop('disabled',false);
  } else {
    jQuery('#contactsliderpage').prop('disabled',true);
  }
    
  //enable/disable contact slider dropbox on ticking enable slider checkbox
  jQuery('#enablecontactslider').on('change', function() {
  	if (jQuery(this).is(':checked')) {
  	    jQuery('#contactsliderpage').prop('disabled',false);
  	} else {
  	    jQuery('#contactsliderpage').prop('disabled',true);
  	}
  });
    
  jQuery(".widget[id*='featuredcontentwidgetdetails'").each(function(i, obj){
	 if (jQuery(this).find('.widget-title span.in-widget-title').length) {
	    var title = jQuery(this).find('.widget-title span.in-widget-title');
	    var label = jQuery(this).find(".widget-inside input.widefat[id*='label']");
	    setTimeout(function() {
		    var title_text = title.text();
		    if (label.val().length>0) {
		      title_text = ": " + label.val();
		    }
		    title.html(title_text);
	    }, 1);
    }
  });
    
  jQuery("input[type=radio][name=mpubdisplay]").on("change",function(){
    if (jQuery(this).value=="selective"){
	    jQuery(".meta_main_wrp input[type=checkbox]").prop("checked",true);
    } else {
	    jQuery(".meta_main_wrp input[type=checkbox]").prop("checked",false);
    }
  });
    
  jQuery("#debug_medium").on("click", function(e){
    e.preventDefault();
    data = {
	    action: 'debug_medium_connection',
    }

    //* Process the AJAX POST request
    jQuery.post(
	    ajaxurl,
	    data
	    ).done( function(response) {
        verbose = jQuery("#oer_verbose_block");
        verbose.html("");
        verbose.html(response);
    });

	   return false;
  });
    
  jQuery(document).on("change",'#page_template,.edit-post-sidebar .components-panel__body.is-opened [data-wp-component="Flex"].components-select-control .components-select-control__input, .edit-post-sidebar .components-panel__body.is-opened .editor-page-attributes__template.components-select-control .components-select-control__input', showPublicationMetabox);
    
  jQuery('.oet_sidebar_section_youtube_modal_trg').change(function() {
    if(this.checked) {
      jQuery(this).siblings('.oet_sidebar_section_youtube_modal_opt').val(1);
    }else{
      jQuery(this).siblings('.oet_sidebar_section_youtube_modal_opt').val(0);
    }      
  });
  
  setTimeout(function(){ showPublicationMetabox(); },500);
});



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
    console.log(jQuery('body').hasClass('home'));
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
  })
  // Preview Story
  if (jQuery('.acf-field-post-object[data-name="oet_sidebar_story_content_story"]').length) {
    jQuery('.acf-field-post-object[data-name="oet_sidebar_story_content_story"]').each(function(){
      let inputGrp = jQuery(this).find('.acf-input');
      inputGrp.find('.select2-container').css({"width":"95%"});
      inputGrp.append('<span class="preview-story"><a href="#" class="oet-sidebar-story-url" disabled="disabled" target="_blank"><i class="fa fa-2x fa-external-link" aria-hidden="true"></i></a></span>');
    });
    jQuery(document).on('change','.acf-field-post-object[data-name="oet_sidebar_story_content_story"] .select2-hidden-accessible', function(e){
      e.preventDefault();
      var target = jQuery(this).parent().find('.preview-story .oet-sidebar-story-url');
      if (jQuery(this).val())
        target.attr("disabled",false);
      jQuery.post(oet_ajax_object.ajaxurl,
      {
          action:'oet_sidebar_story_url_callback',
          id: jQuery(this).val()
      }).done(function (response) {
          target.attr('href',response);
      });
    });
  }
  // Preview Section
  if (jQuery('.acf-field-flexible-content .acf-input .acf-flexible-content .values .layout').length){
    jQuery('.acf-field-flexible-content .acf-input .acf-flexible-content .values .layout').each(function(){
      let layoutControls = jQuery(this).find('.acf-fc-layout-controls');
      layoutControls.prepend('<a class="oet-sidebar-preview-section acf-icon -preview small light acf-js-tolltip" href="#" data-toggle="modal" data-target="#oet-dynamic-sidebar-preview" data-name="section-preview" title="Preview"><i class="fa fa-eye" aria-hidden="true"></i></a>');
    });
    var target = jQuery('#oet-dynamic-sidebar-preview .modal-body .preview-body');
    var loader = target.find('.preview-loader');
    jQuery(document).on('click','.oet-sidebar-preview-section', function(e){
      e.preventDefault();
      var layout = jQuery(this).closest('.layout[data-layout="section"]');
      var fields = layout.find('.acf-fields');
      var data = [];
      var modalBody = jQuery('#oet-dynamic-sidebar-preview .modal-body');
      var page_id = jQuery('#oet-dynamic-sidebar-preview').attr('data-page-id');
      var acf_layout = jQuery(this).closest('.acf-fc-layout-controls');
      var acf_fields = acf_layout.next('.acf-fields');
      var acf_repeater = acf_fields.find('.acf-field-repeater:not(.acf-hidden) .acf-table .acf-row:not(.acf-clone)');
      var acf_data = [];
      
      data['title'] = fields.find('.acf-field[data-name="oet_sidebar_section_title"] .acf-input input[type="text"]').val();
      data['icon'] = fields.find('.acf-field[data-name="oet_sidebar_section_icon"] .acf-input select').val();
      data['type'] = fields.find('.acf-field[data-name="oet_sidebar_section_type"] .acf-input select').val();
      
      var i = 0;
      switch (data['type']){
        case "html":
          /* WYSIWYG Content */
          let acf_wysiwyg_instance = acf_fields.find('.acf-field.acf-field-wysiwyg[data-name=oet_sidebar_html_content]:not(.acf-hidden)');
          let acf_editor_id = acf_wysiwyg_instance.find('.wp-editor-area').attr('id');
          let acf_iframe = jQuery('#' + acf_editor_id + '_ifr');
          let acf_editorContent = jQuery('#tinymce[data-id="' + acf_editor_id + '"]', acf_iframe.contents()).html();
          
          acf_data[i] = { "content": acf_editorContent };
          
          break;
        case "link":
          acf_repeater.each(function(index,val){
            /* Title */
            let acf_title_instance = jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_page_link_title]:not(.acf-hidden)');
            let acf_title = acf_title_instance.find(".acf-input input").val();

            /* WYSIWYG Content */
            let acf_wysiwyg_instance = jQuery(this).find('.acf-field.acf-field-wysiwyg[data-name=oet_sidebar_page_link_short_description]:not(.acf-hidden)');
            let acf_editor_id = acf_wysiwyg_instance.find('.wp-editor-area').attr('id');
            let acf_iframe = jQuery('#' + acf_editor_id + '_ifr');
            let acf_editorContent = jQuery('#tinymce[data-id="' + acf_editor_id + '"]', acf_iframe.contents()).html();

            /* Page URL */
            let acf_page= jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_page_link_url]:not(.acf-hidden)');
            let acf_page_url = acf_page.find(".acf-input input").val();
            acf_data[i] = { "title" : acf_title, "content": acf_editorContent, "page_url": acf_page_url };
            i++;
          });
          break;
        case "image":
          acf_repeater.each(function(index,val){
            /* Title */
            let acf_title_instance = jQuery(this).find('.acf-field.acf-field-text:not(.acf-hidden)');
            let acf_title = acf_title_instance.find(".acf-input input").val();

            /* WYSIWYG Content */
            let acf_wysiwyg_instance = jQuery(this).find('.acf-field.acf-field-wysiwyg:not(.acf-hidden)');
            let acf_editor_id = acf_wysiwyg_instance.find('.wp-editor-area').attr('id');
            let acf_iframe = jQuery('#' + acf_editor_id + '_ifr');
            let acf_editorContent = jQuery('#tinymce[data-id="' + acf_editor_id + '"]', acf_iframe.contents()).html();

            /* Image */
            let acf_image = jQuery(this).find('.acf-field.acf-field-image:not(.acf-hidden)');
            let acf_image_id = acf_image.find('.acf-input .has-value input').val();
            let acf_image_url = acf_image.find('.acf-input .has-value .show-if-value.image-wrap img').attr('src');
            acf_data[i] = { "title" : acf_title, "content": acf_editorContent, "image_id": acf_image_id, "image_url":acf_image_url };
            i++;
          });
          break;
        case "youtube":
          acf_repeater.each(function(index,val){
            /* Title */
            let acf_title_instance = jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_youtube_content_title]:not(.acf-hidden)');
            let acf_title = acf_title_instance.find(".acf-input input").val();

            /* WYSIWYG Content */
            let acf_wysiwyg_instance = jQuery(this).find('.acf-field.acf-field-wysiwyg:not(.acf-hidden)');
            let acf_editor_id = acf_wysiwyg_instance.find('.wp-editor-area').attr('id');
            let acf_iframe = jQuery('#' + acf_editor_id + '_ifr');
            let acf_editorContent = jQuery('#tinymce[data-id="' + acf_editor_id + '"]', acf_iframe.contents()).html();

            /* Playlist ID */
            let acf_playlist = jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_youtube_content_playlist_id]:not(.acf-hidden)');
            let acf_playlist_id = acf_playlist.find(".acf-input input").val();

            /* Youtube Video ID */
            let acf_yt_video = jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_youtube_content_video_id]:not(.acf-hidden)');
            let acf_yt_video_id = acf_yt_video.find(".acf-input input").val();

            /* Youtube Video ID */
            let acf_playback = jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_youtube_content_modal_playback]:not(.acf-hidden)');
            let acf_playback_modal = acf_playback.find(".acf-input input[type=checkbox").is(":checked");

            acf_data[i] = { "title" : acf_title, "content": acf_editorContent, "playlist_id": acf_playlist_id, "video_id": acf_yt_video_id, "playback_modal": acf_playback_modal };
            i++;
          });
          break;
        case "medium":
          acf_repeater.each(function(index,val){
            /* Title */
            let acf_title_instance = jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_medium_post_title]:not(.acf-hidden)');
            let acf_title = acf_title_instance.find(".acf-input input").val();

            /* WYSIWYG Content */
            let acf_wysiwyg_instance = jQuery(this).find('.acf-field.acf-field-wysiwyg:not(.acf-hidden)');
            let acf_editor_id = acf_wysiwyg_instance.find('.wp-editor-area').attr('id');
            let acf_iframe = jQuery('#' + acf_editor_id + '_ifr');
            let acf_editorContent = jQuery('#tinymce[data-id="' + acf_editor_id + '"]', acf_iframe.contents()).html();

            /* Medium Post Url */
            let acf_medium = jQuery(this).find('.acf-field.acf-field-url[data-name=oet_sidebar_medium_post_url]:not(.acf-hidden)');
            let acf_medium_url = acf_medium.find(".acf-input input").val();

            /* Alignment */
            let acf_post = jQuery(this).find('.acf-field.acf-field-select[data-name=oet_sidebar_medium_post_alignment]:not(.acf-hidden)');
            let acf_post_alignment = acf_post.find(".acf-input select").val();

            /* Background Image */
            let acf_image = jQuery(this).find('.acf-field.acf-field-image[data-name=oet_sidebar_medium_post_background_image]:not(.acf-hidden)');
            let acf_image_id = acf_image.find('.acf-input input').val();
            let acf_image_url = acf_image.find('.acf-input .show-if-value.image-wrap img').attr('src');

            /* Background Color */
            let acf_background = jQuery(this).find('.acf-field.acf-field-color-picker[data-name=oet_sidebar_medium_post_background_color]:not(.acf-hidden)');
            let acf_background_color = acf_background.find('.acf-input input').val();
            
            acf_data[i] = { "title" : acf_title, "content": acf_editorContent, "medium_url": acf_medium_url, "alignment": acf_post_alignment, "image_id": acf_image_id, "image_url": acf_image_url, "bg_color": acf_background_color };
            i++;
          });
          break;
        case "related":
          /* Alignment */
            let acf_display = jQuery(this).find('.acf-field.acf-field-number[data-name=oet_sidebar_related_content_display_count]:not(.acf-hidden)');
            let acf_display_count = acf_display.find(".acf-input input").val();
            acf_data[i] = { "count" : acf_display_count };
          break;
        case "story":
          acf_repeater.each(function(index,val){
            /* Title */
            let acf_title_instance = jQuery(this).find('.acf-field.acf-field-text[data-name=oet_sidebar_story_title]:not(.acf-hidden)');
            let acf_title = acf_title_instance.find(".acf-input input").val();

            /* WYSIWYG Content */
            let acf_wysiwyg_instance = jQuery(this).find('.acf-field.acf-field-wysiwyg[data-name=oet_sidebar_story_short_description]:not(.acf-hidden)');
            let acf_editor_id = acf_wysiwyg_instance.find('.wp-editor-area').attr('id');
            let acf_iframe = jQuery('#' + acf_editor_id + '_ifr');
            let acf_editorContent = jQuery('#tinymce[data-id="' + acf_editor_id + '"]', acf_iframe.contents()).html();

            /* Story */
            let acf_story = jQuery(this).find('.acf-field.acf-field-post-object[data-name=oet_sidebar_story_content_story]:not(.acf-hidden)');
            let acf_story_id = acf_story.find(".acf-input select").val();
            
            acf_data[i] = { "title" : acf_title, "content": acf_editorContent, "story_id": acf_story_id };
            i++;
          });
          break;
      }
      
      jQuery.post(oet_ajax_object.ajaxurl,
      {
          action:'oet_display_sidebar_section_callback',
          id: page_id,
          type: data['type'],
          title: data['title'],
          icon: data['icon'], 
          data: acf_data
      }).done(function (response) {
          modalBody.append(loader);
          loader.hide();
          target.html(response);
      });
    });
    jQuery(document).on('click','#oet-dynamic-sidebar-preview button', function(e){
      e.preventDefault();
      jQuery(this).closest('#oet-dynamic-sidebar-preview').removeClass('in');
      target.html(loader);
      loader.show();
    });
  }
  //Notice Dismiss
  jQuery(document).on('click','.oese-permalink-validation-notice-dismiss',function(e){
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    jQuery('.oese-prohibitedpermalinktext.notice').hide(100,function(){
      jQuery('.oese-prohibitedpermalinktext.notice').remove();
    });    
  })
  
  //Override fix for metabox expand/collapse
  jQuery(document).on('click','button.handlediv',function(e){
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    var expand = jQuery(this).attr('aria-expanded');
    var postbox = jQuery(this).closest('.postbox');
    var closed = postbox.hasClass('closed');
    
    // manual condition instead of toggle as the latter doesn't work on test server
    if (expand===true)
      postbox.find('.inside').hide();
    else if (expand===false)
      postbox.find('.inside').show();
    jQuery(this).attr('aria-expanded',(expand===true)?'false':'true');
    jQuery(this).closest('.postbox').toggleClass('closed');
  })
})

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
