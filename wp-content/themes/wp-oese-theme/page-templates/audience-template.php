<?php
/**
 * Template Name: Audience Template
 */

get_header();
global $post;
$page_id = get_the_ID();
$archived_date = null;
$leftCol = "col-md-12";
$rightCol = "col-md-right";
$is_archived = false;
if (get_field('archive_date'))
    $archived_date = get_field('archive_date');
    
if ($archived_date){
    $is_archived = true;
    $head_class = " archived-header";
}

if( have_rows('sidebar_links') ){
    $leftCol = "col-md-8";
    $rightCol = "col-md-4";
}
?>


        <!--Audience Page Custom Design -- START-->

        <!--Families section START-->
        <div id="content" class="row custom-common-padding audience-template">
            <div class="<?php echo $leftCol; ?>">
                
                <?php
                    if ( has_post_thumbnail() ) {
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id($page_id), 'single-post-thumbnail' );
                        $img_alt = get_post_meta(get_post_thumbnail_id($page_id), '_wp_attachment_image_alt', true);
                        
                        echo "<div class='left-section-featured-image'>
                                <img src='".$image[0]."' alt='".$img_alt."'></div>";
                    }

                ?>
                <div class="left-description-section">
                   <h1><?php echo get_the_title(); ?></h1>
                   <?php if ($is_archived): ?>
               		    <div class="oese-archived-disclaimer">
               			      <?php //_e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page was archived on '.$archived_date.' but still has content that may be valuable to some people.', WP_OESE_THEME_SLUG); ?>
               		        ARCHIVED INFORMATION  
                   </div>
               		<?php endif; ?>
                   <?php
                     while (have_posts()) : the_post(); get_template_part('content', 'page');
                     endwhile;
                   ?>
                </div>
            </div>
            <div class="<?php echo $rightCol; ?>">
                <?php
                if (have_rows('sidebar_links'))
                    getSidebarLinks();
                ?>
            </div>
        </div>
        <!--Families section END-->

        <!--Div seperator-->
        <div class="row">
            <div class="col-md-12">
                <div class="seperate-dark-blue-border"></div>
            </div>
        </div>
        <!--Div seperator END-->

        <!--Post in grids section START-->
        <div class="row custom-common-padding gray-background-color mr-0 ml-0">
                <?php
                if( have_rows('categories') ):
                    while ( have_rows('categories') ) : the_row();
                        $cImage =  get_sub_field('c_image');
                        $cTitle =  get_sub_field('c_title');
                        $cLink =  get_sub_field('link');
                        $externaLink =  get_sub_field('c_external_link');
                        $target = ($externaLink ? "_blank" : "_self");
                ?>
            <div class="col-xl-4 col-lg-4 col-md-6 custom-col-md-4-padding custom-col-md-4-margin custom-grid-mobile-margin-top">
                <div class="custom-image-main-section">
                    <div class="custom-image-media">
                       <a target="<?php echo $target; ?>" href="<?php echo $cLink; ?>">
                            <div class="custom-image-thumbnail">
                                <div>
                                    <img src="<?php echo $cImage; ?>" alt="<?php echo $cTitle; ?>" class="img-responsive img-thumbnail-square">
                                </div>
                            </div>
                            <div class="custom-image-heading text-center">
                                <p><?php echo $cTitle; ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
           <?php
                endwhile;

                else :

                endif;

            ?>
        </div>
        <!--Post in grids section START-->

        <!--Div seperator START-->
        <div class="row">
            <div class="col-md-12">
                <div class="seperate-dark-blue-border"></div>
            </div>
        </div>
        <!--Div seperator END-->

        <!--Full width Search Section START-->
        <div class="row custom-common-padding">
            <div class="full-search-section m-auto text-center">
                <div class="full-search-heading">
                    <h2>What can we help you find?</h2>
                </div>

                <div class="full-search-field">
                     <?php
                     // Call Custom Search Form
                     add_filter('get_search_form', 'oese_content_search_form');
                     get_search_form();
                     remove_filter('get_search_form', 'oese_content_search_form');
                     ?>
                </div>
            </div>
        </div>
        <!--Full width Search Section END-->

        <!--Audience Page Custom Design -- END-->



<?php get_footer(); ?>
