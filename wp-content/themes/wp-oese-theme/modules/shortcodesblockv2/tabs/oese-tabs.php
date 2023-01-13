<?php
/**
 * Plugin Name:       OESE Tabs
 * Description:       Displays tabbed content on the page,
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oese-tabs
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function oese_tabs_load_auto_tabs_script() {
    $dir_url = get_stylesheet_directory_uri().'/modules/shortcodesblockv2/tabs/';
    wp_enqueue_script( 'theme-nalrc-script',$dir_url.'build/auto-tab.js');
}
add_action( 'wp_enqueue_scripts', 'oese_tabs_load_auto_tabs_script');
function oese_tabs_block_init(){
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/modules/shortcodesblockv2/tabs/';
    $version_58 = is_version58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "oet-block/oet-publication-intro-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oese-tabs-block-editor',
        $dir_url . $index_js,
        //plugins_url( $index_js, __FILE__),
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oese-tabs-block-editor', 'oese_tabs', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => false ) );


    $editor_css = 'build/index.css';
    wp_register_style(
        'oese-tabs-block-editor-style',
        //plugins_url( $editor_css, __FILE__),
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oese-tabs-block-style',
        $dir_url . $style_css,
        //plugins_url( $style_css, __FILE__ ),
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 'oese-block/oese-tabs', array(
        'editor_script' => 'oese-tabs-block-editor',
        'editor_style'  => 'oese-tabs-block-editor-style',
        'style'         => 'oese-tabs-block-style',
        //'render_callback' => 'oese_tabs_block_display'
    ) );
}

// Register Block via block.json
function oese_tabs_block_json_init() {
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/tabs/';
    $version_58 = is_version58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "create-block/oer-object-resources-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oese-tabs-block-editor',
        $$dir . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oese-tabs-block-editor', 'oese_tabs', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58 ) );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oese-tabs-block-editor',
        $dir . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oese-tabs-block-style',
        $dir . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 
        __DIR__ ,
        array(
            'editor_script' => 'oese-tabs-block-editor',
            'editor_style'  => 'oese-tabs-block-editor',
            'style'         => 'oese-tabs-block-style',
            'render_callback' => 'oese_tabs_block_display',
        )
    );
}

if (!function_exists('is_version58')) {
    function is_version58(){
        if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
            return false;
        } else {
            return true;
        }
    }
}

if ( is_version58() ) {
    //add_action( 'init', 'oese_tabs_block_init' );
    add_action( 'init', 'oese_tabs_block_json_init' );
    //add_action( 'init', 'oet_recommended_resources_block_json_init' );
} else {
    //add_action( 'init', 'oet_recommended_resources_block_init' );
    //add_action( 'init', 'oese_tabs_block_json_init' );
    add_action( 'init', 'oese_tabs_block_init' );
}

function oese_tabs_block_display() {

}