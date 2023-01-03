jQuery( window ).load(function() {
  setTimeout(function(){
    if(window.oercurrBlocksJson){
      oet_featured_item_toolbar_observer_func.observe(document.querySelector(".edit-post-visual-editor"), {childList: true, subtree: true });
    }else{
      oet_featured_item_toolbar_observer_func_legacy.observe(document.querySelector(".edit-post-visual-editor .popover-slot"), {childList: true, subtree: true });
    }
    //oet_featured_item_inspector_observer_func.observe(document.querySelector(".components-panel"), {childList: true, subtree: true });
  }, 500);
  var oet_featured_item_toolbar_observer_func_legacy = new MutationObserver(function(mutations) { oet_gutenberg_toolbar_enpoint_script_legacy();});
  function oet_gutenberg_toolbar_enpoint_script_legacy(){
    var oet_target = jQuery('.block-editor__container');
    if(jQuery('.block-editor__container .edit-post-visual-editor .popover-slot').html().length > 0){
      let oet_title_selected = jQuery('.oet-featured-item-title-ytr85g9wer').hasClass('is-selected');
      let oet_date_selected = jQuery('.oet-featured-item-date-ytr85g9wer').hasClass('is-selected');
      let oet_content_selected = jQuery('.oet-featured-item-content-ytr85g9wer').hasClass('is-selected');
      let oet_button_selected = jQuery('.oet-featured-item-button-ytr85g9wer').hasClass('is-selected');
      oet_featured_item_clear_toolbar_classes(oet_target);
      if(oet_title_selected || oet_date_selected){
          oet_target.addClass('oet-featured-item-title-toolbar-hide');
      }else if(oet_content_selected){
          oet_target.addClass('oet-featured-item-content-toolbar-hide');
      }else if(oet_button_selected){
          oet_target.addClass('oet-featured-item-button-toolbar-hide');
      }
    }
    jQuery('.oet_featured_item_block_wrapper .block-list-appender').hide();
  }
  
  var oet_featured_item_toolbar_observer_func = new MutationObserver(function(mutations) { oet_gutenberg_toolbar_enpoint_script();});
  function oet_gutenberg_toolbar_enpoint_script(){
    var oet_target = jQuery('.block-editor__container');
    if(jQuery('.block-editor__container .edit-post-visual-editor .components-popover__content').length){
      let oet_title_selected = jQuery('.oet-featured-item-title-ytr85g9wer').hasClass('is-selected');
      let oet_date_selected = jQuery('.oet-featured-item-date-ytr85g9wer').hasClass('is-selected');
      let oet_content_selected = jQuery('.oet-featured-item-content-ytr85g9wer').hasClass('is-selected');
      let oet_button_selected = jQuery('.oet-featured-item-button-ytr85g9wer').hasClass('is-selected');
      oet_featured_item_clear_toolbar_classes(oet_target);
      if(oet_title_selected || oet_date_selected){
          oet_target.addClass('oet-featured-item-title-toolbar-hide');
      }else if(oet_content_selected){
          oet_target.addClass('oet-featured-item-content-toolbar-hide');
      }else if(oet_button_selected){
          oet_target.addClass('oet-featured-item-button-toolbar-hide');
      }
    }
    jQuery('.oet_featured_item_block_wrapper .block-list-appender').hide();
  }
  
  function oet_featured_item_clear_toolbar_classes(obj){
    obj.removeClass('oet-featured-item-title-toolbar-hide');
    obj.removeClass('oet-featured-item-content-toolbar-hide');
    obj.removeClass('oet-featured-item-button-toolbar-hide');
  }
  
});

function oet_gutenberg_toolbar_observer_clear_classes(tgt){
  tgt.removeClass('oet-featured-item-title-toolbar-hide oet-featured-item-button-toolbar-hide');
}


