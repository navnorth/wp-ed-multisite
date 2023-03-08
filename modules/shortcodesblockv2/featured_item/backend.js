jQuery( window ).load(function() {
  setTimeout(function(){
    if(window.oercurrBlocksJson){
      oese_featured_item_toolbar_observer_func.observe(document.querySelector(".edit-post-visual-editor"), {childList: true, subtree: true });
    }else{
      oese_featured_item_toolbar_observer_func_legacy.observe(document.querySelector(".edit-post-visual-editor .popover-slot"), {childList: true, subtree: true });
    }
    //oese_featured_item_inspector_observer_func.observe(document.querySelector(".components-panel"), {childList: true, subtree: true });
  }, 500);
  var oese_featured_item_toolbar_observer_func_legacy = new MutationObserver(function(mutations) { oese_gutenberg_toolbar_enpoint_script_legacy();});
  function oese_gutenberg_toolbar_enpoint_script_legacy(){
    var oese_target = jQuery('.block-editor__container');
    if(jQuery('.block-editor__container .edit-post-visual-editor .popover-slot').html().length > 0){
      let oese_title_selected = jQuery('.oese-featured-item-title-ytr85g9wer').hasClass('is-selected');
      let oese_date_selected = jQuery('.oese-featured-item-date-ytr85g9wer').hasClass('is-selected');
      let oese_content_selected = jQuery('.oese-featured-item-content-ytr85g9wer').hasClass('is-selected');
      let oese_button_selected = jQuery('.oese-featured-item-button-ytr85g9wer').hasClass('is-selected');
      oese_featured_item_clear_toolbar_classes(oese_target);
      if(oese_title_selected || oese_date_selected){
          oese_target.addClass('oese-featured-item-title-toolbar-hide');
      }else if(oese_content_selected){
          oese_target.addClass('oese-featured-item-content-toolbar-hide');
      }else if(oese_button_selected){
          oese_target.addClass('oese-featured-item-button-toolbar-hide');
      }
    }
    jQuery('.oese_featured_item_block_wrapper .block-list-appender').hide();
  }
  
  var oese_featured_item_toolbar_observer_func = new MutationObserver(function(mutations) { oese_gutenberg_toolbar_enpoint_script();});
  function oese_gutenberg_toolbar_enpoint_script(){
    var oese_target = jQuery('.block-editor__container');
    if(jQuery('.block-editor__container .edit-post-visual-editor .components-popover__content').length){
      let oese_title_selected = jQuery('.oese-featured-item-title-ytr85g9wer').hasClass('is-selected');
      let oese_date_selected = jQuery('.oese-featured-item-date-ytr85g9wer').hasClass('is-selected');
      let oese_content_selected = jQuery('.oese-featured-item-content-ytr85g9wer').hasClass('is-selected');
      let oese_button_selected = jQuery('.oese-featured-item-button-ytr85g9wer').hasClass('is-selected');
      oese_featured_item_clear_toolbar_classes(oese_target);
      if(oese_title_selected || oese_date_selected){
          oese_target.addClass('oese-featured-item-title-toolbar-hide');
      }else if(oese_content_selected){
          oese_target.addClass('oese-featured-item-content-toolbar-hide');
      }else if(oese_button_selected){
          oese_target.addClass('oese-featured-item-button-toolbar-hide');
      }
    }
    jQuery('.oese_featured_item_block_wrapper .block-list-appender').hide();
  }
  
  function oese_featured_item_clear_toolbar_classes(obj){
    obj.removeClass('oese-featured-item-title-toolbar-hide');
    obj.removeClass('oese-featured-item-content-toolbar-hide');
    obj.removeClass('oese-featured-item-button-toolbar-hide');
  }
  
});

function oese_gutenberg_toolbar_observer_clear_classes(tgt){
  tgt.removeClass('oese-featured-item-title-toolbar-hide oese-featured-item-button-toolbar-hide');
}
