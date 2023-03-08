<?php
/**
 * The Template for displaying all single story
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header(); ?>

	<div class="row">
    	<?php
			// topics query
			$postquery = new WP_Query(array('post_type' => 'assessment', 'postperpage' => -1));
			if ( $postquery->have_posts() ) ?>
				<div class="col-md-12 col-sm-12 col-xs-12 pblctn_lft_sid_img_cntnr map_cntnr">
					<?php while ( $postquery->have_posts() ) : $postquery->the_post(); ?>
							<?php get_assessment_template_part( 'content', 'subassessment' ); ?>
					<?php endwhile; ?>
				</div>
			<?php
		?>

	</div><!-- #row -->

<?php get_footer(); ?>
