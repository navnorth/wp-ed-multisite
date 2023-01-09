<?php
/**
 * Plugin Name:       OET Callout Box
 * Description:       Displays Callout box on the page.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oet-callout-box
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/
 */
function oet_callout_box_block_init(){
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/callout-box/';
    $version_58 = is_version_58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "create-block/oer-object-resources-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-callout-box-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-callout-box-block-editor', 'oet_callout_box', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58 ) );


    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-callout-box-block-editor',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-callout-box-block-css',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 'oet-block/oet-callout-box-block', array(
        'editor_script' => 'oet-callout-box-block-editor',
        'editor_style'  => 'oet-callout-box-block-editor',
        'style'         => 'oet-callout-box-block-css',
        'render_callback' => 'oet_callout_box_block_display'
    ) );
}

function oet_callout_box_block_json_init() {
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/callout-box/';
    $version_58 = is_version_58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "create-block/oer-object-resources-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-callout-box-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-callout-box-block-editor', 'oet_callout_box', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58 ) );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-callout-box-block-editor',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-callout-box-block-css',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 
        __DIR__ ,
        array(
            'editor_script' => 'oet-callout-box-block-editor',
            'editor_style'  => 'oet-callout-box-block-editor',
            'style'         => 'oet-callout-box-block-css',
            'render_callback' => 'oet_callout_box_block_display',
        )
    );
}


if (!function_exists('is_version_58')) {
    function is_version_58(){
        if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
            return false;
        } else {
            return true;
        }
    }
}

if ( is_version_58() ) {
    add_action( 'init', 'oet_callout_box_block_json_init' );
} else {
    add_action( 'init', 'oet_callout_box_block_init' );
}


// Display Callout Box Block
/**
 * Callout Box
 * Shortcode Example : [oet_callout type='check' width='12' color='00529f' alignment='left']content[/oet_callout]
 */
function oet_callout_box_block_display( $attributes, $ajax = false ){
    $html = "";
    $shortcodeText = "";
    if (!empty($attributes)) {
        extract($attributes);
        
        if (!$ajax)
            $html = '<div class="oet-callout-box-block">';

        $shortcodeText = "[oet_callout";
        if (isset($type))
            $shortcodeText .= " type='".$type."'";
        if (isset($width))
            $shortcodeText .= " width='".$width."'";
        if (isset($color))
            $shortcodeText .= " color='".$color."'";
        if (isset($alignment))
            $shortcodeText .= " alignment='".$alignment."'";
        $shortcodeText .= "]";
        if (isset($content))
            $shortcodeText .= $content;
        $shortcodeText .= "[/oet_callout]";
        
        if (isset($shortcodeText)){
            $html .= do_shortcode($shortcodeText);
        }

        if (!$ajax)
            $html .= '</div>';
    }
    
    return $html;
}


// Display Callout Box Block Preview via Ajax
function oet_ajax_display_callout_box_block(){
    $shortcode = oet_callout_box_block_display($_POST['attributes'], true);
    echo wpautop(stripslashes($shortcode));
    die();
}
add_action( 'wp_ajax_display_callout_box', 'oet_ajax_display_callout_box_block' );
add_action( 'wp_ajax_nopriv_display_callout_box', 'oet_ajax_display_callout_box_block' );