(function ($) {
    $(function () {

        /**
         * Extend wpdatatable_config object with new properties and methods
         */
        $.extend(wpdatatable_config, {
            loadingIndicator: 0,
            setLoadingIndicator: function (loadingIndicator) {
                wpdatatable_config.loadingIndicator = loadingIndicator;
                $('#wdt-toggle-loading-indicator').prop('checked', loadingIndicator);            
            }
        });
        
  
        /**
         * Load the table for editing
         */
        if (typeof wpdatatable_init_config !== 'undefined' && wpdatatable_init_config.advanced_settings !== '') {
            var advancedSettings = JSON.parse(wpdatatable_init_config.advanced_settings);
            if (advancedSettings !== null) {
                var loadingIndicator = advancedSettings.loadingIndicator;
                if (typeof loadingIndicator !== 'undefined') {
                    wpdatatable_config.setLoadingIndicator(loadingIndicator);
                }
            }
        }
              

        /**
         * Toggle "Loading Indicator" option
         */
        $('#wdt-toggle-loading-indicator').change(function () {
            wpdatatable_config.setLoadingIndicator($(this).is(':checked') ? 1 : 0);
        });
        
        /**
         * Show Loading Indicator settings tab
         */
        if (!jQuery('.loading-indicator-settings-tab').is(':visible')) {
            jQuery('.loading-indicator-settings-tab').animateFadeIn();
        }

    });

})(jQuery);





