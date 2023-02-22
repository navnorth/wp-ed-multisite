<?php
/**
 * Template Name: ACF Home Page Template
 */
?>

<?php get_header();?>

       
<div id="content" class="row" tabindex="-1">
	<?php
		while ( have_posts() ) : the_post();
      oet_display_acf_home_content();  
		endwhile;
	?>
</div>
<?php get_footer();?>