<?php
/**
 * Template Name: Publication Subsection Template
 */
?>
<?php get_header();?>
 <div id="content" class="row site-content" tabindex="-1">

	<?php
		global $post;
		$page_id = get_the_ID();
	?>

	<div class="col-md-12 c ol-sm-12 col-xs-12 padding_left padding_right">
    	<h1 class="pblctn_hed"><?php echo $post->post_title;?></h1>

        <?php
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );
			endwhile;
			get_template_part( 'inner-templates/content', 'table' );
		?>
	</div>

</div>
<?php get_footer();?>
