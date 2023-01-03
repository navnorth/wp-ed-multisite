<?php
/**
 * The template for displaying Search Results pages
 *
 * @package wp_oese_theme
 * @since 1.5.0
 */

get_header();
if (is_solr_installed()){
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        if(jQuery(window).width()<800){
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
<div id="content" class="site-content oese-search-content-wrapper">
	<div class="col-md-12">
		<header class="page-header">
			<h1 class="page-title h1-bottom-space"><?php printf( __( 'Search Results', 'twentytwelve' ) ); ?></h1>
		</header>
		<?php do_shortcode('[solr_search_shortcode]'); ?>
	</div>
</div>
<?php
} else {
$results = array();
?>

	<div id="content" class="site-content oese-search-content-wrapper">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 lft_sid_cntnr">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
			</header>

			<?php while ( have_posts() ) :
				the_post(); 
				
				$id = get_the_ID();
				$template = get_page_template_slug($id);
				
				switch ($template){
					case "page-templates/program-template.php":
						$results[] = array('typeId'=>1,'type'=>'Program','post'=>$post, 'child'=>false);
						break;
					case "page-templates/office-template.php":
						$results[] = array('typeId'=>2,'type'=>'Office','post'=>$post, 'child'=>false);
						break;
					default:
						if (has_tag(array("archive","archived"),$post))
							$results[] = array('typeId'=>4,'type'=>'Archives','post'=>$post);
						else
							$results[] = array('typeId'=>3,'type'=>'Other results','post'=>$post, 'child'=>false);
						break;
				}
				
			endwhile;
			
			usort($results, 'compareType');
			
			$current_content_type = "";
			foreach($results as $result){
				if ($current_content_type!==$result['type']){
					$heading_class="";
					if ($result['type']=="archives")
						$heading_class=" archive-heading";
					echo "<h2 class='content-type-heading".$heading_class."'>".ucwords($result['type'])."</h2>";
					$current_content_type = $result['type'];
				}
				
				$post_id = $result['post']->ID;
				
				$current_post = get_post($post_id);
				
				if ($current_post)
					setup_postdata($current_post);
					
				$full_width = true;
				$parent_title = null;
				
				if ($result['child'] && $result['post']->post_parent!==0)
					$parent_title = get_the_title($result['post']->post_parent);
				
				$img_url = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
				$img_alt = get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
				?>
			
				<article id="post-<?php $post_id; ?>" <?php post_class('', $post_id); ?>>
					<header class="search-header">
					<?php if ( is_single() ) : ?>
						<?php if ($parent_title) : ?>
						<h4 class="entry-parent-title"><?php echo $parent_title; ?></h4>
						<?php endif; ?>
						<h3 class="entry-title"><?php  echo get_the_title($post_id); ?></h3>
					<?php else : ?>
						<?php if ($parent_title) : ?>
						<h4 class="entry-parent-title">
							<?php echo $parent_title; ?>
						</h4>
						<?php endif; ?>
						<h3 class="entry-title">
						    <a href="<?php echo get_the_permalink($post_id); ?>" rel="bookmark"><?php echo get_the_title($post_id); ?></a>
						</h3>
					<?php endif; // is_single() ?>
					</header><!-- .entry-header -->
					<?php if(isset($img_url) && !empty($img_url)) : ?>
					<div class="col-md-3 col-sm-6 col-xs-12 archive_image">
					    <img class="search_story_featured_image" src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>" />
					</div>
					<?php endif; ?>
					<?php if ( is_search() ) : // Only display Excerpts for Search
					if (isset($img_url) && !empty($img_url)):
					?>
					<div class="col-md-9 col-sm-6 col-xs-12 search-summary">
					<?php else: ?>
					<div class="search-summary">
					<?php endif; ?>
						<?php
						if (strlen(get_the_excerpt($current_post))>0) {
							echo get_the_excerpt($current_post);
						} else {
							echo get_excerpt_by_id($post_id);
						}
						?>
					</div><!-- .entry-summary -->
					<?php else : ?>
					<div class="search-content">
					    <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
					    <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
					<?php endif; ?>
				</article>
				<?php
			}
			 else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
					</header>
	
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
						<?php //get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
			<?php
			//Pagination Links
			global $wp_query;

			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages
			) );
			?>
		</div>
	</div><!-- .row -->

<?php
}
get_footer(); ?>
