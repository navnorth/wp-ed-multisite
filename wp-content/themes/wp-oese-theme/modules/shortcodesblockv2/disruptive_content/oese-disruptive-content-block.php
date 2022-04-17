<?php
/**
 * Plugin Name:       Disruptive Content
 * Description:       Add disruptive content block
 * Requires at least: 5.7.2
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oese-disruptive-content-block
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
function oese_block_oese_disruptive_content_block_block_init() {
	register_block_type( __DIR__ );
}

function oese_block_oese_disruptive_content_block_block_init_legacy(){
 $__oese_relative_path = (strpos(__DIR__, 'shortcodesblockv2') !== false)? get_stylesheet_directory_uri().'/modules/shortcodesblockv2/disruptive_content/':plugin_dir_url( __FILE__ );
 $oese_disruptive_content_block_json= file_get_contents($__oese_relative_path."/block.json");
 wp_register_script('oese_disruptive_content_block_js', $__oese_relative_path.'/build/index.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), null, true	);
 wp_register_style('oese_disruptive_content_block_editor_css', $__oese_relative_path.'/build/index.css',array( 'wp-edit-blocks' ),null);
 wp_register_style('oese_disruptive_content_block_front_css', $__oese_relative_path.'/build/style-index.css',array( 'wp-edit-blocks' ),null);
 wp_localize_script('oese_disruptive_content_block_js', 'oese_disruptive_content_legacy_marker', $oese_disruptive_content_block_json);
	register_block_type(
	 'oese-block/oese-disruptive-content-block', array(
		 'editor_script' => 'oese_disruptive_content_block_js',
		 'editor_style'  => 'oese_disruptive_content_block_editor_css',
		 'style'         => 'oese_disruptive_content_block_front_css'
	 )
 );
}

if($wp_version < 5.8){
 add_action( 'init', 'oese_block_oese_disruptive_content_block_block_init_legacy' );
 add_action( 'admin_head' , 'oese_disruptive_content_loadconditional_toolbar_css_legacy' );
}else{
 add_action( 'init', 'oese_block_oese_disruptive_content_block_block_init' );
 add_action( 'admin_head' , 'oese_disruptive_content_loadconditional_toolbar_css' );
}


function oese_disruptive_content_block_backend_script(){
 $__oese_relative_path = (strpos(__DIR__, 'shortcodesblockv2') !== false)? get_stylesheet_directory_uri().'/modules/shortcodesblockv2/disruptive_content/':plugin_dir_url( __FILE__ );
 wp_enqueue_script('oese_disruptive_content_block-backend-js', $__oese_relative_path.'/backend.js',array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'jquery' ), '1.0' );
}
add_action( 'enqueue_block_editor_assets', 'oese_disruptive_content_block_backend_script' );






function oese_disruptive_content_loadconditional_toolbar_css_legacy(){
	ob_start();
	?>
		<style>
		/* core/heading - Disable Everythig */
		.block-editor__container.oese-disruptive-content-title-toolbar-hide .edit-post-visual-editor .popover-slot {display:none !important;} 
		/* core/paragraph - Disable switcher/reposition and options menu */
		.block-editor__container.oese-disruptive-content-description-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(1),
		.block-editor__container.oese-disruptive-content-description-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4) {display:none !important;}
		/* core/button - Disable everything except the link */
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(1),
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2)>div:nth-of-type(1),
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(3),
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4) {display:none !important;}
		</style>
	<?php
	echo ob_get_clean();
}


function oese_disruptive_content_loadconditional_toolbar_css(){
	ob_start();
	?>
		<style>
		/* core/heading - Disable Everything */
		.block-editor__container.oese-disruptive-content-title-toolbar-hide .edit-post-visual-editor .components-popover__content {display:none !important;} 
		/* core/paragraph - Disable switcher/reposition and options menu */
		.block-editor__container.oese-disruptive-content-description-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(1),
		.block-editor__container.oese-disruptive-content-description-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2),
		.block-editor__container.oese-disruptive-content-description-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(5) {display:none !important;}
		/* core/button - Disable everything except the link */
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(1),
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(2),
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(3)>div>div>button:nth-of-type(1),
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(4),
		.block-editor__container.oese-disruptive-content-button-toolbar-hide .edit-post-visual-editor .block-editor-block-toolbar>div:nth-of-type(5) {display:none !important;}
		</style>
	<?php
	echo ob_get_clean();
}

