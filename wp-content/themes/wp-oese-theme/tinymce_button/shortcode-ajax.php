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
  $_shtcd = $_POST['data'];
  if(strpos($_POST['data'], 'single_expand') !== false){
    $_shtcd_a = strpos($_shtcd,'single_expand');
    $_len = strpos($_shtcd,']') - $_shtcd_a;
    $_substr = str_replace(array('\'', '"', '\\'), '', substr($_shtcd,$_shtcd_a,$_len));
    $_arr = explode("=",$_substr);
    if(isset($_arr[1]) && !empty($_arr[1])){
      $_shtcd = str_replace("[oese_accordion ","[oese_accordion single_expand=\\'".$_arr[1]."\\' ",$_shtcd);
    }
  }
	echo do_shortcode($_shtcd);
  echo ob_get_clean();
	die();
}
add_action( 'wp_ajax_previewshortcode', 'previewshortcode',100 );
add_action('wp_ajax_nopriv_previewshortcode', 'previewshortcode',100);
?>