jQuery(function($){
	// Learn Languages Filter Section
	setTimeout(function(){
		$('.page-template-nalrc-template .oese-tabs-block .tab-content .tab-pane').each(function(){
			let filter = $(this).find('.wpnn_wpdt_action_wrapper .dataTables_filter').clone();
			let label = filter.find('label').text();
			let input = filter.find('input');
			let tabLabel = $(this).attr('aria-labelledby');
			let tabLabelText = $('#' + tabLabel).text();
			tabLabelText = 'Search' + tabLabelText;
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend(filter);
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter').html("");
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter').append(input);
			$(this).find('.wpnn_wpdt_action_wrapper .dataTables_filter').hide();
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter input').attr('placeholder', 'Search by keywords or phrase');
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend('<div class="wpDataTableFilterSectionLabel" id="table_search_filter_label"><label>' + tabLabelText + '</label></div>');

			// Trigger search on pressing Enter key
			let parent = $(this);
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter input').on("input", function(e){
				let value = $(this).val();
				parent.find('.wpDataTables .wpnn_wpdt_action_wrapper .dataTables_filter input').val(value);
				parent.find('.wpDataTables .wpnn_wpdt_action_wrapper .dataTables_filter input').trigger("input");
			});

			let title = $(this).find('.wpDataTablesWrapper table.wpDataTable thead th.column-title').text();
			$(this).find('.wpDataTablesWrapper table.wpDataTable thead th.column-title').html('');
			$(this).find('.wpDataTablesWrapper table.wpDataTable thead th.column-title').html('<span>' + title + '</span>');

			$(this).find('.column-degree-type .filter_select .wdt-select-filter').on('changed.bs.select', function(e) { 
				let defaultText = 'Please select';
				if ($(this).find('.dropdown-menu.inner .dropdown-header').next('.selected').find('a span.text').text().length==0){
					$(this).find('.dropdown-menu.inner .dropdown-header').next('.selected').find('a span.text').text(defaultText);
					$(this).find('.dropdown-menu.inner .dropdown-header').next('.selected').find('a span.text').addClass('emptyValue').css('opacity','0.75');
				}
				if ($(this).find('.dropdown-menu.inner .divider').next().find('a span.text').text().length==0){
					$(this).find('.dropdown-menu.inner .divider').next().find('a span.text').text(defaultText);
					$(this).find('.dropdown-menu.inner .divider').next().find('a span.text').addClass('emptyValue').css('opacity','0.75');
				}
			} );

			$(this).find('.column-category .filter_select .wdt-select-filter').on('changed.bs.select', function(e) { 
				let defaultText = 'Please select';
				if ($(this).find('.dropdown-menu.inner .dropdown-header').next('.selected').find('a span.text').text().length==0){
					$(this).find('.dropdown-menu.inner .dropdown-header').next('.selected').find('a span.text').text(defaultText);
					$(this).find('.dropdown-menu.inner .dropdown-header').next('.selected').find('a span.text').addClass('emptyValue').css('opacity','0.75');
				}
				if ($(this).find('.dropdown-menu.inner .divider').next().find('a span.text').text().length==0){
					$(this).find('.dropdown-menu.inner .divider').next().find('a span.text').text(defaultText);
					$(this).find('.dropdown-menu.inner .divider').next().find('a span.text').addClass('emptyValue').css('opacity','0.75');
				}
			} );
		});
	},1000);

	setTimeout(function(){
		$('ul.certification-map-legend').appendTo('.fm-map-container');
		$('.usacustomHtml5MapContainer svg').attr('tabindex','-1');
		$('.usacustomHtml5MapContainer svg').attr('focusable','true');
		$('.usacustomHtml5MapContainer svg path').each(function(){
			if ($(this).attr('fill')=='#3693bb')
				$(this).attr('tabindex','0');
		});
	},1000);

	// Certifications Map Click
	$('.usacustomHtml5MapContainer').on('click','svg path',function(e){
		console.log(e);
		setTimeout(function(){
			$('.usacustomHtml5MapStateInfo').find('.modal-map-details-popup').modal('show');
		},1000);
	});

	// Certifications Map Enter/Space bar key press
	$('.usacustomHtml5MapContainer').on('keydown','svg path',function(e){
		var code = e.keyCode || e.which;
		if (code==13 || code==32){
			$(this).trigger('click');
			setTimeout(function(){
				$('.usacustomHtml5MapStateInfo').find('.modal-map-details-popup').modal('show');
			},1000);
		}
	});

	$(document).on('keydown',function(e){
		var code = e.keyCode || e.which;
		if (code==27){
			if ($('.modal-map-details-popup').is(':visible'))
				$('.modal-map-details-popup').modal('hide');
		}
	});
});