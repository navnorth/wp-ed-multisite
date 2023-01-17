jQuery.noConflict();
jQuery( document ).ready(function() {
  
  jQuery(document).on('click','.wp-nn-parentpage-select',function(e){
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    var selone = jQuery('input[name="wp-nn-parentpage-rad"]:checked');
    var vl = selone.val();
    var parentname = selone.attr('title');
    var parentid = selone.val();
    jQuery('input[name="wp-nn-parentpage-prev-selected"]').val(vl);
    jQuery('#parent_id').val(parentid);
    jQuery('#wp-nn-parentpage-display').val(parentname);
    jQuery('.wp-nn-parentpage-overlay').css('visibility', 'hidden').removeClass('fadeIn').addClass('fadeOut');
  });
  
  jQuery(document).on('click','.wp-nn-parentpage-select-guten',function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		
    var selone = jQuery('input[name="wp-nn-parentpage-rad"]:checked');
		var vl = selone.val();
		var parentname = selone.attr('title');
		var parentid = selone.val();
    wp.data.dispatch( 'core/editor' ).editPost({parent:parseInt(parentid)});
		jQuery('input[name="wp-nn-parentpage-prev-selected"]').val(vl);
    jQuery('#wp-nn-parentpage-display').attr('value',parentname);
		jQuery('#wp-nn-parentpage-display').val(parentname);
		jQuery('.wp-nn-parentpage-overlay').css('visibility', 'hidden').removeClass('fadeIn').addClass('fadeOut');
    
	});

	jQuery(document).on('click','.wp-nn-parentpage-display-change',function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		jQuery('.wp-nn-tag-p').removeClass('checked');
		var prv = jQuery('input[name="wp-nn-parentpage-prev-selected"]').val();
		var rad = jQuery('input:radio[name="wp-nn-parentpage-rad"][value='+prv+']');
		rad.attr('checked', true);
		rad.parent().addClass('checked');
		jQuery('.wp-nn-parentpage-overlay').removeClass('fadeOut').addClass('fadeIn').css('display', 'block').css('visibility', 'visible');
		jQuery('input[name="wp-nn-parentpage-criteria"]').val('');
    setTimeout(function(){
      jQuery('input[name="wp-nn-parentpage-criteria"]').focus();
    }, 500);
		jQuery('#wp-nn-parentpage-dynahide').remove();
	});

	jQuery(document).on('change','input[name="wp-nn-parentpage-rad"]', function(){
		jQuery('.wp-nn-tag-p').removeClass('checked');
		jQuery(this).parent().addClass('checked');
	});

	jQuery(document).on('click','.wp-nn-parentpage-search-close', function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		jQuery('.wp-nn-parentpage-overlay').removeClass('fadeIn').addClass('fadeOut');
		setTimeout(function(){ jQuery('.wp-nn-parentpage-overlay').css('display', 'none').css('visibility', 'hidden') }, 800);
	});

	jQuery(document).on('input','input[name="wp-nn-parentpage-criteria"]', function(e) {
		var searchTerm = jQuery.trim(this.value).toLowerCase();
		jQuery('#wp-nn-parentpage-dynahide').remove();
		if(searchTerm > ''){
		  jQuery('#wp-nn-parentpage-dynahide').remove();
		  css = '.wp-nn-parentpage-search-result .wp-nn-tag-p:not([data-search-term*="'+searchTerm+'"]){display:none;}'
		  style = jQuery('<style type="text/css" id="wp-nn-parentpage-dynahide">').text(css)
		  jQuery('head').append(style);
		}
	});
  
});

//LOAD HTML
let wp_nn_loop_interval;
function load_parent_modal_html(){
  if (jQuery('.components-base-control.editor-page-attributes__order').length > 0 && jQuery('.wp-nn-parentpage-search-result').length > 0) {
    let cid = jQuery('.wp-nn-parentpage-display-wrapper').attr('cid');
    //var vlu = wp.data.select( 'core/editor' ).getEditedPostAttribute('parent');
    //var vlu = jQuery('.wp-nn-parentpage-rad:checked').attr('value');
    var vlu = wp.data.select( 'core/editor' ).getEditedPostAttribute('parent');
    clearInterval(wp_nn_loop_interval);
    //wp.apiFetch({ url: '/wp-json/wpnnmodalparent/v2/getparentbyid?pid='+vlu}).then(data =>{     
      targetElemID = wp.data.select( 'core/editor' ).getEditedPostAttribute('parent');
      //var ttl = jQuery('.wp-nn-parentpage-rad:checked').attr('title');
      var ttl = jQuery('.wp-nn-parentpage-search-result > ul li label.wp-nn-tag-p input[value="'+vlu+'"]').attr('title');
      jQuery('.wp-nn-parentpage-search-result > ul li label.wp-nn-tag-p input[value="'+vlu+'"]').prop('checked', true);
      ttl = (ttl === undefined || vlu == 0)? '(no parent)': ttl;
      vlu = (vlu === undefined || vlu == 0)? 0: vlu;
      htm = '';
            htm += '<div id="wp-nn-parentpage-display-wrapper" class="wp-nn-parentpage-display-wrapper" cid="'+wp.data.select( 'core/editor' ).getCurrentPostId()+'">';
              htm += '<label class="components-base-control__label" for="wp-nn-parentpage-display-wrapper">Parent:</label>';
              htm += '<div class="wp-nn-parentpage-display-block">';
                htm += '<input name="wp-nn-parentpage-display" type="text" id="wp-nn-parentpage-display" value="'+ttl+'" readonly="readonly">';
                htm += '<input type="button" class="button  wp-nn-parentpage-display-change" value="Change">';
              htm += '</div>';
            htm += '</div>';;
      jQuery('#wp-nn-parentpage-display-wrapper').remove();
      jQuery(htm).insertBefore(jQuery(".components-base-control.editor-page-attributes__order").closest('.components-panel__row'));
    //})
  }
}

jQuery(document).on('click','button[data-label="Page"].edit-post-sidebar__panel-tab',function(e){
  if(!jQuery('.wp-nn-parentpage-display-wrapper').length){
    wp_nn_loop_interval = setInterval(load_parent_modal_html, 100);
  }
});

//AFTER DOM IS LOADED
let targetElemID = '';
var mutate_parent_value_element;
var mutate_parent_selector_element;
jQuery(window).bind("load", function() { 
  if(jQuery('.components-drop-zone__provider').length > 0){
    // Observer Open and Closing of the Workflow Column
    mutate_parent_selector_element = document.querySelector('.edit-post-layout');  
    //load_parent_modal_html();
  }
  
  jQuery(document).on('click','.components-panel__body',function(){
    setTimeout(function(){
      if(jQuery('.components-base-control.editor-page-attributes__order').length > 0){
        load_parent_modal_html();
      }else{
        jQuery('#wp-nn-parentpage-display-wrapper').remove();
      }
    }, 100);
  })
  
  jQuery(document).on('click','.edit-post-header__settings .components-icon-button',function(){
    setTimeout(function(){
      if(jQuery('.components-base-control.editor-page-attributes__order').length > 0){
        load_parent_modal_html();
      }
    }, 100);
  })

  jQuery(document).on('focus','.editor-post-title__input',function(){
    setTimeout(function(){
      if(jQuery('.components-base-control.editor-page-attributes__order').length > 0){
        load_parent_modal_html();
      }
    }, 100);
  })
  
  
  setTimeout(function(){
    /* create gutenberg settings tab switch observer */
    function create_parentmodal_setting_switch_observer_func(){
      var oese_parentmodal_observer_target = document.querySelectorAll(".edit-post-sidebar__panel-tab");
      for (var i = 0; i < oese_parentmodal_observer_target.length; i++) {
        create_parentmodal_observer(oese_parentmodal_observer_target[i]);
      }

      function create_parentmodal_observer(elementToObserve){
        var create_parentmodal_observer = new MutationObserver(function(mutations) {
          mutations.forEach(function(mutation){
            var oese_active_panel = mutation.target.attributes.getNamedItem('data-label').value;
            if(oese_active_panel == 'Page' && mutation.target.classList.contains('is-active')){ //page is active
              setTimeout(function(){ load_parent_modal_html() }, 500);
            } //else block is active
          })
        });
        create_parentmodal_observer.observe(elementToObserve, {attributes: true, childList: false, characterData: false, subtree: false });
      }
    }
    create_parentmodal_setting_switch_observer_func();
    
    /* create gutenberg sidebar close/open observer */
    var oese_parentmodal_sidebar_toggle_observer_target = document.querySelectorAll(".interface-interface-skeleton__sidebar");
    for (var i = 0; i < oese_parentmodal_sidebar_toggle_observer_target.length; i++) {
      create_parentmodal_sidebar_toggle_observer_func(oese_parentmodal_sidebar_toggle_observer_target[i]);
    }
    function create_parentmodal_sidebar_toggle_observer_func(elementToObserve){
      var create_preview_sidebar_toggle_observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation){
          mutation.addedNodes.forEach(function(added_node) {
            if(added_node.classList.contains('edit-post-sidebar')) { //sidebar added
              setTimeout(function(){ 
                load_parent_modal_html();
                create_parentmodal_setting_switch_observer_func();
              }, 500);
            }
          });
  
        })
      });
      create_preview_sidebar_toggle_observer.observe(elementToObserve, {attributes: true, childList: true, characterData: false, subtree: false });
    }
  }, 1000);
  
});


