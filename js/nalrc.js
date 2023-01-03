jQuery(function($){
	setTimeout(function(){
		let filter = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter');
		let label = filter.find('label').text();
		let tabLabel = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter').closest('.tab-pane').attr('aria-labelledby');
		let tabLabelText = $('#' + tabLabel).text();
		tapLabelText = 'Search ' + tabLabelText;
		console.log(tapLabelText);
		$('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend(filter);
		$('.page-template-nalrc-template #table_1_wrapper #table_1_filter > label').text(tapLabelText);
		$('.page-template-nalrc-template #table_1_wrapper #table_1_filter > input').attr('placeholder','Search by keyword or phrase');
	},1000);
});