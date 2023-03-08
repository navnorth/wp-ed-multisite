<?php
/**
 * Template Name: Program Template
 */
include_once( get_stylesheet_directory()."/classes/oese_mobile_detect.php" );

global $post;

$page_id = get_the_ID();
get_header();

$head_class = "";
$extra_class = "";
$is_archived = false;
$archived_date = null;
$leftCol = "col-md-8";
$rightCol = "col-md-4";

if (get_field('archive_date'))
    $archived_date = get_field('archive_date');
    
if ($archived_date){
    $is_archived = true;
    $head_class = " archived-header";
}

$detect = new oese_mobile_detect();
if ($detect->isMobile())
    $extra_class = " template-mobile";
?>
<script type="text/javascript">
    function close_tab(close_button){
        curtab = jQuery(close_button).closest('.tab-pane.active');
        curtabid = curtab.attr('id');
        curtab.removeClass('active');
        jQuery('#mobileSidebarTab a[href="#' + curtabid +'"]').removeClass('active');
    }
</script>
           <!--Program Landing Template Top Section START-->
        <div id="content" class="row custom-common-padding program-template<?php echo $extra_class; ?>">
            <div class="<?php echo $leftCol; ?>">
                <div class="left-description-section">
                    <h1 class="h1-bottom-space<?php echo $head_class; ?>"><?php echo get_the_title(); ?></h1>
                    <?php if ($is_archived): ?>
                    <div class="oese-archived-disclaimer">
                            <?php //_e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page was archived on '.$archived_date.' but still has content that may be valuable to some people.', WP_OESE_THEME_SLUG); ?>
                            ARCHIVED INFORMATION
                    </div>
                    <?php endif; ?>
                     <?php
                        if ( has_post_thumbnail() ) {
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id($page_id), 'single-post-thumbnail' );
                            $img_alt = get_post_meta(get_post_thumbnail_id($page_id), '_wp_attachment_image_alt', true);
                            
                            echo "<div class='left-section-featured-image'>
                                    <img src='".$image[0]."' alt='".$img_alt."'></div>";
                        }
                    ?>
                    <!--Program Blocks START-->
                    <?php  if( have_rows('program_info') ): ?>
                        <div class="program-block-section table-responsive">
                            <table class="gray-background-color program-block-inner-section table">
                                <caption class="hidden">Program Information</caption>
                                <tr class="hidden">
                                    <td scope="col"><?php _e("Program Title", WP_OESE_THEME_SLUG); ?></td>
                                    <td scope="col"><?php _e("Program Description", WP_OESE_THEME_SLUG); ?></td>
                                </tr>
                                <?php
                                    while ( have_rows('program_info') ) : the_row();
                                      $programLabel =  get_sub_field('program_title');
                                      $programDescription =  get_sub_field('program_description');
                                ?>
                                <tr class="row program-list-detail">
                                    <td class="col-md-5">
                                        <label class="program-block-title"><?php echo $programLabel;?></label>
                                    </td>
                                    <td class="col-md-7">
                                        <p class="program-block-description"><?php echo $programDescription;?></p>
                                    </td>
                                </tr>
                             <?php endwhile; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                    <!--Program Blocks END-->
                    <?php if( get_field('program_short_description') ): ?>
                        <p class="">
                            <?php echo  the_field("program_short_description") ?>
                        </p>
                    <?php endif; ?>
                    <?php
                         while (have_posts()) : the_post(); get_template_part('content', 'page');
                        endwhile;
                    ?>
                </div>
            </div>
            <?php
            if ($detect->isMobile()){
                $li_class = "";
                $contact = get_field('ci_address');
                $sidebar_links = have_rows('sidebar_links');
                if ($contact && $sidebar_links)
                    $li_class = " half";
                elseif ($contact || $sidebar_links)
                    $li_class = " full";
                
                if ($contact || $sidebar_links){
                ?>
                <div class="col-sm-12 program-sidebar">
                    <?php get_template_part( 'content', 'resources' ); ?>
                    <div class="spacer" style="height:20px;"></div>
                    <ul class="nav nav-tabs" id="mobileSidebarTab" role="tablist">
                        <?php
                        $contactTitle = get_field("ci_title");
                        if ($contactTitle):
                        ?>
                        <li class="nav-item<?php echo $li_class; ?>">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true"><?php echo $contactTitle; ?></a>
                        </li>
                        <?php
                        endif;
                        if( have_rows('sidebar_links') ):
                            $sidebar_title = get_field('sidebar_box_title');
                            if ($sidebar_title):
                            ?>
                            <li class="nav-item<?php echo $li_class; ?>">
                                <a class="nav-link" id="menu-tab" data-toggle="tab" href="#menu" role="tab" aria-controls="menu" aria-selected="false"><?php echo $sidebar_title; ?></a>
                            </li>
                            <?php endif;
                        endif;
                        ?>
                    </ul>
                    <div class="tab-content" id="mobileSidebarTabContent">
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <?php echo contactInformationBlock(false) ?>
                            <div class="tab-close-row"><button class="tab-close-button" id="sidebarContactBtn" onclick="close_tab(this);" data-role="button" role="button"><i class="fas fa-times"></i> CLOSE</button></div>
                        </div>
                        <?php if( have_rows('sidebar_links') ): ?>
                        <div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                            <div class="sidebar-menu">
                            <?php echo getSidebarLinks(false); ?>
                            </div>
                            <div class="col-sm-12 tab-close-row"><button class="tab-close-button" onclick="close_tab(this);" data-role="button" role="button"><i class="fas fa-times"></i> CLOSE</button></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                }else{
                  ?>
                  <div class="<?php echo $rightCol; ?> program-sidebar">
                      <?php echo contactInformationBlock() ?>

                      <div class="spacer" style="height:20px;"></div>

                      <?php get_template_part( 'content', 'resources' ); ?>

                      <?php
                      if (have_rows('sidebar_links'))
                          getSidebarLinks();
                      ?>
                      
                  </div>
                  <?php
                }
            } else {
            ?>
            <div class="<?php echo $rightCol; ?> program-sidebar">
                <?php echo contactInformationBlock() ?>

                <div class="spacer" style="height:20px;"></div>

                <?php get_template_part( 'content', 'resources' ); ?>

                <?php
                if (have_rows('sidebar_links'))
                    getSidebarLinks();
                ?>
                
            </div>
            <?php } ?>
        </div>
        <!--Program Landing Template Top Section END-->

        <!--Div seperator-->
        <?php /* ?>
        <div class="row mr-0 ml-0">
            <div class="col-md-12 pr-0 pl-0">
                <div class="seperate-dark-blue-border"></div>
            </div>
        </div>
        <?php */ ?>
        <!--Div seperator END-->


        <!--Payments Section START-->

        <?php getTileLinks(); ?>

        <!--Payments Section END-->

<?php get_footer(); ?>
