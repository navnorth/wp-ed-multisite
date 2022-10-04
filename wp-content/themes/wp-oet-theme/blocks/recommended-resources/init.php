<?php
/**
 * Plugin Name:       OET Recommended Resources
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oet-recommended-resources
 *
 * @package           oet-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/
 */
function oet_recommended_resources_block_init(){
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/recommended-resources/';
    var_dump($dir_url);
    $version_58 = is_version_58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "oet-block/oet-publication-intro-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-recommended-resources-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-recommended-resources-block-editor', 'oet_recommended_resources', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58 ) );


    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-recommended-resources-block-editor-style',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-recommended-resources-block-style',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 'oet-block/oet-recommended-resources-block', array(
        'editor_script' => 'oet-recommended-resources-block-editor',
        'editor_style'  => 'oet-recommended-resources-block-editor-style',
        'style'         => 'oet-recommended-resources-block-style',
        'render_callback' => 'oet_recommended_resources_block_display'
    ) );
}

// Register Block via block.json
function oet_recommended_resources_block_json_init() {
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/recommended-resources/';
    var_dump($dir_url);
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
        'oet-recommended-resources-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-recommended-resources-block-editor', 'oet_recommended_resources', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58 ) );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-recommended-resources-block-editor',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-recommended-resources-block-style',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 
        __DIR__ ,
        array(
            'editor_script' => 'oet-recommended-resources-block-editor',
            'editor_style'  => 'oet-recommended-resources-block-editor',
            'style'         => 'oet-recommended-resources-block-style',
            'render_callback' => 'oet_recommended_resources_block_display',
        )
    );
}

// Checks WP version
if (!function_exists('is_version_58')) {
    function is_version_58(){
        if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
            return false;
        } else {
            return true;
        }
    }
}

// Checks WP version to register block via block json if version is 5.8 or later
if ( is_version_58() ) {
    add_action( 'init', 'oet_recommended_resources_block_init' );
    //add_action( 'init', 'oet_recommended_resources_block_json_init' );
} else {
    //add_action( 'init', 'oet_recommended_resources_block_init' );
    add_action( 'init', 'oet_recommended_resources_block_json_init' );
}

// Display Recommended Resources Block
/**
 * Recommended Resources
 * Shortcode Example : [recommended_resources heading='' media_type1='' src1='' text1='' link1='' media_type2='' src2='' text2='' link2='' media_type3='' src3='' text3=''  link3='']
 */
function oet_recommended_resources_block_display($attributes, $ajax = false){
    $html = "";
    $shortcodeText = "";
    $mediaLink1 = "";
    $mediaLink2 = "";
    $mediaLink3 = "";
    $mediaType1 = "video";
    $mediaType2 = "video";
    $mediaType3 = "video";
    
    if (!empty($attributes)){
        extract($attributes);

        if (!$ajax)
            $html = '<div class="oet-recommended-resources-block">';

        $shortcodeText = '[recommended_resources';

        if (isset($heading))
            $shortcodeText .= ' heading="'.$heading.'"';
        if (isset($mediaType1))
            $shortcodeText .= ' media_type1="'.$mediaType1.'"';
        if (isset($mediaSource1))
            $shortcodeText .= ' src1="'.$mediaSource1.'"';
        if (isset($mediaText1))
            $shortcodeText .= ' text1="'.$mediaText1.'"';
        if (isset($mediaLink1))
            $shortcodeText .= ' link1="'.$mediaLink1.'"';
        if (isset($mediaType2))
            $shortcodeText .= ' media_type2="'.$mediaType2.'"';
        if (isset($mediaSource2))
            $shortcodeText .= ' src2="'.$mediaSource2.'"';
        if (isset($mediaText2))
            $shortcodeText .= ' text2="'.$mediaText2.'"';
        if (isset($mediaLink2))
            $shortcodeText .= ' link2="'.$mediaLink2.'"';
        if (isset($mediaType3))
            $shortcodeText .= ' media_type3="'.$mediaType3.'"';
        if (isset($mediaSource3))
            $shortcodeText .= ' src3="'.$mediaSource3.'"';
        if (isset($mediaText3))
            $shortcodeText .= ' text3="'.$mediaText3.'"';
        if (isset($mediaLink3))
            $shortcodeText .= ' link3="'.$mediaLink3.'"';

        $shortcodeText .= ']';
        
        if (isset($shortcodeText)){
            $html .= do_shortcode($shortcodeText);
        }

        if (!$ajax)
            $html .= '</div>';
    }
    return $html;
}


// Display Recommended Resources Block Preview via Ajax
function oet_ajax_display_recommended_resources_block(){
    $shortcode = oet_recommended_resources_block_display($_POST['attributes'], true);
    echo $shortcode;
    die();
}
add_action( 'wp_ajax_display_recommended_resources', 'oet_ajax_display_recommended_resources_block' );
add_action( 'wp_ajax_nopriv_display_recommended_resources', 'oet_ajax_display_recommended_resources_block' );
