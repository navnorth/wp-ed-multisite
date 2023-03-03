<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php 
	$content = get_the_content();
	remove_filter( 'the_content', 'wpautop' );
	add_filter( 'the_content', 'wpse_wpautop_nobr' );
	$content = apply_filters('the_content', $content);
	$content = str_replace( "<br>","", $content );
	echo do_shortcode($content);
?>
		