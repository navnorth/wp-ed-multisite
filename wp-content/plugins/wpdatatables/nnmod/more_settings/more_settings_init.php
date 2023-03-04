<?php
namespace WDTnnMoreSettings;

use Exception;
use WDTConfigController;
use WDTColumn;
use WDTTools;
use WP_Error;
use WPDataTable;
defined('ABSPATH') or die('Access denied');
define('WDT_NNMOD_ROOT_PATH', WDT_ROOT_PATH . 'nnmod/more_settings/');
define('WDT_NNMOD_ROOT_URL', WDT_ROOT_URL . 'nnmod/more_settings/');
define('WDT_NNMOD_TEMPLATE_PATH', WDT_NNMOD_ROOT_PATH . 'templates/');

// Init More Settings for wpDataTables add-on
add_action('plugins_loaded', array('WDTnnMoreSettings\Plugin', 'moresettingsinit'), 10);
add_action( 'wp_enqueue_scripts', array('WDTnnMoreSettings\Plugin', 'wdtmoresettingsinitenqueuescripts') );

/**
 * Class Plugin
 * Main entry point of the wpDataTables More Settings Mod
 * @package WDTnnMoreSettings
 */

class Plugin{
    
    public static function wdtmoresettingsinitenqueuescripts(){
      wp_enqueue_style(
          'wdt-more-settings-frontend.css',
          WDT_NNMOD_ROOT_URL . 'assets/css/wdt-more-settings-frontend.css',
          array(),
          WDT_CURRENT_VERSION
      );
    }
    
    /**
     * Instantiates the class
     * @return bool
     */
    
    public static function moresettingsinit(){    
  
      // Add JS and CSS for editable tables on backend
      add_action('wdt_enqueue_on_edit_page', array('WDTnnMoreSettings\Plugin', 'MoreSettingsEnqueueBackendScript'));  
      // Add JS and CSS for editable tables on frontend
      add_action('wdt_enqueue_on_frontend', array('WDTnnMoreSettings\Plugin', 'MoreSettingsEnqueuefrontendScript'));    
      // Add "More Settings" tab on table configuration page
      add_action('wdt_add_table_configuration_tab', array('WDTnnMoreSettings\Plugin', 'MoreSettingsCustomSettingsTab'));
      // Add tab panel for "More Settings" tab on table configuration page
      add_action('wdt_add_table_configuration_tabpanel', array('WDTnnMoreSettings\Plugin', 'MoreSettingsCustomSettingsTabPanel'));
      // Extend table config before saving table to DB
      add_filter('wpdatatables_filter_insert_table_array', array('WDTnnMoreSettings\Plugin', 'MoreSettingsExtendTableConfig'), 10, 1);
      //Extend table before being rendered
      add_filter('wpdatatables_filter_rendered_table', array('WDTnnMoreSettings\Plugin', 'MoreSettingsExtendRenderedTable'), 10, 2);
    }

    
    /**
     * Add More Settings Settings tab on table configuration page
     */
    public static function MoreSettingsCustomSettingsTab(){
        ob_start();
        sleep(3);
        include WDT_NNMOD_TEMPLATE_PATH . 'more_settings_settings_tab.inc.php';
        $MoreSettingsTab = ob_get_contents();
        ob_end_clean();
        echo $MoreSettingsTab;
    }
    
    
    /**
     * Add tablpanel for More Settings tab on table configuration page
     */
    public static function MoreSettingsCustomSettingsTabPanel(){
        ob_start();
        include WDT_NNMOD_TEMPLATE_PATH . 'more_settings_settings_tabpanel.inc.php';
        $MoreSettingsTabPanel = ob_get_contents();
        ob_end_clean();
        echo $MoreSettingsTabPanel;
    }
    
    
    /**
     * Enqueue More Settings add-on files on back-end
     */
    public static function MoreSettingsEnqueueBackendScript(){
        wp_enqueue_script(
            'wdt-more-settings-backend',
            WDT_NNMOD_ROOT_URL . 'assets/js/wdt.more.settings.backend.js',
            array(),
            WDT_CURRENT_VERSION,
            true
        );
    }
    
    
    /**
     * Enqueue More Settings add-on files on front-end
     */
    public static function MoreSettingsEnqueuefrontendScript(){
        wp_enqueue_script(
            'wdt-more-settings-frontend.js',
            WDT_NNMOD_ROOT_URL . 'assets/js/wdt.more.settings.frontend.js',
            array(),
            WDT_CURRENT_VERSION,
            true
        );
    }
    
    
    /**
     * Function that extend table config before saving table to the database
     * @param $tableConfig - array that contains table configuration
     * @return mixed
     */
    public static function MoreSettingsExtendTableConfig($tableConfig){
        $table = apply_filters(
            'wpdatatables_before_save_table',
            json_decode(
                stripslashes_deep($_POST['table'])
            )
        );
        $advancedSettings = json_decode($tableConfig['advanced_settings']);
        if (isset($table->loadingIndicator)) $advancedSettings->loadingIndicator = $table->loadingIndicator;
        $tableConfig['advanced_settings'] = json_encode($advancedSettings);
        return $tableConfig;
    }
    
    
    /**
     * Add loading indicator HTML
     */
    public static function MoreSettingsExtendRenderedTable($output,$id){     
      $tableData = WDTConfigController::loadTableFromDB($id);
      $advancedSettings = json_decode($tableData->advanced_settings);    
      if($advancedSettings->loadingIndicator){
        $haystack = $output;
        $needle = '<div class="wpdt-c">';
        $replace = '<div class="wpdt-c cstm"><div class="wdtLoadingIndicator"><table><tr><td><div class="wdt-dual-ring"><div></div><div></div><div></div><div></div></div></td></tr></table></div>';
        $pos = strpos($haystack, $needle);
        if ($pos !== false) {
          $output = substr_replace($haystack, $replace, $pos, strlen($needle));
        }
      }      
      return $output;
    }
    
      
} //end of class