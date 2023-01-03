jQuery(function($){
	setTimeout(function(){
		let filter = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter');
		let label = filter.find('label').text();
		let tabLabel = $('.page-template-nalrc-template #table_1_wrapper #table_1_filter').closest('.tab-pane').attr('id');
		let tabLabelText = tapLabel.text();
		$('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend(filter);
		label.text('Search ' + tapLabelText);
	},1000);
});