jQuery('.oet-blk-accordion-content').each(function(i, obj) {
    jQuery(this).attr('aria-label',"accordion content: "+jQuery(this).text().trim());
});

jQuery(document).ready(function(){
  jQuery(document).on('keydown','.oet-blk-accordion-button',function(e){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == 13){
      var livetext = (jQuery(this).hasClass('collapsed'))? 'Expanded': 'Collapsed';
      var expanded = (jQuery(this).hasClass('collapsed'))? false: true;
      jQuery(this).attr('aria-expanded', expanded);
      let contentId = jQuery(this).attr('href');
      if (!expanded){
        jQuery(contentId).removeAttr('tabindex');
      } else {
        jQuery(contentId).attr('tabindex','0');
      }
      jQuery('#a11y-speak-polite').text(livetext);
    }
  });
  jQuery(document).on('click','.oet-blk-accordion-button',function(e){
    var expanded = (jQuery(this).hasClass('collapsed'))? false: true;
    let contentId = jQuery(this).attr('href');
    if (!expanded){
      jQuery(contentId).removeAttr('tabindex');
    } else {
      jQuery(contentId).attr('tabindex','0');
    }
    jQuery(this).attr('aria-expanded', expanded);
  });
});