<?php 
/**
 * Shortcode preview callback
 */
function previewshortcode(){
	//echo pull_quotethemefn($_POST);
	//global $wp_embed;
	//$wp_embed->post_ID = $post->ID;
	// [embed] shortcode
	//$wp_embed->run_shortcode( $post->post_content );
	// plain links on their own line
	//$wp_embed->autoembed( $post->post_content );
  ob_start();
	echo do_shortcode($_POST['data']);
  echo ob_get_clean();
	die();
}
add_action( 'wp_ajax_previewshortcode', 'previewshortcode',100 );
add_action('wp_ajax_nopriv_previewshortcode', 'previewshortcode',100);
?>