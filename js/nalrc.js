var map_cfg = 'usacustomhtml5map_map_cfg_5';
var map_id = 5;
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

	// Override Certifications Map Click
	var nalrc_html5map_onclick = function(ev, sid, map) { 
		var cfg = this[window.map_cfg]; 
		var link = map.fetchStateAttr(sid, 'link'); 
		var is_group = map.fetchStateAttr(sid, 'group'); 
		var popup_id = map.fetchStateAttr(sid, 'popup-id'); 
		var is_group_info = false; 
		if (typeof cfg.map_data[sid] !== 'undefined') 
			$('#usacustom-html5-map-selector_0').val(sid); 
		else 
			$('#usacustom-html5-map-selector_0').val(''); 
		if (is_group==undefined) { 
			if (sid.substr(0,1)=='p') { 
				popup_id = map.fetchPointAttr(sid, 'popup_id'); 
				link = map.fetchPointAttr(sid, 'link'); } 
			} else if (typeof cfg.groups[is_group]['ignore_link'] == 'undefined' || ! cfg.groups[is_group].ignore_link) { 
				link = cfg.groups[is_group].link; 
				popup_id = cfg.groups[is_group]['popup_id']; 
				is_group_info = true; 
			} 
			if (link=='#popup') { 
				if (typeof SG_POPUP_DATA == "object") { 
					if (popup_id in SG_POPUP_DATA) { 
						SGPopup.prototype.showPopup(popup_id,false); 
					} else { 
						jQuery.ajax({ 
							type: 'POST', 
							url: nalrc.home_url + '/index.php' + '?map_id=' + window.map_id + '&usacustomhtml5map_get_popup', 
							data: {popup_id:popup_id}, 
						}).done(function(data) { 
							$('body').append(data); 
							SGPopup.prototype.showPopup(popup_id,false); 
						}); 
					} 
				} else if (typeof SGPBPopup == "function") { 
					var popup = SGPBPopup.createPopupObjById(popup_id); 
					popup.prepareOpen(); 
					popup.open(); 
				} 
				return false; 
			} 
			if (link == '#info') { 
				var id = is_group_info ? is_group : (sid.substr(0,1)=='p' ? sid : map.fetchStateAttr(sid, 'id')); 
				$.ajax({ 
					type: 'POST', 
					url: (is_group_info ? nalrc.home_url + '/index.php' + '?map_id=' + window.map_id + '&usacustomhtml5map_get_group_info=' : 'https://oese.wp.nnth.dev/' + 'index.php' + '?map_id=5' + '&usacustomhtml5map_get_state_info=') + id, 
					success: function(data, textStatus, jqXHR){ 
						$('#usacustom-html5-map-state-info_0').html(data); 
						$('#usacustom-html5-map-state-info_0').find('.modal-map-details-popup').modal('show');
					}, 
					dataType: 'text' 
				}); 
				return false; 
			} if (ev===null && link!='') { 
				if (!$('.html5dummilink').length) { 
					$('body').append('<a href="#" class="html5dummilink" style="display:none"></a>'); 
				} 
				$('.html5dummilink').attr('href',link).attr('target',(map.fetchStateAttr(sid, 'isNewWindow') ? '_blank' : '_self'))[0].click(); 
			} 
		}; 
	setTimeout(function(){
		if ($('.usacustomHtml5MapContainer').length){
			var mapVar = $('.usacustomHtml5MapContainer').attr('data-map-variable');
			this[mapVar].on('click', nalrc_html5map_onclick);
		}
	},1000);

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

	$('.oese-tabs-block #oeseTabs').on('keydown','.nav-link', function(e){
        $(this).trigger('click');
     });
});