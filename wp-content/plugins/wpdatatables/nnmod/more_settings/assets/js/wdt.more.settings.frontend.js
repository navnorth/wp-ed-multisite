var iswdtloaded;
jQuery(document).ready(function(){
    iswdtloaded = setTimeout(function(){
      if(jQuery('table.wpDataTable').length){
        clearTimeout(iswdtloaded);
        jQuery('.wdtLoadingIndicator').hide(500);
      }
    },100);
});