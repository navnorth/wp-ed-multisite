<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php global $post; ?>
<?php
	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

?>
<div class="col-md-12 pblctn_paramtr padding_left">
    <h3>
        <a href="<?php echo get_permalink($post->ID); ?>">
            <?php echo get_the_title($post->ID); ?>
        </a>
    </h3>
    <?php if(isset($url) && !empty($url)) : ?>
        <div class="gat_feature_image">
            <img class="featured_image" src="<?php echo $url; ?>" alt="<?php echo get_the_title($post->ID); ?>" />
        </div>
    <?php endif; ?>
    <p>
        <?php
		    $content = get_the_content($post->ID);
		    echo substr($content, 0, 300).'...';
        ?>
    </p>
</div>
