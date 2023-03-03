<?php
/**
 * Template Name: Home Page Template
 */
?>
<?php get_header();?>
       
<div id="content" class="row" tabindex="-1">
	<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content', 'page' );
		endwhile;
	?>
</div>
<?php get_footer();?>