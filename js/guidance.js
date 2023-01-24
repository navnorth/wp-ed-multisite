jQuery(document).ready(function(){
	setTimeout(function(){
		if(jQuery('#table_1').length){
			jQuery('#table_1').wrap('<div class="wdtResponsiveWrapper"></div>');
		}
	},100);
});