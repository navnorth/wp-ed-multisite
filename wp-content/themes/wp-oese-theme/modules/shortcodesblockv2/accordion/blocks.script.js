jQuery('.oese-blk-accordion-content').each(function(i, obj) {
    jQuery(this).attr('aria-label',"accordion content: "+jQuery(this).text().trim());
});