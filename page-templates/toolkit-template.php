<?php
/**
 * Template Name: Toolkit Template
 */
?>
<?php 
	get_header();
	$page_id = get_the_ID();
?>
 <div id="content" class="row">
	<div class="col-md-9 col-sm-12 padding_left">
    	<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );
			endwhile;
		?>
	</div>
    
    <div class="col-md-3 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
    	<?php echo oer_dynamic_sidebar('toolkit-subpage-template', $page_id);?>
    </div>
    
</div>
<?php get_footer();?>