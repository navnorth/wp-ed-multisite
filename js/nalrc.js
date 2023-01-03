jQuery(function($){
	setTimeout(function(){
		let filter = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter');
		let label = filter.find('label').text();
		let input = filter.find('input');
		let tabLabel = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter').closest('.tab-pane').attr('aria-labelledby');
		let tabLabelText = $('#' + tabLabel).text();
		tabLabelText = 'Search' + tabLabelText;
		$('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend(filter);
		$('.page-template-nalrc-template .wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter > label').html("");
		$('.page-template-nalrc-template .wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter > label').append(input);
		$('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend('<div class="wpDataTableFilterSection" id="table_search_filter_label"><label>' + tabLabelText + '</label></div>');
	},1000);
});