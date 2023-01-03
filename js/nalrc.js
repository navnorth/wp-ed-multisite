jQuery(function($){
	setTimeout(function(){
		let filter = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter');
		let label = filter.find('label').text();
		let input = filter.find('input').html();
		let tabLabel = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter').closest('.tab-pane').attr('aria-labelledby');
		let tabLabelText = $('#' + tabLabel).text();
		tapLabelText = 'Search' + tabLabelText;
		$('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend(filter);
		$('.page-template-nalrc-template .wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter > label').text(tapLabelText);
		$('.page-template-nalrc-template .wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter > label').append(input);
		$('.page-template-nalrc-template .wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter > input').attr('placeholder','Search by keyword or phrase');
	},1000);
});