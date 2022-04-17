jQuery('.oese-blk-accordion-content').each(function(i, obj) {
    jQuery(this).attr('aria-label',"accordion content: "+jQuery(this).text().trim());
});

jQuery(document).ready(function(){
  jQuery(document).on('keydown','.oet-blk-accordion-button',function(e){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == 13){
      var livetext = (jQuery(this).hasClass('collapsed'))? 'Expanded': 'Collapsed';
      jQuery('#a11y-speak-polite').text(livetext);
    }
  });
});