<?php
/**
 * Template Name: Full-width Page Template, No Sidebar
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package wp_oese_theme
 * @since 1.5.0
 */

get_header();
global $post;

$head_class = "";
$is_archived = false;
$archived_date = null;

if (get_field('archive_date'))
    $archived_date = get_field('archive_date');
    
if ($archived_date){
    $is_archived = true;
    $head_class = " archived-header";
}
?>

<div id="content" class="row site-content">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <h1 class="page_header<?php echo $head_class; ?>"><?php echo $post->post_title; ?></h1>
        
        <?php if ($is_archived): ?>
        <div class="oese-archived-disclaimer">
                <?php _e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page was archived on '.$archived_date.' but still has content that may be valuable to some people.', WP_OESE_THEME_SLUG); ?>
        </div>
        <?php endif; ?>
        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('content', 'page'); ?>

        <?php endwhile; ?>

    </div>
</div>

<?php get_footer(); ?>
