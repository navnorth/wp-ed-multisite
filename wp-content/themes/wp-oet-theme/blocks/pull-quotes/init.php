<?php
function oet_pull_quotes_block_init(){
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/pull-quotes/';
    $version_58 = is_version_58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "oet-block/oet-pull-quotes-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-pull-quotes-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-pull-quotes-block-editor', 'oet_pull_quotes', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58, 'theme_url' => get_stylesheet_directory_uri() ) );


    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-pull-quotes-block-editor-style',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-pull-quotes-block-style',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 'oet-block/oet-pull-quotes-block', array(
        'editor_script' => 'oet-pull-quotes-block-editor',
        'editor_style'  => 'oet-pull-quotes-block-editor-style',
        'style'         => 'oet-pull-quotes-block-style',
        'render_callback' => 'oet_pull_quotes_block_display'
    ) );
}

// Register Block via block.json
function oet_pull_quotes_block_json_init() {
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/pull-quotes/';
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
        'oet-pull-quotes-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-pull-quotes-block-editor', 'oet_pull_quotes', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58, 'theme_url' => get_stylesheet_directory_uri() ) );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-pull-quotes-block-editor-style',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );


    register_block_type( 
        __DIR__ ,
        array(
            'editor_script' => 'oet-pull-quotes-block-editor',
            'editor_style'  => 'oet-pull-quotes-block-editor-style',
            'render_callback' => 'oet_pull_quotes_block_display',
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
    add_action( 'init', 'oet_pull_quotes_block_json_init' );
} else {
    add_action( 'init', 'oet_pull_quotes_block_init' );
}

// Render Callback of Pull Quotes Block
/**
 * Pull Quote
 * Shortcode Example : [pull_quote speaker="" additional_info=""]your content goes here[/pull_quote]
 */
function oet_pull_quotes_block_display($attributes, $ajax = false){
    $html = "";
    $shortcodeText = "";
    if (!empty($attributes)) {
        extract($attributes);
        
        if (!$ajax)
            $html = '<div class="oet-pull-quotes-block">';

        $shortcodeText = "[pull_quote";
        if (isset($speaker))
            $shortcodeText .= " speaker='".$speaker."'";
        if (isset($additionalInfo))
            $shortcodeText .= " additional_info='".$additionalInfo."'";
        $shortcodeText .= "]";
        if (isset($content))
            $shortcodeText .= $content;
        $shortcodeText .= "[/pull_quote]";
        
        if (isset($shortcodeText)){
            $html .= do_shortcode($shortcodeText);
        }

        if (!$ajax)
            $html .= '</div>';
    }
    
    return $html;
}


// Display Pull Quotes Block Preview via Ajax
function oet_ajax_display_pull_quotes_block(){
    $shortcode = oet_pull_quotes_block_display($_POST['attributes'], true);
    echo wpautop(stripslashes($shortcode));
    die();
}
add_action( 'wp_ajax_display_pull_quotes', 'oet_ajax_display_pull_quotes_block' );
add_action( 'wp_ajax_nopriv_display_pull_quotes', 'oet_ajax_display_pull_quotes_block' );