<?php
/**
 * Plugin Name:       Subpages Block
 * Description:       Add Subpages Block
 * Requires at least: 5.7.2
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oese-subpages-block
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
function oese_block_oese_subpages_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'oese_block_oese_subpages_block_block_init' );
*/

global $wp_version;
function oese_block_oese_subpages_block_block_init() {
		global $wp_version;
		$__oese_isjson = ($wp_version < 5.8)? false: true;
		$__oese_relative_path = (strpos(__DIR__, 'shortcodesblockv2') !== false)? get_stylesheet_directory_uri().'/modules/shortcodesblockv2/subpages/':plugin_dir_url( __FILE__ );
	  $oese_subpages_block_json= file_get_contents($__oese_relative_path."/build/block.json");
	  wp_register_script('oese_subpages_block_js', $__oese_relative_path.'/build/index.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), null, true	);
	  wp_register_style('oese_subpages_block_editor_css', $__oese_relative_path.'/build/index.css',array( 'wp-edit-blocks' ),null);
	  wp_register_style('oese_subpages_block_front_css', $__oese_relative_path.'/build/style-index.css',array( 'wp-edit-blocks' ),null);
	  wp_localize_script('oese_subpages_block_js', 'oese_subpages_isjson', $__oese_isjson);
	 	register_block_type(
		 	 'oese-block/oese-subpages-block', array(
			 		 'editor_script' => 'oese_subpages_block_js',
			 		 'editor_style'  => 'oese_subpages_block_editor_css',
			 		 'style'         => 'oese_subpages_block_front_css',
					 //'render_callback' => 'oese_subpages_block_render_func'
		 	 )
	  );
}
add_action( 'init', 'oese_block_oese_subpages_block_block_init' );

function oese_subpages_block_render_func($attributes, $ajx=false){
	$_oese_subpages_block_data = oeseblk_subpages_func_nonapi($attributes['id']);
	//ob_start(); ?>

		<div class="oese-subpages_container">
			<div class="oese-subpages">
				<h4 class="oese-subpages-title"><?php echo $_oese_subpages_block_data['title'] ?></h4>
				<ul class="oese-subpages-list">
					<?php foreach ($_oese_subpages_block_data as $row) { ?>
						<li class="oese-subpages-listitem">
							<a href="<?php echo $row['link'] ?>"><?php echo $row['title'] ?></a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>

	<?php
	//$output = ob_get_clean( );
}


add_action( 'rest_api_init', function () {
	 register_rest_route( 'oese/subpages', 'query', array(
						'methods' => 'GET', 
						'callback' => 'oeseblk_subpages_func',
					 'permission_callback' => '__return_true'
		) );
});

function oeseblk_subpages_func($_param=null){
	$_parent_post_id = sanitize_text_field(trim($_GET['id'])," ");
	return oeseblk_subpages_get_child_pages($_parent_post_id);
}

function oeseblk_subpages_func_nonapi($_param){
	return oeseblk_subpages_get_child_pages($_param);
}

function oeseblk_subpages_get_child_pages($_parent_post_id){
	$_ret = array();
	if(strlen($_parent_post_id) > 0){
		$args = array(
				'post_parent' => $_parent_post_id,
				'post_type'   => 'page',
				'numberposts' => -1,
				'post_status' => 'publish'
		);
		$post_children = get_children( $args );
		$_cntr = 0;
		if ($post_children) {
			foreach ($post_children as $child_page){
				if((string)$_parent_post_id === (string)$child_page->post_parent){
					//$_ret[$_cntr]['parent'] = $_parent_post_id."-".$child_page->post_parent;
					$_ret[$_cntr]['title'] = $child_page->post_title;
					$_ret[$_cntr]['link'] = get_permalink( $child_page->ID );
					$_cntr++;
				}
			}
		}
	}
	return $_ret;
}
