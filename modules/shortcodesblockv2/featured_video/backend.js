jQuery(window).bind("load", function() {
    setTimeout(function(){
      if(window.oercurrBlocksJson){
        oese_featured_video_toolbar_observer_func.observe(document.querySelector(".edit-post-visual-editor"), {childList: true, subtree: true });
      }else{
        oese_featured_video_toolbar_observer_func_legacy.observe(document.querySelector(".edit-post-visual-editor .popover-slot"), {childList: true, subtree: true });
      }
    }, 500);

});

var oese_featured_video_toolbar_observer_func_legacy = new MutationObserver(function(mutations) { oese_gutenberg_toolbar_enpoint_script_legacy();});
function oese_gutenberg_toolbar_enpoint_script_legacy(){
  
  var oese_target = jQuery('.block-editor__container');
  if(jQuery('.block-editor__container .edit-post-visual-editor .popover-slot').html().length > 0){
    let oese_description_selected = jQuery('.oese-featured-video-block-description-ytr85g9wer').hasClass('is-selected');
    oese_featured_video_clear_toolbar_classes(oese_target);
    if(oese_description_selected){
        oese_target.addClass('oese-featured-video-block-description-toolbar-hide');
    }
  }
  jQuery('.oese_featured_video_block_wrapper .block-list-appender').hide();
}

var oese_featured_video_toolbar_observer_func = new MutationObserver(function(mutations) { oese_gutenberg_toolbar_enpoint_script();});
function oese_gutenberg_toolbar_enpoint_script(){
  
  var oese_target = jQuery('.block-editor__container');
  if(jQuery('.block-editor__container .edit-post-visual-editor .components-popover__content').length){
    let oese_description_selected = jQuery('.oese-featured-video-block-description-ytr85g9wer').hasClass('is-selected');
    oese_featured_video_clear_toolbar_classes(oese_target);
    if(oese_description_selected){
        oese_target.addClass('oese-featured-video-block-description-toolbar-hide');
    }
  }
  jQuery('.oese_featured_video_block_wrapper .block-list-appender').hide();
}

function oese_featured_video_clear_toolbar_classes(obj){
  obj.removeClass('oese-featured-video-block-description-toolbar-hide');
}
