<?php
/**
 * Template Name: General Information Template
 */

get_header();
global $post;
$page_id = get_the_ID();
$head_class = "";
$is_archived = false;
$archived_date = null;
?>

    <!--General Info Top Section START-->
    <div id="content" class="row custom-common-padding general-info-template">
        <div class="col-md-12">
            <?php
            while (have_posts()) : the_post(); get_template_part('content', 'page');
            endwhile;
            ?>

            <?php if( have_rows('general_information_section')): ?>
                <?php while( have_rows('general_information_section')): the_row();

                    //vars
                    $title = get_sub_field('title');
                    //$viewMoreSettings = get_sub_field('view_more_settings');
                    $showViewMore = get_sub_field('include_view_more');
                    $viewMoreURL = get_sub_field('view_more_url');
                    $viewMoreCount = get_sub_field('view_more_count');
                    $tileCount = count(get_sub_field('information_tiles'));
                    ?>

                    <div class="general-info-section mb-5">

                        <?php if($title): ?>
                            <h1 class="mb-5"> <?php echo $title; ?> </h1>
                        <?php endif; ?>

                        <?php if( have_rows('information_tiles')): ?>
                        <div class="row general-info-row">
                            <?php $i = 1; ?>
                            <?php while( have_rows('information_tiles')): the_row();

                            //vars
                            $name = get_sub_field('name');
                            $description = get_sub_field('description');
                            $link = get_sub_field('link');
                            ?>
                            <?php if($i > $viewMoreCount) { break; } ?>
                            <div class="col-md-4 home-col-md-4 pl-0 pr-0 ml-0 mr-0">
                                <div class="general-info-section clearfix mb-5">
                                    <div class="general-info-details rounded">
                                        <h3 class="general-info-details-title mb-4" title="<?php echo $name; ?>">
                                            <?php echo $name; ?>
                                        </h3>
                                        <p class="general-info-details-description">
                                            <?php echo $description; ?>
                                        </p>
                                        <a href="<?php echo $link; ?>" role="button" class="btn oese-btn-danger oese-btn-danger-small" title="Read More">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                            <?php endwhile; ?>
                        </div>
                        <?php endif; ?>

                        <?php if( $showViewMore && !empty($viewMoreURL) && ($tileCount > $viewMoreCount)): ?>
                            <a class="btn oese-btn-view-more float-right" href="<?php echo $viewMoreURL; ?>">View More</a>
                            <div class="clearfix mb-4"></div>
                        <?php endif; ?>

                    </div>


                <?php endwhile; ?>

            <?php endif; ?>

        </div>
    </div>
    <!--General Info Template Top Section END-->


    <!--Div separator-->
    <?php /* ?>
    <div class="row">
        <div class="col-md-12">
            <div class="seperate-dark-blue-border"></div>
        </div>
    </div>
    <?php */ ?>
    <!--Div separator END-->

<?php get_footer(); ?>
