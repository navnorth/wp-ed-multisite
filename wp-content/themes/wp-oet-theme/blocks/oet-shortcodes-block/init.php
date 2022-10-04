<?php
/**
 * Plugin Name:     WP Oet Shortcodes Block
 * Description:     Example block written with ESNext standard and JSX support – build step required.
 * Version:         0.1.0
 * Author:          The WordPress Contributors
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     wp-oet-shortcodes-block
 *
 * @package         create-block
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function create_block_oet_shortcodes_block_init() {
	$dir = dirname( __FILE__ );
	$dir_url = get_stylesheet_directory_uri().'/blocks/oet-shortcodes-block/';

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "create-block/wp-oet-shortcodes-block" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'create-block-oet-shortcodes-block-editor',
		$dir_url.$index_js,
		$script_asset['dependencies'],
		$script_asset['version']
	);
	wp_localize_script( 'create-block-oet-shortcodes-block-editor', 'wp_oet_shortcode', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_set_script_translations( 'create-block-oet-shortcodes-block-editor', 'wp-oet-shortcodes-block' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'create-block-oet-shortcodes-block-editor',
		$dir_url.$editor_css,
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'create-block-oet-shortcodes-block',
		$dir_url.$style_css,
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'create-block/wp-oet-shortcodes-block', array(
		'editor_script' => 'create-block-oet-shortcodes-block-editor',
		'editor_style'  => 'create-block-oet-shortcodes-block-editor',
		'style'         => 'create-block-oet-shortcodes-block',
		'render_callback' => 'oet_display_shortcode'
	) );
}
add_action( 'init', 'create_block_oet_shortcodes_block_init' );


function oet_display_shortcode( $attributes, $ajax = false ){
	$html = "";
	$block_class = "";
	if (!empty($attributes))
		extract($attributes);
	
	if (isset($displayflex) && $displayflex)
		$block_class = " flx";
	$html = "<div class='oet-shortcode".$block_class."'>";
	if (isset($shortcodeText)){
		$html .= do_shortcode($shortcodeText);
	}
	$html .= "</div>";
	
	return $html;
}

function wp_oer_ajax_display_shortcode_text(){
	$shortcode = oet_display_shortcode($_POST, true);
	echo $shortcode;
	die();
}
add_action( 'wp_ajax_display_shortcode_text', 'wp_oer_ajax_display_shortcode_text' );
add_action( 'wp_ajax_nopriv_display_shortcode_text', 'wp_oer_ajax_display_shortcode_text' );