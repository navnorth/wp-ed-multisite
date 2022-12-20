<?php
/**
 * Template Name: Publication Template
 */
?>
<?php  get_header(); ?>
 <div id="content" class="row" tabindex="-1">

       <?php
		global $post;
		$alt_text = "";

		$page_id = get_the_ID();

		$publication_date = get_post_meta($post->ID, "publication_date", true);

		$button_one_text = get_post_meta($post->ID, "button_one_text", true);
		$button_one_link = get_post_meta($post->ID, "button_one_link", true);
		$button_one_color = get_post_meta($post->ID, "button_one_color", true);

		$button_two_text = get_post_meta($post->ID, "button_two_text", true);
		$button_two_link = get_post_meta($post->ID, "button_two_link", true);
		$button_two_color = get_post_meta($post->ID, "button_two_color", true);

		$social_status = get_post_meta($post->ID, "social_status", true);

		$image_id = get_post_thumbnail_id( $post->ID );
		
		$image = wp_get_attachment_image_src( $image_id, 'full' );

		/** Get Image Alt **/
		$image_alt = get_post_meta( $image_id, "_wp_attachment_image_alt", true); 
		if (!empty($image_alt))
			$alt_text = "alt='".$image_alt."'";

		// Check if ACF oet_sidebar is set
		$w_sidebar = have_rows('oet_sidebar',$page_id);
		$left_content = "col-md-9 col-sm-12 col-xs-12 ";
		
		if (!$w_sidebar){
			$left_content = "col-md-12 col-sm-12 col-xs-12 ";
		}
	?>

       <div class="<?php echo $left_content; ?>padding_left pblctn_lft_sid_img_cntnr">
	      <h1 class="pblctn_hed"><?php echo $post->post_title;?></h1>
	      <?php if (!empty($publication_date) || !empty($image) || !empty($button_one_text) || (!empty($social_status) && $social_status!=="false") || !empty($button_two_text) ) { ?>
	      <div class="col-md-3 col-sm-3 col-xs-4 padding_left ">
		     <span class="meta_date"><?php echo $publication_date; ?></span>
		     <?php
				if(isset($image) && !empty($image))
				{
            		if(isset($button_one_link) && !empty($button_one_link))
            		{
            			echo '<a href="' . $button_one_link . '" title="Download this Publication" onclick="ga(\'send\', \'event\', \'download\', \'' . $button_one_link . '\');" target="_blank">';
            		}
            		echo '<img '.$alt_text.' src="'. $image[0] .'"/>';
            		if(isset($button_one_link) && !empty($button_one_link))
            		{
            			echo '</a>';
            		}
				}
				echo '<div class="link_dwnlds">';
				if(isset($button_one_text) && !empty($button_one_text) && isset($button_one_link) && !empty($button_one_link) && isset($button_one_color) && !empty($button_one_color))
				{
					?><div><a href="<?php echo $button_one_link; ?>" onclick="ga('send', 'event', 'download', '<?php echo $button_one_link; ?>');" class="btn_dwnld" style="background-color:#<?php echo $button_one_color; ?>" target="_blank"><?php echo $button_one_text; ?></a></div><?php
				}

				if(isset($button_two_text) && !empty($button_two_text) && isset($button_two_link) && !empty($button_two_link) && isset($button_two_color) && !empty($button_two_color))
				{
					?><div><a href="<?php echo $button_two_link; ?>" onclick="ga('send', 'event', 'download', '<?php echo $button_two_link; ?>');" class="btn_dwnld" style="background-color:#<?php echo $button_two_color; ?>" target="_blank"><?php echo $button_two_text; ?></a></div><?php
				}
				echo '</div>';
				if(isset($social_status) && !empty($social_status) && $social_status == 'true')
				{
					echo '<p class="pblctn_scl_icn_hedng"> Share this Report </p>';
					echo '<div class="pblctn_scl_icns">';
								echo do_shortcode("[oet_social]");
					echo '</div>';
				}
		     ?>
	      </div>
	      <?php } ?>
        <?php
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );
			endwhile;
			get_template_part( 'inner-templates/content', 'table' );
		?>
	

       </div>
       <?php  if ($w_sidebar) { echo oet_display_acf_dynamic_sidebar($page_id);  } ?>
</div>
<?php get_footer();?>
