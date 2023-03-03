<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 * 
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $post;
$post_id = get_queried_object_id();
?>
<?php if( have_rows('sidebar_links', $post_id) ) : ?>
    <div class="col-md-4">
        <div id="secondary" class="widget-area" role="complementary">
            <?php
            if (have_rows('sidebar_links'))
                getSidebarLinks();
            ?>
        </div><!-- #secondary -->
    </div>
<?php endif; ?>