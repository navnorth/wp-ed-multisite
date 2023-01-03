<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header();
global $post;
$page_id = get_the_ID();

// Check if ACF oet_sidebar is set
$w_sidebar = have_rows('oet_sidebar',$page_id);
$left_content = "col-md-9 col-sm-12 col-xs-12 ";
if (!$w_sidebar){
	$left_content = "col-md-12 col-sm-12 col-xs-12 ";
}
?>

	<div id="content" class="row site-content" tabindex="-1">

        <div class="<?php echo $left_content; ?>padding_left pblctn_lft_sid_img_cntnr">
        	<h1 class="pblctn_head"><?php echo $post->post_title;?></h2>
		<?php if (has_tag(array("archive","archived"),$post)): ?>
		<div class="archived-disclaimer">
			<?php _e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page has been archived but still has content that may be valuable to some people.', 'twentytwelve'); ?>
		</div>
		<?php endif; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
		<?php
		//checks if parent page uses publication template then load TOC
		$parent_id = $post->post_parent;
		$template = get_post_meta($parent_id, '_wp_page_template', true);
                if ($template == "page-templates/publication-template.php") {
			echo "<div class='clearfix default-toc col-md-12'>";
			get_template_part( 'inner-templates/content', 'table' );
			echo "</div>";
		}
		?>
         </div>
        <?php  if ($w_sidebar) {
			echo oet_display_acf_dynamic_sidebar($page_id);
		 } ?>
    </div>

<?php get_footer(); ?>
