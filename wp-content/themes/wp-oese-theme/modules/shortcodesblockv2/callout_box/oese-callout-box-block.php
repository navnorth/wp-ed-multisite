<?php
/**
 * Plugin Name:       OESE Callout Box Block
 * Description:       Add OESE Callout Box Block
 * Requires at least: 5.7.2
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oese-callout-box-block
 *
 * @package           oese-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
/*
function oese_block_oese_callout_box_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'oese_block_oese_callout_box_block_block_init' );
*/
		
global $wp_version;
function oese_block_oese_callout_box_block_block_init() {
		//register_block_type( __DIR__ );
		global $wp_version;
		$__oese_isjson = ($wp_version < 5.8)? false: true;
		$__oese_relative_path = (strpos(__DIR__, 'shortcodesblockv2') !== false)? get_stylesheet_directory_uri().'/modules/shortcodesblockv2/callout_box/':plugin_dir_url( __FILE__ );
	  $oese_callout_box_block_json= file_get_contents($__oese_relative_path."/build/block.json");
	  wp_register_script('oese_callout_box_block_js', $__oese_relative_path.'/build/index.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), null, true	);
	  wp_register_style('oese_callout_box_block_editor_css', $__oese_relative_path.'/build/index.css',array( 'wp-edit-blocks' ),null);
	  wp_register_style('oese_callout_box_block_front_css', $__oese_relative_path.'/build/style-index.css',array( 'wp-edit-blocks' ),null);
	  wp_localize_script('oese_callout_box_block_js', 'oese_callout_box_isjson', $__oese_isjson);
	 	register_block_type(
		 	 'oese-block/oese-callout-box-block', array(
			 		 'editor_script' => 'oese_callout_box_block_js',
			 		 'editor_style'  => 'oese_callout_box_block_editor_css',
			 		 'style'         => 'oese_callout_box_block_front_css'
		 	 )
	  );
}
add_action( 'init', 'oese_block_oese_callout_box_block_block_init' );