<?php
/**
 * Template Name: Toolkit Template
 */
?>
<?php 
	get_header();
	$page_id = get_the_ID();
	
	// Check if ACF oet_sidebar is set
	$w_sidebar = have_rows('oet_sidebar',$page_id);
?>
 
<div id="content" class="row" tabindex="-1">
	<?php if (!$w_sidebar){ ?>
 		<div class="col-md-12 col-sm-12 col-xs-12 padding_left padding_right tlkt_stp_cntnr_lft_sid">
 	<?php }else{ ?>
 		<div class="col-md-9 col-sm-12 col-xs-12 padding_left tlkt_stp_cntnr_lft_sid">
 	<?php } 
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );
			endwhile;
		?>
	</div>
	<?php /* ?>
  <div class="col-md-3 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
  		<?php echo oer_dynamic_sidebar('toolkit-subpage-template', $page_id);?>
  </div>
	<?php */ ?>
	<?php  if ($w_sidebar) { echo oet_display_acf_dynamic_sidebar($page_id);  } ?>
</div>
<?php get_footer();?>