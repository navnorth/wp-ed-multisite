jQuery(function($){
	$('#enablecrazyegg').on('change', function(e){
		if ($(this).is(":checked"))
			$(this).next('input[type=text]').attr('disabled',false);
		else{
			$(this).next('input[type=text]').attr('disabled',true);
			$(this).next('input[type=text]').val('');
		}
	});
	$(document).on("submit", '#oet_theme_settings_form', function(e){
		let crazyeggenabled = $(this).find('input#enablecrazyegg').is(":checked");
		let crazyeggurl = $(this).find('input#crazyeggaddress').val();
		
		if ((crazyeggenabled==true && crazyeggurl!=='') || crazyeggenabled==false){
			$('.oet-settings-error').hide();
			$(this).submit();
		} else if (crazyeggenabled && crazyeggurl==''){
			e.preventDefault();
			$('.oet-settings-error').show();
		}
	});
});