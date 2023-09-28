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
	<?php if (get_option('disclaimer')): ?>
    <div id="disclaimer_footer"><?php echo get_option('disclaimer'); ?></div>
    <?php endif; ?>
</div>
<?php get_footer();?>