<?php
/**
 * Plugin Name:       Featured Video Block
 * Description:       Displays featured video block on a page.
 * Requires at least: 5.6
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oet-video-block
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
function oet_video_block_init() {
    //register_block_type( __DIR__ );
    $dir = dirname( __FILE__ );
    $dir_url = get_stylesheet_directory_uri().'/blocks/featured-video/';

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "create-block/oer_subjects_index" block first.'
        );
    }
    
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-video-block-editor-script',
        $dir_url.$index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-video-block-editor-script', 'oet_video_block', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    wp_set_script_translations( 'oet-video-block-editor-script', 'oet-video-block' );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-video-block-editor-style',
        $dir_url.$editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-video-block-style',
        $dir_url.$style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 'oet-block/oet-video-block', array(
        'editor_script'     => 'oet-video-block-editor-script',
        'editor_style'      => 'oet-video-block-editor-style',
        'style'             => 'oet-video-block-style',
        'render_callback'   => 'oet_video_block_display'
    ) );
}
add_action( 'init', 'oet_video_block_init' );

function oet_video_block_display( $attributes , $ajax = false ) {
    $html = "";
    $shortcodeText = "";
    if (!empty($attributes)) {
        extract($attributes);

        if (!$ajax)
            $html .= '<div class="oet-video-block">';
        $shortcodeText = "[featured_video";
        if (isset($videoId))
            $shortcodeText .= ' videoid="'.$videoId.'"';
        if (isset($heading))
            $shortcodeText .= ' heading="'.$heading.'"';
        if (isset($description)){
            if ($description=="")
                $shortcodeText .= ' description="Edit video description"';
            else
                $shortcodeText .= ' description="'.$description.'"';
        }
        if (isset($height))
            $shortcodeText .= ' height="'.$height.'"';
        $shortcodeText .= "]";
        
        if (isset($shortcodeText)){
            $html .= do_shortcode($shortcodeText);
        }
        if (!$ajax)
            $html .= '</div>';
    }
    
    return $html;
}

// Display Medium Embed ajax
function oet_ajax_display_video_block(){
    $vidId = $_POST['attributes']['videoId'];
    if (!oet_yt_exists($videoId))
        echo json_encode(array('error'=> true, "message"=>"Video does not exist."));
    else {
        $shortcode = oet_video_block_display($_POST['attributes'], true);
        echo stripslashes($shortcode);
    }
    die();
}
add_action( 'wp_ajax_display_video_block', 'oet_ajax_display_video_block' );
add_action( 'wp_ajax_nopriv_display_video_block', 'oet_ajax_display_video_block' );

function oet_get_YT_videoId() {
    if ($_POST){
        $url = $_POST['url'];
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $youtube_id = $match[1];

        $vid_title = oet_yt_title($youtube_id);

        if (isset($vid_title) && !empty($vid_title)){
            echo json_encode(array("video_id" => $youtube_id, "video_title" => $vid_title));
        } else {
            echo json_encode(array("error" => true, "message" => "Please enter a valid URL."));
        }
    }
    die();
}
add_action( 'wp_ajax_get_video_id', 'oet_get_YT_videoId' );
add_action( 'wp_ajax_nopriv_get_video_id', 'oet_get_YT_videoId' );

function oet_yt_exists($videoID) {
    $yt_url = "https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$videoID&format=json";
    $headers = get_headers($yt_url);

    return (substr($headers[0], 9, 3) !== "404" || substr($headers[0], 9, 3) !== "401");
}


function oet_yt_title($videoID) {
    $yt_url = "https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$videoID&format=json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $yt_url);
    $response = curl_exec($ch);
    curl_close($ch);

    $yt_data = json_decode($response,true);

    return $yt_data['title'];
}