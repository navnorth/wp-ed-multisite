<?php
/**
 * Plugin Name:       OET Featured Item Block
 * Description:       Featured Item Block for OET
 * Requires at least: 5.7.2
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oet-featured-item-block
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
 
 global $wp_version;
 function oet_blocks_oet_featured_item_block_block_init() {
 	register_block_type( __DIR__ );
 }
 
 function oet_blocks_oet_featured_item_block_block_init_legacy(){
 	$__oet_relative_path = (strpos(__DIR__, 'blocks') !== false)? get_stylesheet_directory_uri().'/blocks/oet-featured-item-block/':plugin_dir_url( __FILE__ );
 	$oet_featured_item_block_json= file_get_contents($__oet_relative_path."/block.json");
 	wp_register_script('oet_featured_item_block_js', $__oet_relative_path.'/build/index.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), null, true	);
 	wp_register_style('oet_featured_item_block_editor_css', $__oet_relative_path.'/build/index.css',array( 'wp-edit-blocks' ),null);
 	wp_register_style('oet_featured_item_block_front_css', $__oet_relative_path.'/build/style-index.css',array( 'wp-edit-blocks' ),null);
  //wp_register_script('oet_featured_item_block-backend-js', $__oet_relative_path.'/backend.js',array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'jquery' ), null, true );
  wp_localize_script('oet_featured_item_block_js', 'oet_featured_item_legacy_marker', $oet_featured_item_block_json);
   register_block_type(
 		'oet-block/oet-featured-item-block', array(
 			'editor_script' => 'oet_featured_item_block_js',
 			'editor_style'  => 'oet_featured_item_block_editor_css',
 			'style'         => 'oet_featured_item_block_front_css'
 		)
 	);
 }

 if($wp_version < 5.8){
  add_action( 'admin_head' , 'oet_featured_item_loadconditional_toolbar_css_legacy' );
 	add_action( 'init', 'oet_blocks_oet_featured_item_block_block_init_legacy' );
 }else{
  add_action( 'admin_head' , 'oet_featured_item_loadconditional_toolbar_css' );
 	add_action( 'init', 'oet_blocks_oet_featured_item_block_block_init' );
 }

function oet_featured_item_block_backend_script(){
 $__oet_relative_path = (strpos(__DIR__, 'blocks') !== false)? get_stylesheet_directory_uri().'/blocks/oet-featured-item-block/':plugin_dir_url( __FILE__ );
 wp_enqueue_script('oet_featured_item_block-backend-js', $__oet_relative_path.'/backend.js',array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'jquery' ), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'oet_featured_item_block_backend_script' );


function oet_featured_item_loadconditional_toolbar_css_legacy(){
	ob_start();
	?>
		<style>
		/* core/heading - Disable Everythig */
		/* .block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .popover-slot {display:none !important;} */
    .block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2),
		.block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(3),
		.block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4) {display:none !important;}

		/* core/paragraph - Disable switcher/reposition and options menu */
		.block-editor__container.oet-featured-item-content-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4) {display:none !important;}
    
		/* core/button - Disable everything except the link */
    .block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(1),
		.block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2)>div:nth-of-type(1),
		.block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(3),
		.block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4) {display:none !important;}
		</style>
	<?php
	echo ob_get_clean();
}


function oet_featured_item_loadconditional_toolbar_css(){
	ob_start();
	?>
		<style>
		/* core/heading - Disable Everything */
 /* .block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .components-popover__content {display:none !important;} */
    .block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2),
		.block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(3),
		.block-editor__container.oet-featured-item-title-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4) {display:none !important;}
    
		/* core/paragraph - Disable switcher/reposition and options menu */
		.block-editor__container.oet-featured-item-content-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2),
		.block-editor__container.oet-featured-item-content-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(5) {display:none !important;}
		/* core/button - Disable everything except the link */
    .block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(1),
		.block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2),
		.block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(3)>div>div>button:nth-of-type(1),
		.block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4),
		.block-editor__container.oet-featured-item-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(5) {display:none !important;}
		</style>
	<?php
	echo ob_get_clean();
}

