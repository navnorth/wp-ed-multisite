var map_cfg = 'usacustomhtml5map_map_cfg_5';
var map_id = 5;
var selectedState;
jQuery(function($){
	// Learn Languages Filter Section
	setTimeout(function(){
		$('.page-template-nalrc-template .oese-tabs-block .tab-content .tab-pane').each(function(){
			let filter = $(this).find('.wpnn_wpdt_action_wrapper .dataTables_filter').clone();
			let label = filter.find('label').text();
			let input = filter.find('input');
			let tabLabel = $(this).attr('aria-labelledby');
			let tabLabelText = $('#' + tabLabel).text();
			//tabLabelText = 'Search' + tabLabelText;
			tabLabelText = 'Filter By:';
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend(filter);
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter').html("");
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter').append(input);
			$(this).find('.wpnn_wpdt_action_wrapper .dataTables_filter').hide();
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox .dataTables_filter input').attr('placeholder', 'Search by keywords or phrase');
			$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').prepend('<div class="wpDataTableFilterSectionLabel" id="table_search_filter_label"><label>' + tabLabelText + '</label></div>');
			//$(this).find('.wpdt_main_wrapper .wpDataTablesFilter .wpDataTableFilterBox').append('<div class="wpDataTableFilterSectionButton" id="table_search_filter_button"><button class="nalrc-search-button">Go &gt;</button>');

			// Move Languages Taught as filter option
			var filterBox = $(this).find('.wpdt_main_wrapper .wpDataTablesFilter #filterBox_table_1');
			var languagestaught = filterBox.find('#table_1_7_filter_sections');
			
			if (filterBox.length){
				filterBox.find('#table_search_filter_label').after(languagestaught);
				languagestaught.css({'padding-left':'0'});
			}

			// Start - Move Show Info above the table
			if ($(this).find('.wpdt-c .wpDataTables#table_1_wrapper').length)
				$(this).find('.wpdt-c .wpDataTables#table_1_wrapper').prepend('<div class="wpdt_info"><h2><span class="program-name">IHEs </span> Showing: <span class="cur-count"></span> of <span class="total-count"></span></h2></div>');
			if ($(this).find('.wpdt-c .wpDataTables#table_2_wrapper').length)
				$(this).find('.wpdt-c .wpDataTables#table_2_wrapper').prepend('<div class="wpdt_info"><h2><span class="program-name">Early Childhood – Grade 12 </span> Showing: <span class="cur-count"></span> of <span class="total-count"></span></h2></div>');
			
			function showInfo(show, show_info){
				var info = show_info.split(" ");
				if (Array.isArray(info)){
					info.forEach((str, index) => {
						if (index==3) {
							if (show.find('.wpdt-c .wpDataTables#table_1_wrapper').length)
								show.find('.wpdt-c .wpDataTables#table_1_wrapper .cur-count').text(str);
							if (show.find('.wpdt-c .wpDataTables#table_2_wrapper').length)
								show.find('.wpdt-c .wpDataTables#table_2_wrapper .cur-count').text(str);
						} else if (index==5) {
							if (show.find('.wpdt-c .wpDataTables#table_1_wrapper').length)
								show.find('.wpdt-c .wpDataTables#table_1_wrapper .total-count').text(str);
							if (show.find('.wpdt-c .wpDataTables#table_2_wrapper').length)
								show.find('.wpdt-c .wpDataTables#table_2_wrapper .total-count').text(str);
						}
					});
				}
			}
																						
			$(this).find('.dataTables_info').on("DOMSubtreeModified", function(){
				showInfo($(this).closest('.tab-pane'),$(this).text());
			});																			
		
			var showText = $(this).find('.dataTables_info').text();
			showInfo($(this),showText);
			// End - Move Show Info above the table

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

			// Make Visit button to be read as button instead of link
			if ($(this).find('.wpdt-c .wpDataTables table td.column-link a').length){
				$(this).find('.wpdt-c .wpDataTables table td.column-link a').each(function(){
					$(this).attr('role','button');
				});
			}
		});

		// Keyboard navigation of filter dropdown on Certifications page
		$(document).on('keydown', '.filter_select button.dropdown-toggle', function(e){
			var code = e.keyCode || e.which;
			console.log(code);
			if (code==13 || code==32){
				$(this).closest('.bootstrap-select').find('.selectpicker').selectpicker('show');
			} else if (code==38) {
				$(this).closest('.bootstrap-select').find('.dropdown-menu li:last-child a').focus();
			} else if (code==40) {
				$(this).closest('.bootstrap-select').find('.dropdown-menu li:first-child a').focus();
			}
		});

		$(document).on('focus', '.filter_select .dropdown-menu li a', function(e){
			$(this).closest('.dropdown-menu').find('li').removeClass('active');
			$(this).closest('li').addClass('active');
		});
		$(document).on('keycode', '.filter_select .dropdown-menu li a', function(e){
			var code = e.keyCode || e.which;
			if (code==13 || code==32){
				$(this).trigger('click');
			}
		});

		// Keyboard navigation of filter dropdown on Resources page
		$(document).on('keydown', '.nalrc-select-filter button.dropdown-toggle', function(e){
			var code = e.keyCode || e.which;
			if (code==13 || code==32){
				$(this).closest('.bootstrap-select').find('.selectpicker').selectpicker('toggle');
			} else if (code==38) {
				$(this).closest('.bootstrap-select').find('.dropdown-menu li:last-child a').focus();
			} else if (code==40) {
				$(this).closest('.bootstrap-select').find('.dropdown-menu li:first-child a').focus();
			}
		});

		/**--$(document).on('focus', '.nalrc-select-filter .dropdown-menu li a', function(e){
			$(this).closest('.dropdown-menu').find('li').removeClass('active');
			$(this).closest('li').addClass('active');
		});--**/

		$(document).on('keydown', '.nalrc-select-filter .dropdown-menu li a', function(e){
	      var code = e.keyCode || e.which;
	      if (code==9){
	        $(this).closest('.bootstrap-select').find('.selectpicker').selectpicker('toggle');
	        filter_index = 0;
	      } else if (code==40) {
	        //console.log($(this).closest('ul.dropdown-menu').find('li.active').index());
	        //$(this).closest("ul.dropdown-menu").scrollTop = ($(this).closest('ul.dropdown-menu').find('li.active').index())*32;
	      }
    	});

	},1000);

	setTimeout(function(){
		$('ul.certification-map-legend').appendTo('.fm-map-container');
		$('.usacustomHtml5MapContainer svg').attr('tabindex','-1');
		$('.usacustomHtml5MapContainer svg').attr('focusable','true');
		$('.usacustomHtml5MapContainer svg path').each(function(){
			if ($(this).attr('fill')=='#3693bb')
				$(this).attr('tabindex','0');
			let stClass = $(this).attr('class');
			let st = $(this).parent().find('text.' + stClass + '').text();
			var state;
			switch(st){
				case "ARAR":
					state = 'Arkansas';
					break;
				case "ALAL":
					state = 'Alabama';
					break;
				case "AKAK":
					state = 'Alaska';
					break;
				case "AZAZ":
					state = 'Arizona';
					break;
				case "BIEBIE":
					state = 'Bureau of Indian Education';
					break;
				case "CACA":
					state = 'California';
					break;
				case "COCO":
					state = 'Colorado';
					break;
				case "CTCT":
					state = 'Connecticut';
					break;
				case "DEDE":
					state = 'Delaware';
					break;
				case "DCDC":
					state = 'District of Columbia';
					break;
				case "FLFL":
					state = 'Florida';
					break;
				case "GAGA":
					state = 'Georgia';
					break;
				case "HIHI":
					state = 'Hawaii';
					break;
				case "IDID":
					state = 'Idaho';
					break;
				case "ILIL":
					state = 'Illinois';
					break;
				case "ININ":
					state = 'Indiana';
					break;
				case "IAIA":
					state = 'Iowa';
					break;
				case "KSKS":
					state = 'Kansas';
					break;
				case "KYKY":
					state = 'Kentucky';
					break;
				case "LALA":
					state = 'Louisiana';
					break;
				case "MEME":
					state = 'Maine';
					break;
				case "MDMD":
					state = 'Maryland';
					break;
				case "MAMA":
					state = 'Massachusetts';
					break;
				case "MIMI":
					state = 'Michigan';
					break;
				case "MNMN":
					state = 'Minnesota';
					break;
				case "MSMS":
					state = 'Mississippi';
					break;
				case "MOMO":
					state = 'Missouri';
					break;
				case "MTMT":
					state = 'Montana';
					break;
				case "NENE":
					state = 'Nebraska';
					break;
				case "NVNV":
					state = 'Nevada';
					break;
				case "NHNH":
					state = 'New Hampshire';
					break;
				case "NJNJ":
					state = 'New Jersey';
					break;
				case "NMNM":
					state = 'New Mexico';
					break;
				case "NYNY":
					state = 'New York';
					break;
				case "NCNC":
					state = 'North Carolina';
					break;
				case "NDND":
					state = 'North Dakota';
					break;
				case "OHOH":
					state = 'Ohio';
					break;
				case "OKOK":
					state = 'Oklahoma';
					break;
				case "OROR":
					state = 'Oregon';
					break;
				case "PAPA":
					state = 'Pennsylvania';
					break;
				case "PRPR":
					state = 'Puerto Rico';
					break;
				case "SCSC":
					state = 'South Carolina';
					break;
				case "SDSD":
					state = 'South Dakota';
					break;
				case "TNTN":
					state = 'Tennessee';
					break;
				case "TXTX":
					state = 'Texas';
					break;
				case "UTUT":
					state = 'Utah';
					break;
				case "VTVT":
					state = 'Vermont';
					break;
				case "VAVA":
					state = 'Virginia';
					break;
				case "WAWA":
					state = 'Washington';
					break;
				case "WVWV":
					state = 'West Virginia';
					break;
				case "WIWI":
					state = 'Wisconsin';
					break;
				case "WYWY":
					state = 'Wyoming';
					break;
				case "ASAS":
					state = 'American Samoa';
					break;
				case "GUGU":
					state = 'Guam';
					break;
				case "MPMP":
					state = 'Northern Mariana Islands';
					break;
				case "PWPW":
					state = 'Palau';
					break;
				case "VIVI":
					state = 'Virgin Islands';
					break;
			}
			$(this).attr('aria-label',state);
		});
	},1000);

	/** Certifications Map Popup Pagination **/
	var popup_pagination = function(){
		if ($('.nalrc-paginated-content').length){
			var hght = 0;
			if ($('#page-prev').length)
				$('#page-prev').attr('aria-label','Previous certification');
			if ($('#page-next').length)
				$('#page-next').attr('aria-label','Next certification');
			$('.pagination-item').each(function(){
				if ($(this).height()>hght)
					hght = $(this).height();
			});
			$('.page-item.disabled #page-curr').attr('tabindex','-1');
			$('.pagination-content').css('height',hght + 'px');
			$('.page-link').on('click', function(e){
				e.preventDefault();
				let target = $(this).attr('data-target');
				let pageCount = $('.pagination-item').length;
				var prev = 1;
				var next = 2;
				$('.pagination-item').removeClass('active').addClass('fade');
				$('.pagination-item[data-id='+ target + ']').removeClass('fade').addClass('active');
				if ($(this).attr('id')=="page-prev"){
					prev = (target==1?target:parseInt(target)-1);
					next = (target==1?next:parseInt(next)+1);
				} else {
					prev = parseInt(target)-1;
					next = (target==pageCount?target:parseInt(target)+1);
				}
				$('#page-prev').attr('data-target',prev);
				$('#page-prev').attr('aria-label','Previous certification');
				$('#page-curr').text(target + '/' + pageCount);
				$('#page-next').attr('data-target',next);
				$('#page-next').attr('aria-label','Next certification');
			});
		}
	};

	// Override Certifications Map Click
	var nalrc_html5map_onclick = function(ev, sid, map) { 
		ev.preventDefault();
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
				$('#usacustom-html5-map-state-info_0').html('<div class="nalrc-loader">Loading...</div>');
				$('#usacustom-html5-map-state-info_0').css('display','flex');
				$.ajax({ 
					type: 'POST', 
					url: (is_group_info ? nalrc.home_url + '/index.php' + '?map_id=' + window.map_id + '&usacustomhtml5map_get_group_info=' : 'https://oese.wp.nnth.dev/' + 'index.php' + '?map_id=5' + '&usacustomhtml5map_get_state_info=') + id, 
					success: function(data, textStatus, jqXHR){ 
						$('#usacustom-html5-map-state-info_0').html(data).css('opacity','1'); 
						$('#usacustom-html5-map-state-info_0').find('.modal-map-details-popup').modal('show');
						$('#usacustom-html5-map-state-info_0 .modal-map-details-popup').find('button').first().focus();
						if ($('.modal-backdrop').is(":visible"))
							$('.modal-backdrop').hide();
						popup_pagination();
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

	var certificationPopup = function(sid){
		var mapVar = $('.usacustomHtml5MapContainer').attr('data-map-variable');
		selectedState = sid;
		var link = usacustomhtml5map_map_0.fetchStateAttr(sid, 'link'); 
		var is_group = usacustomhtml5map_map_0.fetchStateAttr(sid, 'group'); 
		var popup_id = usacustomhtml5map_map_0.fetchStateAttr(sid, 'popup-id'); 
		var is_group_info = false; 
		
		if (is_group==undefined) { 
			if (sid.substr(0,1)=='p') { 
				popup_id = usacustomhtml5map_map_0.fetchPointAttr(sid, 'popup_id'); 
				link = usacustomhtml5map_map_0.fetchPointAttr(sid, 'link'); 
			} 
		} else if (typeof cfg.groups[is_group]['ignore_link'] == 'undefined' || ! cfg.groups[is_group].ignore_link) { 
			link = cfg.groups[is_group].link; 
			popup_id = cfg.groups[is_group]['popup_id']; 
			is_group_info = true; 
		} 

		var id = is_group_info ? is_group : (sid.substr(0,1)=='p' ? sid : usacustomhtml5map_map_0.fetchStateAttr(sid, 'id')); 
		$('#usacustom-html5-map-state-info_0').html('<div class="nalrc-loader">Loading...</div>');
		$('#usacustom-html5-map-state-info_0').css('display','flex');
		$.ajax({ 
			type: 'POST', 
			url: (is_group_info ? nalrc.home_url + '/index.php' + '?map_id=' + window.map_id + '&usacustomhtml5map_get_group_info=' : 'https://oese.wp.nnth.dev/' + 'index.php' + '?map_id=5' + '&usacustomhtml5map_get_state_info=') + id, 
			success: function(data, textStatus, jqXHR){ 
				$('#usacustom-html5-map-state-info_0').html(data).css('opacity','1'); 
				$('#usacustom-html5-map-state-info_0').find('.modal-map-details-popup').modal('show');
				//$('#usacustom-html5-map-state-info_0').find('.modal-map-details-popup .modal-content').attr('tabindex','0').focus();
				$('#usacustom-html5-map-state-info_0 .modal-map-details-popup').find('button').first().focus();
				if ($('.modal-backdrop').is(":visible"))
					$('.modal-backdrop').hide();
				popup_pagination();
			}, 
			dataType: 'text' 
		}); 
		return false; 
	}

	// View More link in Certifications Table
	if ($('.certifications-table').length){
		$(document).on('click', '.certifications-table.is-style-stripes table tbody tr td a', function(){
			let stId = $(this).attr('data-id');
			certificationPopup(stId);
		});
		$(document).on('keydown', '.certifications-table.is-style-stripes table tbody tr td a', function(e){
			var code = e.keyCode || e.which;
			if (code==13 || code==32){
				let stId = $(this).attr('data-id');
				certificationPopup(stId);
			}
		});
	}

	// Certifications Map Enter/Space bar key press
	$('.usacustomHtml5MapContainer').on('keydown','svg path',function(e){
		var code = e.keyCode || e.which;
		if (code==13 || code==32){
			var mapVar = $('.usacustomHtml5MapContainer').attr('data-map-variable');
			var sid = $(this).attr('class');
			selectedState = sid;
			var link = usacustomhtml5map_map_0.fetchStateAttr(sid, 'link'); 
			var is_group = usacustomhtml5map_map_0.fetchStateAttr(sid, 'group'); 
			var popup_id = usacustomhtml5map_map_0.fetchStateAttr(sid, 'popup-id'); 
			var is_group_info = false; 
			
			if (is_group==undefined) { 
				if (sid.substr(0,1)=='p') { 
					popup_id = usacustomhtml5map_map_0.fetchPointAttr(sid, 'popup_id'); 
					link = usacustomhtml5map_map_0.fetchPointAttr(sid, 'link'); 
				} 
			} else if (typeof cfg.groups[is_group]['ignore_link'] == 'undefined' || ! cfg.groups[is_group].ignore_link) { 
				link = cfg.groups[is_group].link; 
				popup_id = cfg.groups[is_group]['popup_id']; 
				is_group_info = true; 
			} 

			var id = is_group_info ? is_group : (sid.substr(0,1)=='p' ? sid : usacustomhtml5map_map_0.fetchStateAttr(sid, 'id')); 
			$('#usacustom-html5-map-state-info_0').html('<div class="nalrc-loader">Loading...</div>');
			$('#usacustom-html5-map-state-info_0').css('display','flex');
			$.ajax({ 
				type: 'POST', 
				url: (is_group_info ? nalrc.home_url + '/index.php' + '?map_id=' + window.map_id + '&usacustomhtml5map_get_group_info=' : 'https://oese.wp.nnth.dev/' + 'index.php' + '?map_id=5' + '&usacustomhtml5map_get_state_info=') + id, 
				success: function(data, textStatus, jqXHR){ 
					$('#usacustom-html5-map-state-info_0').html(data).css('opacity','1'); 
					$('#usacustom-html5-map-state-info_0').find('.modal-map-details-popup').modal('show');
					//$('#usacustom-html5-map-state-info_0').find('.modal-map-details-popup .modal-content').attr('tabindex','0').focus();
					$('#usacustom-html5-map-state-info_0 .modal-map-details-popup').find('button').first().focus();
					if ($('.modal-backdrop').is(":visible"))
						$('.modal-backdrop').hide();
					popup_pagination();
				}, 
				dataType: 'text' 
			}); 
			return false; 
		}
	});

	$(document).on('keydown',function(e){
		var code = e.keyCode || e.which;
		if (code==27){
			if ($('.modal-map-details-popup').is(':visible')){
				$('.usacustomHtml5MapStateInfo').find('svg path.'+ selectedState).focus();
				$('.modal-map-details-popup').modal('hide');
			}
			$('.usacustomHtml5MapStateInfo').hide().css('opacity','0.8');
		}
	});

	$(document).on('click','.usacustomHtml5MapStateInfo .modal-map-details-popup .modal-content .modal-header button', function(){
		$('.usacustomHtml5MapStateInfo').css({'display':'none','opacity':'0.8'});
	});

	// Move focus back to state on modal close
	$(document).on('keydown', '.modal-map-details-popup button.close', function(e){
		e.preventDefault();
		var code = e.keyCode || e.which;
		if (code==13 || code==32){
			console.log(selectedState);
			$('.modal-map-details-popup').modal('hide');
			$('.usacustomHtml5MapStateInfo').hide().css('opacity','0.8');
			$('.usacustomHtml5MapContainer').find('svg path.'+ selectedState).focus();
		}
	});

	$(document).on('click','.usacustomHtml5MapStateInfo .modal-map-details-popup', function(){
		if ($(this).is(":hidden"))
			$('.usacustomHtml5MapStateInfo').css({'display':'none','opacity':'0.8'});
	});

	$('.usacustomHtml5MapStateInfo').find('.modal-map-details-popup').on('hidden.bs.modal', function (e) {
	  $('.usacustomHtml5MapStateInfo').hide();
	  if (selectedState)
	  	$('.usacustomHtml5MapStateInfo').find('svg path.'+ selectedState).focus();
	})

	document.addEventListener('focus', (event) => { 
    	if ($(".modal-map-details-popup").css('display') == 'flex'){
    		if ($(event.target).closest('.modal-map-details-popup').length<=0)
        		$(".modal-map-details-popup button").first().focus();
        	else {
        		if ($(event.target).closest('.pagination-item').length>0  && !$(event.target).closest('.pagination-item').hasClass('active')){
        			$(".modal-map-details-popup .pagination-item").removeClass('active').addClass('fade');	
        			$(event.target).closest('.pagination-item').removeClass('fade').addClass('active');
        			const pageCnt = $(".modal-map-details-popup .pagination-item").length;
        			const pageIndex = $(event.target).closest('.pagination-item').attr('data-id');
        			$('.modal-map-details-popup .page-item #page-curr').text(pageIndex.toString()+'/'+pageCnt.toString());
        		}
        	}
    	} 
	}, true);

	$('.oese-tabs-block #oeseTabs').on('keydown','.nav-link', function(e){
        $(this).trigger('click');
     });

	// Set slider img alt text
	if ($('.nalrc-banner #oese-acf-slider').length>0){
		$('.nalrc-banner #oese-acf-slider .slider-list img').attr('alt','');
	}
});