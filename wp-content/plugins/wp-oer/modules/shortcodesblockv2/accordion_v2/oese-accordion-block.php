<?php
/**
 * Plugin Name:       Accordion Block
 * Description:       Add Accordion Block
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oese-accordion-block
 *
 * @package           oese-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/
 */
global $wp_version;
function oese_block_oese_accordion_block_block_init() {
	register_block_type( __DIR__ );
}

function oese_block_oese_accordion_block_block_init_legacy(){
	$__oese_relative_path = (strpos(__DIR__, 'shortcodesblockv2') !== false)? get_stylesheet_directory_uri().'/modules/shortcodesblockv2/accordion_v2/':plugin_dir_url( __FILE__ );
	$oese_accordion_block_json= file_get_contents($__oese_relative_path."/block.json");
	wp_register_script('oese_accordion_block_js', $__oese_relative_path.'/build/index.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), null, true	);
	wp_register_style('oese_accordion_block_editor_css', $__oese_relative_path.'/build/index.css',array( 'wp-edit-blocks' ),null);
	wp_register_style('oese_accordion_block_front_css', $__oese_relative_path.'/build/style-index.css',array( 'wp-edit-blocks' ),null);
	wp_localize_script('oese_accordion_block_js', 'oese_accordion_legacy_marker', $oese_accordion_block_json);
  register_block_type(
		'cgb/oese-accordion-block', array(
			'editor_script' => 'oese_accordion_block_js',
			'editor_style'  => 'oese_accordion_block_editor_css',
			'style'         => 'oese_accordion_block_front_css'
		)
	);
}

if($wp_version < 5.8){
	add_action( 'init', 'oese_block_oese_accordion_block_block_init_legacy' );
}else{
	add_action( 'init', 'oese_block_oese_accordion_block_block_init' );
}
