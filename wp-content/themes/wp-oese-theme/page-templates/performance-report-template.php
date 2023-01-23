<?php
/**
 * Template Name: State Performance Report
 */
?>
<?php
include_once( get_stylesheet_directory()."/classes/oese_mobile_detect.php" );

get_header();
$col_class = "col-md-12";
$head_class = "";
$is_archived = false;
$archived_date = null;
$search_class = "";

if( have_rows('sidebar_links') )
    $col_class = "col-md-8";

if (get_field('archive_date'))
    $archived_date = get_field('archive_date');
    
if ($archived_date){
    $is_archived = true;
    $head_class = " archived-header";
}
if (is_solr_installed()){ 
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        if(jQuery(window).width()<800){
            if (jQuery('.wdm_results').length) {
                var temp = jQuery('.wdm_results .res_info');
                jQuery('.cls_results').before(temp);
                jQuery('.wdm_results .res_info').remove();
                
                jQuery('div.wpsolr_facet_title').attr('data-toggle','collapse');
                jQuery('.wpsolr_facet_checkbox.wpsolr_facet_categories, .wpsolr_facet_checkbox.wpsolr_facet__wp_page_template_str').addClass("collapse");
                jQuery('div.wpsolr_facet_title.wpsolr_facet_categories').attr('data-target','.wpsolr_facet_checkbox.wpsolr_facet_categories');
                jQuery('div.wpsolr_facet_title.wpsolr_facet__wp_page_template_str').attr('data-target','.wpsolr_facet_checkbox.wpsolr_facet__wp_page_template_str');
                jQuery('.wpsolr_facet_checkbox.wpsolr_facet_categories, .wpsolr_facet_checkbox.wpsolr_facet__wp_page_template_str').collapse({
                    toggle:false
                });
            }
        }
    });
</script>
<style>
    #res_facets ul::-webkit-scrollbar {
        -webkit-appearance: none;
    }
    #res_facets ul::-webkit-scrollbar:vertical {
        width:16px;
    }
    #res_facets ul::-webkit-scrollbar:horizontal {
        height:16px;
    }
    #res_facets ul::-webkit-scrollbar-thumb {
        background-color: #1f5c99;
        border-top: 1px solid #f2f2f2;
        border-bottom: 1px solid #f2f2f2;
    }
    #res_facets ul::-webkit-scrollbar-track {
        background-color:#f2f2f2;
        border-left:1px solid #1f5c99;
        box-shadow: inset 0 0 1px #1f5c99;
    }
    #res_facets ul::-webkit-scrollbar-button:single-button{
        background-color:#f2f2f2;
        display:block;
        border-style:solid;
        height:13px;
        width:15px;
    }
    #res_facets ul::-webkit-scrollbar-button:single-button:vertical:decrement {
        border-width: 0 8px 8px 8px;
        border-color: transparent transparent #1f5c99 transparent;
    }
    #res_facets ul::-webkit-scrollbar-button:single-button:vertical:decrement:hover {
        border-color: transparent transparent #555555 transparent;
    }
    #res_facets ul::-webkit-scrollbar-button:single-button:vertical:increment {
        border-width: 8px 8px 0 8px;
        border-color: #1f5c99 transparent transparent transparent;
    }
    #res_facets ul::-webkit-scrollbar-button:single-button:vertical:increment:hover {
        border-color: #555555 transparent transparent transparent;
    }
</style>
<?php
}
?>

        <div id="content" class="row custom-common-padding mr-0 ml-0 default-template template-mobile">

            <div class="<?php echo $col_class; ?>">    
                <h1 class="h1-bottom-space<?php echo $head_class; ?>"><?php echo $post->post_title; ?></h1>
                        <?php if ($is_archived): ?>
		                          <div class="oese-archived-disclaimer">
			                             <?php //_e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page was archived on '.$archived_date.' but still has content that may be valuable to some people.', WP_OESE_THEME_SLUG); ?>
		                               ARCHIVED INFORMATION
                              </div>
		                     <?php endif; ?>
                         <?php while (have_posts()) : the_post(); ?>
                              <?php get_template_part('content', 'page'); ?>
                         <?php endwhile; ?>
                
                    </div>
                    
                    
                    
                    <div class="col-md-12">
                      <p>&nbsp;</p>
                      <?php 
                      $_state = $_GET['state'];
                      echo do_shortcode( "[wpdatatable id=2 var1='".$_state."']");
                      ?>
                      <p>&nbsp;</p>
                      <a href="http://oese.localhost.localdomain/office-state-support-map/"></a>
                    </div>
           
            <?php get_sidebar(); ?>

        </div>
    

<?php get_footer(); ?>
