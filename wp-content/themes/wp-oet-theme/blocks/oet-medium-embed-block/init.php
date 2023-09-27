<?php
/**
 * Plugin Name:       OET Medium Embed Block
 * Description:       Medium Embed Block for OET
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oet-medium-embed-block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */
require_once( __DIR__ . '/oet-medium-data.php' );
function oet_medium_embed_block_init() {
    $dir = dirname( __FILE__ );
    $dir_url = get_stylesheet_directory_uri().'/blocks/oet-medium-embed-block/';

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "create-block/oer_subjects_index" block first.'
        );
    }
    
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-block-medium-embed-block-editor-script',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-block-medium-embed-block-editor-script', 'oet_medium_embed', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    wp_set_script_translations( 'oet-block-medium-embed-block-editor-script', 'oet-medium-embed' );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-block-medium-embed-block-editor-style',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-block-medium-embed-style',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

	register_block_type( 'oet-block/oet-medium-embed-block', array(
        'editor_script'     => 'oet-block-medium-embed-block-editor-script',
        'editor_style'      => 'oet-block-medium-embed-block-editor-style',
        'style'             => 'oet-block-medium-embed-style',
        'render_callback'   => 'oet_display_medium_embed'
    ) );
}
add_action( 'init', 'oet_medium_embed_block_init' );

/*
* Add OET Block Category
*/
function oet_add_oet_block_category( $categories ) {
    $category_slugs = wp_list_pluck( $categories, 'slug' );
    return in_array( 'oet-block-category', $category_slugs, true ) ? $categories : array_merge(
        array(
            array(
                'slug' => 'oet-block-category',
                'title' => __( 'OET Blocks', 'oet-block-category' ),
            ),
        ),
        $categories
    );
}

// Supporting older version of Wordpress - WP_Block_Editor_Context is only introduced in WP 5.8
if ( class_exists( 'WP_Block_Editor_Context' ) ) {
    add_filter( 'block_categories_all', 'oet_add_oet_block_category', 10, 2);
} else {
    add_filter( 'block_categories', 'oet_add_oet_block_category', 10, 2);
}

// Medium Embed Block HTML to display
function oet_display_medium_embed($attributes, $ajax = false){
    $html = "";
    $shortcodeText = "";
    
    if (!empty($attributes)) {
        extract($attributes);

        $shortcodeText = "[oet_medium";
        if (isset($attributes['url']) && $attributes['url']!=="")
            $shortcodeText .= sprintf(" url='%s'",esc_url($attributes['url']));
        if (isset($attributes['title']) && $attributes['title']!=="")
            $shortcodeText .= sprintf(" title='%s'",$attributes['title']);
        if (isset($attributes['description']) && $attributes['description']!=="")
            $shortcodeText .= sprintf(" description='%s'",$attributes['description']);
        if (isset($attributes['align']) && $attributes['align']!=="")
            $shortcodeText .= sprintf(" align='%s'",$attributes['align']);
        if (isset($attributes['textalign']) && $attributes['textalign']!=="")
            $shortcodeText .= sprintf(" textalign='%s'",$attributes['textalign']);
        if (isset($attributes['bgImage']) && $attributes['bgImage']!=="")
            $shortcodeText .= sprintf(" image='%s'",$attributes['bgImage']);
        if (isset($attributes['bgcolor']) && $attributes['bgcolor']!=="")
            $shortcodeText .= sprintf(" bgcolor='%s'",str_replace('#','',$attributes['bgcolor']));
        if (isset($attributes['authorurl']) && $attributes['authorurl']!=="")
            $shortcodeText .= sprintf(" authorurl='%s'",$attributes['authorurl']);
        if (isset($attributes['authorname']) && $attributes['authorname']!=="")
            $shortcodeText .= sprintf(" authorname='%s'",$attributes['authorname']);
        if (isset($attributes['authorlogo']) && $attributes['authorlogo']!=="")
            $shortcodeText .= sprintf(" authorlogo='%s'",$attributes['authorlogo']);
        if (isset($attributes['heading']) && $attributes['heading']!=="")
            $shortcodeText .= sprintf(" heading='%s'",$attributes['heading']);
        else
            $shortcodeText .= sprintf(" heading='%s'","h2");
        $shortcodeText .= "]";

        if (isset($shortcodeText)){
            $html .= do_shortcode($shortcodeText);
        }
    }
    
    return $html;
}

// Display Medium Embed ajax
function oet_ajax_display_medium_embed(){
    $shortcode = oet_display_medium_embed($_POST, true);
    echo $shortcode;
    die();
}
add_action( 'wp_ajax_display_medium_embed', 'oet_ajax_display_medium_embed' );
add_action( 'wp_ajax_nopriv_display_medium_embed', 'oet_ajax_display_medium_embed' );

// Get Medium Data By Url
function oet_get_medium_data_form_url(){
    $medium_data = new OET_Medium_Data($_POST['medium_url']);
    $medium_post = $medium_data->get_medium_post();
    echo json_encode($medium_post);
    die();
}
add_action( 'wp_ajax_get_medium_post', 'oet_get_medium_data_form_url' );
add_action( 'wp_ajax_nopriv_get_medium_post', 'oet_get_medium_data_form_url' );