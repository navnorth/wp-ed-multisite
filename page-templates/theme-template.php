<?php
/**
 * Template Name: Thematic Template
 *
 * Description: Main program "thematic" pages for OII - Innovation, Arts, Charters, etc.
 * Mainly making a separate template because Theme pages may have images while Programs may not
 *
 */

global $post;

$page_id = get_the_ID();
$img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$img_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);

get_header();

$contact_content = get_post_meta($post->ID,'_contact_box',true);
$leftCol = "col-md-12 col-sm-12 col-xs-12";
$rightCol = "col-md-right";

if ((strlen($contact_content)>0) || (is_active_sidebar( 'thematic-template' ) ) ){
    $leftCol = "col-md-9 col-sm-8 col-xs-12";
    $rightCol = "col-md-3 col-sm-4 col-xs-12";
}
?>

    <div id="content" class="row site-content">

        <div class="<?php echo $leftCol; ?> padding_left lft_sid_cntnr">

            <?php
                if(isset($img_url) && !empty($img_url))
                {
                    echo '<div class="thematic_header_image"><img src="'. $img_url .'" alt="'.$img_alt. '" /></div>';
                }
            ?>

            <h1 class="thematic_header"><?php echo $post->post_title;?></h1>

            <?php while ( have_posts() ) : the_post(); ?>
                <?php
                    get_template_part( 'content', 'page' );
                ?>
            <?php endwhile; ?>
         </div>

        <div class="<?php echo $rightCol; ?> right_sid_mtr">
            <?php
                dynamic_sidebar('thematic-template');
                get_template_part( 'content', 'contact' );
            ?>
        </div>

    </div>

<?php get_footer(); ?>
