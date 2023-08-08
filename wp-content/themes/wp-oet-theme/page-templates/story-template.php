<?php
/**
 * Template Name: Story Template
 */
?>
<?php get_header();?>
 <div id="content" class="row" tabindex="-1">

	<?php
		global $post;
		$page_id = get_the_ID();

		$box_one_header = get_post_meta($post->ID, "box_one_header", true);
        $box_one_text = get_post_meta($post->ID, "box_one_text", true);

        $box_two_header = get_post_meta($post->ID, "box_two_header", true);
        $box_two_text = get_post_meta($post->ID, "box_two_text", true);

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	?>

	<div class="col-md-8 col-sm-12 col-xs-12 padding_left pblctn_lft_sid_img_cntnr">
    	<h1 class="pblctn_hed"><?php echo $post->post_title;?></h1>
        <span class="meta_date"><a href="/stories">Back to Stories</a></span>


        <!--
        <div class="col-md-3 col-sm-3 col-xs-4 padding_left ">
            float left  image and buttons from Pub template
    	</div>
        -->

        <?php
			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );
			endwhile;
		?>
	</div>

    <div class="col-md-4 col-sm-12 col-xs-12 pblctn_right_sid_mtr">

        <p class="story_scl_icn_hedng">Share this Story</p>
        <div class="story_scl_icns"><?php if (shortcode_exists('oet_social')) echo do_shortcode("[oet_social]"); ?></div>

        <?php

            if(isset($image) && !empty($image))
            {
                echo '<div><img src="'. $image[0] .'"/></div>';
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


            if( (isset($box_one_header) && !empty($box_one_header)) || (isset($box_one_text) && !empty($box_one_text)) )
            {
                ?><div class="col-md-12 col-sm-6 col-xs-6">

                    <div class="pblctn_box">
                        <span class="socl_icns fa-stack"><i class="fa fa-star "></i></span>
                    </div>
                    <p class="rght_sid_wdgt_hedng"><?php echo $box_one_header; ?></p>

                    <?php echo $box_one_text; ?>
                </div>
                <?php
            }

            if( (isset($box_two_header) && !empty($box_two_header)) || (isset($box_two_text) && !empty($box_two_text)) )
            {
                ?><div class="col-md-12 col-sm-6 col-xs-6">

                    <div class="pblctn_box">
                        <span class="socl_icns fa-stack"><i class="fa fa-star "></i></span>
                    </div>
                    <p class="rght_sid_wdgt_hedng"><?php echo $box_two_header; ?></p>

                    <?php echo $box_two_text; ?>
                </div>
                <?php
            }

        ?>

    </div>
    <?php if (get_option('disclaimer')): ?>
    <div id="disclaimer_footer"><?php echo get_option('disclaimer'); ?></div>
    <?php endif; ?>
</div>
<?php get_footer();?>
