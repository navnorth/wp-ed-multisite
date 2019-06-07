<?php
/**
 * Template Name: Awards template, full-width - no sidebar
 */


global $post;

$page_id = get_the_ID();
$img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$img_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);

get_header();

$head_class = "";
$is_archived = false;

if (has_tag(array("archive","archived"),$post)){
    $is_archived = true;
    $head_class = " archived-header";
}
?>

    <div id="content" class="row site-content" tabindex="-1">

        <div class="col-md-12 col-sm-12 col-xs-12 padding_left padding_right">

            <?php
                if(isset($img_url) && !empty($img_url))
                {
                    echo '<div class="program_header_image"><img src="'. $img_url .'" alt="'.$img_alt. '" /></div>';
                }
            ?>

            <h1 class="program_header<?php echo $head_class; ?>"><?php echo $post->post_title;?></h1>
            
            <?php if ($is_archived): ?>
            <div class="oese-archived-disclaimer">
                    <?php _e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page has been archived but still has content that may be valuable to some people.', WP_OESE_THEME_SLUG); ?>
            </div>
            <?php endif; ?>
        
            <?php while ( have_posts() ) : the_post(); ?>
                <?php
                    get_template_part( 'content', 'resources' );
                    get_template_part( 'content', 'page' );
                ?>
            <?php endwhile; ?>
         </div>

    </div>

<?php get_footer(); ?>
