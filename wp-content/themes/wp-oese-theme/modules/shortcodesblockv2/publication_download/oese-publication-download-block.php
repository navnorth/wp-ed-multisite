<?php
/**
 * Plugin Name:       Publication Download
 * Description:       Add Publication Download Block
 * Requires at least: 5.7.2
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       oese-publication-download-block
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
function oese_block_oese_publication_download_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'oese_block_oese_publication_download_block_block_init' );
*/

global $wp_version;
function oese_block_oese_publication_download_block_block_init() {
		//register_block_type( __DIR__ );
		global $wp_version;
		$__oese_isjson = ($wp_version < 5.8)? false: true;
		$__oese_relative_path = (strpos(__DIR__, 'shortcodesblockv2') !== false)? get_stylesheet_directory_uri().'/modules/shortcodesblockv2/publication_download/':plugin_dir_url( __FILE__ );
	  $oese_publication_download_block_json= file_get_contents($__oese_relative_path."/build/block.json");
	  wp_register_script('oese_publication_download_block_js', $__oese_relative_path.'/build/index.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), null, true	);
	  wp_register_style('oese_publication_download_block_editor_css', $__oese_relative_path.'/build/index.css',array( 'wp-edit-blocks' ),null);
	  wp_register_style('oese_publication_download_block_front_css', $__oese_relative_path.'/build/style-index.css',array( 'wp-edit-blocks' ),null);
	  wp_localize_script('oese_publication_download_block_js', 'oese_publication_download_isjson', $__oese_isjson);
	 	register_block_type(
		 	 'oese-block/oese-publication-download-block', array(
			 		 'editor_script' => 'oese_publication_download_block_js',
			 		 'editor_style'  => 'oese_publication_download_block_editor_css',
			 		 'style'         => 'oese_publication_download_block_front_css'
		 	 )
	  );
}
add_action( 'init', 'oese_block_oese_publication_download_block_block_init' );




add_action( 'rest_api_init', function () {
	 register_rest_route( 'oese/publication-download', 'query', array(
						'methods' => 'GET', 
						'callback' => 'oeseblk_publication_download_func',
					 'permission_callback' => '__return_true'
		) );
});


function oeseblk_publication_download_func(){
	$_url = sanitize_text_field($_GET['url']);
	$_ret = array();

	if ($_url)
		$pub_id = oese_file_id_by_url($_url);
		
	if ($pub_id>0){
		$pub_details = wp_prepare_attachment_for_js($pub_id);
	}
	
	if ($pub_details>0){
		$_ret['status'] = true;
		$_ret['filesize'] = $pub_details['filesizeHumanReadable'];
		$_ret['title'] = $pub_details['title'];
		$extension = pathinfo($pub_details['filename'], PATHINFO_EXTENSION);
		$_ret['icon'] = oese_publication_download_type_from_url($_url, 'fa-3x');
		//$_ret['filetype'] = strtoupper($pub_details['subtype']);
		$_ret['filetype'] = strtoupper($extension);
	}else{
		$_ret['status'] = false;
	}
	return $_ret;
}

function oese_publication_download_type_from_url($url) {
  if(empty($url)) {
    return false;
  }

  $response = array();
  $oese_urls = explode('.', $url);
  $file_type = strtolower(end($oese_urls));
  if(in_array($file_type, ['jpg', 'jpeg', 'gif', 'png'])) {
    $response['title'] = 'Image';
    $response['icon'] = 'fa-file-image';
  } elseif($file_type == 'pdf') {
    $response['title'] = 'PDF';
    $response['icon'] = 'fa-file-pdf';
  } elseif(in_array($file_type, ['txt'])) {
    $response['title'] = 'Plain Text';
    $response['icon'] = 'fa-file-alt';
  } elseif(in_array($file_type, ['7z', 'zip', 'rar'])) {
    $response['title'] = 'Archive';
    $response['icon'] = 'fa-file-archive';
  } elseif(in_array($file_type, ['docx', 'doc'])) {
    $response['title'] = 'Microsoft Document';
    $response['icon'] = 'fa-file-word';
  } elseif(in_array($file_type, ['xlsx', 'xls', 'csv'])) {
    $response['title'] = 'Microsoft Excel';
    $response['icon'] = 'fa-file-excel';
  } elseif(in_array($file_type, ['pptx', 'ppt'])) {
    $response['title'] = 'Microsoft Powerpoint';
    $response['icon'] = 'fa-file-powerpoint';
  } elseif(in_array($file_type, ['wav', 'mp3'])) {
    $response['title'] = 'Audio';
    $response['icon'] = 'fa-file-audio';
  } elseif(in_array($file_type, ['mp4'])) {
    $response['title'] = 'Video';
    $response['icon'] = 'fa-file-video';
  }
  return $response;
}
