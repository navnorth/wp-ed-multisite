let wpnn_preview_publish_button;
let wpnn_preview_element_html;
function oesePreviewDraftCopyToClipboard(element) {
  var copyText = document.getElementById("oese-preview-url-input");
  copyText.select(); 
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/
  document.execCommand("copy");
  alert("Copied Preview URL: " + copyText.value);
}

/* **************** */
/* GUTENBERG STARTS */
/* **************** */

jQuery(window).bind("load", function() {  
  
  // POST STATUS CHANGE OBSERVER
  if(wpoesePreviewGlobal['oeseIsGutenbergActive'] == 'true'){ //Gutenberg Editor is in use
    
      /* render preview button/warning section */
      let previewintervalcntr = 0;
      let previewinterval = setInterval(function(){
        previewintervalcntr++;
        if(jQuery('.editor-post-trash').length){
          clearInterval(previewinterval);
          oese_preview_init();
        }else{
          if(previewintervalcntr > 1800){
            clearInterval(previewinterval);
          }
        }
      }, 100);
      
      
      function oese_preview_init(){
        var screen_type = (wp.data === undefined)?'none': wp.data.select('core/editor').getCurrentPostAttribute('type');
        if(screen_type == 'page' || screen_type == 'post'){
          let { subscribe } = wp.data;
          let oldPostStatus = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'status' );
          wpnnSetButton(oldPostStatus);
          const unssubscribe = subscribe( () => {
            const newPostStatus = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'status' );
            if ( oldPostStatus !== newPostStatus) {
                if(oldPostStatus == 'draft' &&  newPostStatus == 'publish'){
                }else if(oldPostStatus == 'pending' &&  newPostStatus == 'publish'){
                }else if(oldPostStatus == 'publish' &&  newPostStatus == 'draft'){
                  wpnnSetButton(newPostStatus);
                }
                oldPostStatus = newPostStatus;
            }
          });
          // Post Status Info Panel Drop/Undrop observer.
          var mutate_target_element = document.querySelector('.edit-post-layout');
          columnsettingobserver.observe(mutate_target_element, {childList: true, subtree: false});
        }
      
      
        oese_init_observers();
        
      
      } /*oese_preview_init()*/
      
      
      function oese_init_observers(){
        /* create gutenberg settings tab switch observer */
        function oese_preview_setting_switch_observer(){
          var oese_preview_observer_target = document.querySelectorAll(".edit-post-sidebar__panel-tab");
          for (var i = 0; i < oese_preview_observer_target.length; i++) {
            if(oese_preview_observer_target[i].classList.contains('is-active')){
              create_preview_observer(oese_preview_observer_target[i]);
            }
          }
          function create_preview_observer(elementToObserve){
            var create_preview_observer = new MutationObserver(function(mutations) {
              //mutations.forEach(function(mutation){
                mutation = mutations[0];
                var oese_active_panel = mutation.target.attributes.getNamedItem('data-label').value;
                //if((oese_active_panel == 'Page' || oese_active_panel == 'Post')){ //page/post is active
                  if(jQuery('.edit-post-post-status').hasClass('is-opened')){
                    if(!jQuery('.oese-preview-url-wrapper').length){
                      setTimeout(function(){ wpnnSetButton() }, 100);
                    }
                  }
                //}
              //})
            });
            create_preview_observer.observe(elementToObserve, {attributes: true, childList: false, characterData: false, subtree: false });
          }
        }
        oese_preview_setting_switch_observer();
        
        /* create gutenberg sidebar close/open observer */
        var oese_preview_sidebar_toggle_observer_target = document.querySelectorAll(".interface-interface-skeleton__sidebar");
        for (var i = 0; i < oese_preview_sidebar_toggle_observer_target.length; i++) {
          create_preview_sidebar_toggle_observer_func(oese_preview_sidebar_toggle_observer_target[i]);
        }
        function create_preview_sidebar_toggle_observer_func(elementToObserve){
          var create_preview_sidebar_toggle_observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation){
              mutation.addedNodes.forEach(function(added_node) {
          			if(added_node.classList.contains('edit-post-sidebar')) { //sidebar added
                  if(jQuery('.edit-post-post-status').hasClass('is-opened')){
                    setTimeout(function(){ 
                      wpnnSetButton();
                      oese_preview_setting_switch_observer();
                    }, 100);
                    
                  }else{
                    oese_preview_setting_switch_observer();
                  }
          			}
          		});
      
            })
          });
          create_preview_sidebar_toggle_observer.observe(elementToObserve, {attributes: true, childList: true, characterData: false, subtree: false });
        }
      }

  }
  
});


var columnsettingobserver = new MutationObserver(function(mutations) {
    if(jQuery('.edit-post-sidebar .components-panel .edit-post-post-status').length > 0){ 
      wpnnSetButton();
    }
});

// Status And Visibility Panel Drop/Undrop click
jQuery(document).on('click','.edit-post-post-status .components-panel__body-title .components-panel__body-toggle',function(){
  jQuery('.oese-preview-url-wrapper').remove();
  jQuery('.oese-preview-tmp-preloader').remove();
  if(!jQuery(this).closest('.edit-post-post-status').hasClass('is-opened')){
    wpnnSetButton();
  }
})

// Sidbar Document Tab click
jQuery(document).on('click','button[data-label="Document"].edit-post-sidebar__panel-tab',function(e){
  //wpnnSetButton();  
});

// Sidbar Page Tab click
jQuery(document).on('click','button[data-label="Page"].edit-post-sidebar__panel-tab',function(e){
  //wpnnSetButton();  
});

// Sidbar Post Tab click
jQuery(document).on('click','button[data-label="Post"].edit-post-sidebar__panel-tab',function(e){
  //wpnnSetButton();  
});

// Detect focus on title block
jQuery(document).on('focus','.editor-post-title__input',function(){
  setTimeout(function(){
    //wpnnSetButton(); 
  }, 100);
})

// Prevent accidental published
jQuery(document).on('click','.oese-preview-publish-button',function(e){
  e.preventDefault ? e.preventDefault() : e.returnValue = false;
  var targeturl = jQuery(this).attr('href');
  var oesePubConfirmAns = confirm('Publishing this preview will overwrite its original.\r\nIf you only want to save this preview, please use "Save Draft".\r\n\r\n Would you like to publish this preview?');
  if (oesePubConfirmAns == true) {
    window.location.href = targeturl;
  }
})

// Set Preview HTML/Button/URL Function
function wpnnSetButton(newstatus,callback){
  if (newstatus === undefined) {
      // newstatus was not passed
      //newstatus = '&new='+wp.data.select( 'core/editor' ).getEditedPostAttribute( 'status' );
      
      setTimeout(function(){
          jQuery('.edit-post-post-status').append(jQuery(wpnn_preview_element_html));
      },100);
      return;
      
  }else{
     newstatus = '&new='+newstatus;
  }
  
  setTimeout(function(){
    if(!jQuery('.oese-preview-tmp-preloader').length){
      jQuery('.edit-post-post-status').append('<div class="oese-preview-tmp-preloader"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>');
    }
  }, 100);
  
  if(wp.apiFetch !== undefined){
    let pid = jQuery('form.metabox-base-form #post_ID').attr('value');
    wp.apiFetch({ url: '/wp-json/wpnnpreview/v2/elementquery?pid='+pid+newstatus}).then(data =>{      
        wpnn_preview_element_html = data['html'];
        
        Object.defineProperty(window, 'wpnn_preview_theme_url', {
          value: data['themedir'],
          configurable: false,
          writable: false
        });
        
        Object.defineProperty(window, 'wpnn_preview_isparent', {
          value: data['isparent'],
          configurable: false,
          writable: false
        });
        
        if(wpnn_preview_isparent == 'false' && !jQuery('a.editor-post-publish-panel__toggle').length ){ //Preview Type of post only
          wp.data.dispatch( 'core/editor' ).lockPostSaving( 'requiredValueLock' );
          jQuery('.editor-post-publish-panel__toggle').hide();
          v_btn = '<a href="'+wpnn_preview_theme_url+"/modules/oesepreview/oesepreview_ajax.php?action=wpnnTransitionHandlerGuten&old=draft&new=publish&pid="+pid+'" aria-disabled="false" aria-expanded="false" class="components-button editor-post-publish-panel__toggle is-button is-primary oese-preview-publish-button">Publish…</a>';
          wpnn_preview_publish_button = v_btn;
          jQuery(wpnn_preview_publish_button).insertAfter(".editor-post-publish-panel__toggle");
        }else{
          wp.data.dispatch( 'core/editor' ).unlockPostSaving( 'requiredValueLock' );
        }
        
        jQuery('.oese-preview-url-wrapper.gutenberg').remove();
        //jQuery(wpnn_preview_element_html).insertAfter(".components-panel__body.edit-post-post-status .editor-post-trash");
        //jQuery(wpnn_preview_element_html).insertAfter(jQuery('.edit-post-post-schedule').next());
        setTimeout(function(){
            jQuery('.oese-preview-tmp-preloader').hide(500, function(){
            //jQuery('.oese-preview-tmp-preloader').remove();
            jQuery('.edit-post-post-status').append(jQuery(wpnn_preview_element_html));
          });
        },100);
        jQuery(".components-panel__body.edit-post-post-status .editor-post-trash").parent('.components-panel__row').addClass('wpnn-preview');
        typeof callback == 'function' && callback();      
    })
  }

}

