jQuery( document ).ready(function($) {
     $('.slideshow_container .slideshow_slide a').on("focus",function(){
	$(this).closest(".slideshow_container").trigger("mouseenter");
     });
     $('.slideshow_container .slideshow_slide a').on("focusout",function(){
	$(this).closest(".slideshow_container").trigger("mouseleave");
     });
     /** Add Tab Index to WPDataTables tool buttons **/
     if ($('.wpDataTables.wpDataTablesWrapper .dt-buttons').length){
     	$('.wpDataTables.wpDataTablesWrapper .dt-buttons .dt-button').each(function(){
     		$(this).attr('tabindex','0');
     	});
     }

     /** Add Tab Index to WPDataTables row **/
     if ($('.wpdt-c .wpDataTablesWrapper table.wpDataTable').length){
          addRowTabIndex();
          $(document).on('keyup', '.wpdt-c .wpDataTablesWrapper table.wpDataTable tr td a.master_detail_column_btn', function(event){
               if (event.defaultPrevented) {
                    return;
               }

               var key = event.keyCode || event.which || event.key;

               if (key===32 || key===13) {
                    $(this).addClass('current');
                    $(this).trigger("click");
               }
          });
          $('#wdt-md-modal').on('shown.bs.modal', function(){
               if (!$(this).find('#modalintro').length)
                    $(this).prepend('<div id="modalintro" tabindex="0"></div>');
               $(this).attr('aria-hidden', false);
               $(this).find('.modal-body').attr('tabindex','-1');
               $(this).find('#modalintro').focus();
          });
          $('#wdt-md-modal').on('hidden.bs.modal', function(){
               $(this).attr('aria-hidden', true);
               if ($(this).find('#modalintro').length)
                    $(this).find('#modalintro').remove();
               let curBtn = $('.wpdt-c .wpDataTablesWrapper table.wpDataTable tr td a.master_detail_column_btn.current');
               curBtn.focus();
               curBtn.removeClass('current');
          });
          $(document).on('keyup', '.wpdt-c .wpDataTablesWrapper .paginate_button', function(event){
               var kCode = event.keyCode || event.which || event.key;
               if (kCode===32 || kCode===13) {
                    setTimeout(addRowTabIndex(),100);
               }
          });

     }

     /* Add label to State box selection */
     var mapSelector = $('.usacustomHtml5MapSelector');
     if (mapSelector.length){
          if (mapSelector.find('select')){
               let sel = mapSelector.find('select');
               let selId = sel.attr('id');
               let label = sel.find('option').first().text();
               mapSelector.prepend('<label for="' + selId  + '">' + label + '</label>');
               sel.find('option').first().text("");
          }
     }

     /* Add label to WPDataTables Filters */
     if ($('.wpdt-c .wpDataTablesFilter .wpDataTableFilterBox').length){
          $('.wpdt-c .wpDataTablesFilter .wpDataTableFilterBox .wpDataTableFilterSection').each(function(){
               let lbl = $(this).find('label');
               var id = $(this).find('div').attr('class');
               if (typeof id !== 'undefined')
                    id = id.replace(/-/g, '_');
               let input = $(this).find('input').attr('id',id);
               lbl.attr('for',id);
          });
     }

     // WPDataTable Filter dropdowns
     $('.wpDataTableFilterBox .wpDataTableFilterSection button.dropdown-toggle').focus(function(){
        $(this).closest('.wpDataTableFilterSection').addClass('focused');
     });
     $('.wpDataTableFilterBox .wpDataTableFilterSection button.dropdown-toggle').focusout(function(){
        $(this).closest('.wpDataTableFilterSection').removeClass('focused');
     });
     $('.wpDataTableFilterBox .wpDataTableFilterSection .wdt-filter-control .dropdown-menu > li > a').focus(function(){
        $(this).closest('div.dropdown-menu').addClass('open');
     });
     $(document).on('keyup','.wpDataTableFilterBox .wpDataTableFilterSection button.dropdown-toggle', function(event){
          if (event.defaultPrevented) {
               return;
          }
          var key = event.keyCode || event.which || event.key;

          if (key===32 || key===13) {
               $(this).closest('.wdt-filter-control').find('.dropdown-menu li.selected a').focus();
          }
     });
     $(document).on('keyup','.wpDataTableFilterBox .wpDataTableFilterSection .wdt-filter-control .dropdown-menu li a', function(event){
          if (event.defaultPrevented) {
               return;
          }
          var key = event.keyCode || event.which || event.key;

          if (key===32 || key===13) {
               $(this).trigger('click');
          }
     });

     function addRowTabIndex(){
          $('.wpdt-c .wpDataTablesWrapper table.wpDataTable tr td a.master_detail_column_btn').each(function(){
               $(this).attr('tabindex', '0');
          });
     }
});
