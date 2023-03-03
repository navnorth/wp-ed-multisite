<?php
/**
 * Template Name: Awards template
 */


global $post;

$page_id = get_the_ID();
$img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$img_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);

get_header();

$head_class = "";
$is_archived = false;
$archived_date = null;
$leftCol = "col-md-8";
$rightCol = "col-md-4";
$wChild = false;

if (get_field('archive_date'))
    $archived_date = get_field('archive_date');
    
if ($archived_date){
    $is_archived = true;
    $head_class = " archived-header";
}

$spages = get_pages( array( 'parent' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'asc' ) );
if (!empty($spages)){
    $wChild = true;
} else {
	$parent_id = $post->post_parent;
	if ($parent_id>0)
		$wChild = true;
}
if (!$wChild){
    $leftCol = "col-md-12";
    $rightCol = "";
}
?>

    <div id="content" class="row site-content awards-template">
        <div class="<?php echo $leftCol; ?> col-sm-12 col-xs-12">

            <?php
                if(isset($img_url) && !empty($img_url))
                {
                    echo '<div class="program_header_image"><img src="'. $img_url .'" alt="'.$img_alt. '" /></div>';
                }
            ?>

            <h1 class="program_header<?php echo $head_class; ?>"><?php echo $post->post_title;?></h1>
            
            <?php if ($is_archived): ?>
                <div class="oese-archived-disclaimer">
                        <?php //_e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page was archived on '.$archived_date.' but still has content that may be valuable to some people.', WP_OESE_THEME_SLUG); ?>
                        ARCHIVED INFORMATION 
                </div>
            <?php endif; ?>
        
            <?php while ( have_posts() ) : the_post(); ?>
                <?php
                    get_template_part( 'content', 'page' );
                ?>
            <?php endwhile; ?>
         </div>
        <div class="<?php echo $rightCol; ?> mb-5 pl-0">  
            <?php get_template_part( 'content', 'resources' ); ?>
        </div>
    </div>

<?php get_footer(); ?>
