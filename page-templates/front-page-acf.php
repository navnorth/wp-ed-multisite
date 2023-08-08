<?php
/**
 * Template Name: ACF Home Page Template
 */
?>
<?php get_header();?>
       
<div id="content" class="row" tabindex="-1">
	<?php
		while ( have_posts() ) : the_post();
			//get_template_part( 'content', 'page' );
      /* SLIDER START */
      echo oet_acf_slider_func(get_the_ID());
      /*oet_display_slideshow(get_the_ID());*/
      
      //include(get_stylesheet_directory().'/slider/oet_slider_init.php');
      //echo do_shortcode('[slideshow_deploy id=’5528′]');
      
      
      /* SLIDER END */
      oet_display_acf_home_content();  
		endwhile;
	?>
    <?php if (get_option('disclaimer')): ?>
    <div id="disclaimer_footer"><?php echo get_option('disclaimer'); ?></div>
    <?php endif; ?>
</div>
<?php get_footer();?>