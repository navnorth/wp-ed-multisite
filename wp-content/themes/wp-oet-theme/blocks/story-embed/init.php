<?php
/**
 * Plugin Name:       OET Story Embed
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oet-story-embed
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
function oet_story_embed_block_init(){
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/story-embed/';
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
        'oet-story-embed-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-story-embed-block-editor', 'oet_story_embed', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58, 'theme_url' => get_stylesheet_directory_uri() ) );


    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-story-embed-block-editor-style',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-story-embed-block-style',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 'oet-block/oet-story-embed-block', array(
        'editor_script' => 'oet-story-embed-block-editor',
        'editor_style'  => 'oet-story-embed-block-editor-style',
        'style'         => 'oet-story-embed-block-style',
        'render_callback' => 'oet_story_embed_block_display'
    ) );
}

// Register Block via block.json
function oet_story_embed_block_json_init() {
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/story-embed/';
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
        'oet-story-embed-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-story-embed-block-editor', 'oet_story_embed', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58, 'theme_url' => get_stylesheet_directory_uri() ) );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-story-embed-block-editor-style',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );


    register_block_type( 
        __DIR__ ,
        array(
            'editor_script' => 'oet-story-embed-block-editor',
            'editor_style'  => 'oet-story-embed-block-editor-style',
            'render_callback' => 'oet_story_embed_block_display',
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
    add_action( 'init', 'oet_story_embed_block_json_init' );
} else {
    add_action( 'init', 'oet_story_embed_block_init' );
}

function oet_add_stories_route(){
    register_rest_route(
        'oet/v2',
        'stories',
        array(  'methods'=>'GET',
            'callback'=>'oet_story_embed_get_stories',
            'permission_callback' => function(){
                return current_user_can('edit_posts');
            }
        )
    );
    register_rest_route(
        'oet/v2',
        '/story/(?P<id>\d+)',
        array(  'methods'=>'GET',
            'callback'=>'oet_story_embed_get_story',
            'permission_callback' => function(){
                return current_user_can('edit_posts');
            }
        )
    );
}
add_action( 'rest_api_init' , 'oet_add_stories_route' );

function oet_story_embed_get_stories(){
    $story_posts = array();
    $args = array(
            'post_type'         => 'stories',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'asc'
        );

    $stories = new WP_Query($args);

    if (count($stories->posts)>0){
        $story_posts[] = array('value'=> 0, 'label' => 'Select a story');
        foreach($stories->posts as $story){
            $story_posts[] = array('value'=> $story->ID, 'label' => $story->post_title);
        }
    }
    return $story_posts;
}

function oet_story_embed_get_story($data){
    $story_post = array();
    $args = array(
            'post_type'         => 'stories',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'asc',
            'p'                 => $data['id']
        );

    $stories = new WP_Query($args);

    if (count($stories->posts)>0){
        foreach($stories->posts as $story){
            $excerpt = "";
            $story_post['id'] = $story->ID;
            $story_post['title'] = $story->post_title;

            if (function_exists('display_story_excerpt')){
                $excerpt = display_story_excerpt($data['id'], 300);
            }

            if (strlen($excerpt)<=0) {
                $excerpt = get_excerpt_by_id($data['id']);
            }

            $story_post['content'] = $excerpt;
        }
    }
    return $story_post;
}

// Render Callback of Story Embed Block
/**
 * Story Embed
 * Shortcode Example : [oet_story id='2376' width='6' alignment='' callout_color='' callout_type='' title='']Content[/oet_story]
 */
function oet_story_embed_block_display($attributes, $ajax = false){
    $html = "";
    $shortcodeText = "";

    if (!empty($attributes)) {
        extract($attributes);
        
        if (!$ajax)
            $html = '<div class="oet-story-embed-block">';

        $shortcodeText = "[oet_story";
        if (isset($storyId))
            $shortcodeText .= " id='".$storyId."'";
        if (isset($title))
            $shortcodeText .= " title='".$title."'";
        if (isset($width))
            $shortcodeText .= " width='".$width."'";
        else 
            $shortcodeText .= " width='6'";
        if (isset($alignment))
            $shortcodeText .= " alignment='".$alignment."'";
        if (isset($calloutColor))
            $shortcodeText .= " callout_color='".$calloutColor."'";
        if (isset($calloutType))
            $shortcodeText .= " callout_type='".$calloutType."'";
        else
            $shortcodeText .= " callout_type='checkmark'";
        $shortcodeText .= "]";
        if (isset($content))
            $shortcodeText .= $content;
        $shortcodeText .= "[/oet_story]";
        
        if (isset($shortcodeText)){
            $html .= do_shortcode($shortcodeText);
        }

        if (!$ajax)
            $html .= '</div>';
    }
    
    return $html;
}


// Display Pull Quotes Block Preview via Ajax
function oet_ajax_display_story_embed_block(){
    $shortcode = oet_story_embed_block_display($_POST['attributes'], true);
    echo wpautop(stripslashes($shortcode));
    die();
}
add_action( 'wp_ajax_display_story_embed', 'oet_ajax_display_story_embed_block' );
add_action( 'wp_ajax_nopriv_display_story_embed', 'oet_ajax_display_story_embed_block' );