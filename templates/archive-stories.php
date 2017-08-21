<?php
/**
 * The Template for displaying all single story
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $enable_sidebar;

if (isset($_REQUEST['tax'])){
	add_filter( 'body_class', 'tax_body_class');
	add_filter( 'post_type_archive_title', 'tax_title', 10, 2);
}

function tax_body_class($classes) {
	$classes[] = 'tax-'.$_REQUEST['tax'];
     
	return $classes;
}

function tax_title($post_type_name, $post_type){
	switch ($_REQUEST['tax']){
		case 'program':
			$title = "All Summits";
			break;
		case 'state':
			$title = "All States";
			break;
		case 'grade_level':
			$title = "All School Types";
			break;
		case 'story_tag':
			$title = "All Topics";
			break;
		default:
			$title = "Profiles";
			break;
	}
	return $title;
}

get_header(); ?>

	<div id="content" class="row">
    	<?php
		
		if(isset($_REQUEST['action']) && !empty($_REQUEST['action']))
		{
			global $wpdb;
			if($_REQUEST['action'] == 'showall')
			{
				$postquery = new WP_Query(array('post_type' => 'stories', 'posts_per_page' => -1));

				$post_ids = wp_list_pluck( $postquery->posts, 'ID' );

				$args = array('orderby' => 'term_order','order' => 'ASC','hide_empty' => true);
				$tags = get_terms('story_tag', $args);

				if ( $postquery->have_posts() ) ?>
					<?php if ($enable_sidebar) { ?>
					<div class="col-md-4 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
						 <?php get_stories_side_nav(); ?>
					</div>
					<?php } ?>
					<div class="<?php if ($enable_sidebar) { ?>col-md-8<?php } else { ?>col-md-12<?php } ?> col-sm-12 col-xs-12 pblctn_lft_sid_img_cntnr map_cntnr">
						<div class="col-md-12 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
							 <?php get_storiesmap();?>
						</div>

						<header class="tax-header">
						    <h1 class="tax-title">
							 <?php
								    $post_count = count($post_ids);
								    printf( __( 'Results: %s', SCP_SLUG ), '<i>All Stories</i> <span>(' .$post_count.' '.story_plural($post_count).')</span>' );
							 ?>
						    </h1>
						    <div class="topics-search-box">
							<form method="get">
							    <input type="hidden" name="action" value="showall" />
							    <select name="term" id="showalltopic">
								<option value=""><?php _e( "Filter by Topic", "nn-story-custom-post-type" ); ?></option>
								<?php
								    foreach($tags as $tag)
								    {
									$count = get_counts($tag->term_id,$post_ids);
									if(isset($term) && !empty($term) && $term == $tag->slug):
									    $check='selected="selected"'; else: $check = '';
									endif;
									echo '<option '. $check .' value="'.site_url().'/stories/story_tag/'.$tag->slug.'">'.$tag->name.' ('.$count.')</option>';
								    }
								?>
							    </select>
							</form>
						    <?php get_sort_box($post_ids); ?>
						    </div>
						</header>
						<?php
						//Get number of pages
						$postquery = new WP_Query(array('post_type' => 'stories', 'posts_per_page' => 10));
						$max_page = $postquery->max_num_pages;
		
						$paged = 1;
						if ($_GET['page'])
								$paged = (int)$_GET['page'];
		
						$args = array('post_type' => 'stories', 'posts_per_page' => 10 * $paged);
						
						//Apply sort args
						$args = apply_sort_args($args);
						
						//Reset Post query to show only 10 stories
						$postquery = new WP_Query($args);
		
						echo '<div id="content-stories">';
						//Display initial stories
						while ( $postquery->have_posts() ) : $postquery->the_post();
						    get_story_template_part( 'content', 'substory' );
						endwhile;
						echo '</div>';
		
						//Show load more button
						if ($post_count>10 & $paged<$max_page) {
								$base_url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
								if (strpos($base_url,"page"))
										$base_url = substr($base_url,0,strpos($base_url, "page")-1);
								echo '<div class="col-md-12 pblctn_paramtr padding_left"><a href="&page='.($paged+1).'" data-page-number="'.($paged+1).'" data-page="show_all" data-base-url="'.$base_url.'" data-max-page="'.$max_page.'" class="btn-load-more">Load More</a></div>';
						}
		
						?>
		
								</div>
							<?php
		
						}

				// Story Text-Based Search Result
				if ($_REQUEST['action'] == 'search') {

						extract($_REQUEST);

						if (!empty($search_text)){
								// Search Query
								$args = array(
										'post_type' => 'stories',
										'posts_per_page' => -1,
										's' => $search_text
								);
								$search_query = new WP_Query($args);

								// Meta Query
								$args = array(
										'post_type' => 'stories',
										'posts_per_page' => -1,
										'meta_query' => array(
												'relation' => 'OR',
												array(
													'key'     => 'story_district',
													'value'   => $search_text,
													'compare' => 'LIKE'
												),
												array(
													'key'     => 'story_school',
													'value'   => $search_text,
													'compare' => 'LIKE'
												),
												array(
													'key'     => 'story_mapaddress',
													'value'   => $search_text,
													'compare' => 'LIKE'
												),
												array(
													'key'     => 'story_zipcode',
													'value'   => $search_text,
													'compare' => 'LIKE'
												)
										),
								);
								$meta_query = new WP_Query($args);

								//Tax Query
								$args = array(
										'post_type' => 'stories',
										'posts_per_page' => -1,
										'tax_query' => array(
												'relation' => 'OR',
												array(
													'taxonomy'     => 'program',
													'field'   => 'name',
													'terms' => $search_text
												),
												array(
													'taxonomy'     => 'state',
													'field'   => 'name',
													'terms' => $search_text
												),
												array(
													'taxonomy'     => 'grade_level',
													'field'   => 'name',
													'terms' => $search_text
												),
												array(
													'taxonomy'     => 'characteristics',
													'field'   => 'name',
													'terms' => $search_text
												),
												array(
													'taxonomy'     => 'districtsize',
													'field'   => 'name',
													'terms' => $search_text
												)
										)
								);
								$tax_query = new WP_Query($args);

								$wp_query = new WP_Query();
								$wp_query->posts = array_merge($search_query->posts, $meta_query->posts, $tax_query->posts);

								$post_ids = array();
								foreach( $wp_query->posts as $item ) {
								    $post_ids[] = $item->ID;
								}

								$unique = array_unique($post_ids);

								$args = array(
								    'post_type' => 'stories',
								    'post__in' => $unique,
								    'post_status' => 'publish',
								    'posts_per_page' => -1
								    );

								$stories =  new WP_Query($args);

								if ($stories->have_posts()) {
										?>
										<?php if ($enable_sidebar) { ?>
										<div class="col-md-4 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
												<?php get_stories_side_nav(null, null, $search_text); ?>
										       </div>
										<?php } ?>
										       <div class="<?php if ($enable_sidebar) { ?>col-md-8<?php } else { ?>col-md-12<?php } ?> col-sm-12 col-xs-12 pblctn_lft_sid_img_cntnr map_cntnr">
												<?php get_top_heading(); ?>
											       <div class="col-md-12 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
													<?php get_storiesmap($unique);?>
											       </div>

								   <header class="tax-header">
								       <h1 class="tax-title">
									    <?php
										       $post_count = count($unique);
										       printf( __( 'Search Results: %s', SCP_SLUG ), '<i>' . $search_text . '</i> <span>(' .$post_count.' '.story_plural($post_count).')</span>' );
									    ?>
								       </h1>
								       <?php get_sort_box($unique); ?>
								   </header>
								       <?php
								       //Get number of pages
								       $postquery = new WP_Query(array(
												'post_type' => 'stories',
												'post__in' => $unique,
												'post_status' => 'publish',
												'posts_per_page' => 10
												));
								       $max_page = $postquery->max_num_pages;

								       $paged = 1;
								       if ($_GET['page'])
										       $paged = (int)$_GET['page'];

								$args =	array(
												'post_type' => 'stories',
												'post__in' => $unique,
												'post_status' => 'publish',
												'posts_per_page' => 10 * $paged
												);
								
								//Apply sort args
								$args = apply_sort_args($args);
										       
								       //Reset Post query to show only 10 stories
								       $postquery = new WP_Query($args);

								       echo '<div id="content-stories">';
								       //Display initial stories
								       while ( $postquery->have_posts() ) : $postquery->the_post();
									   get_story_template_part( 'content', 'substory' );
								       endwhile;
								       echo '</div>';

								       //Show load more button
								       if ($post_count>10 & $paged<$max_page) {
										       $base_url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
										       if (strpos($base_url,"page"))
												       $base_url = substr($base_url,0,strpos($base_url, "page")-1);
										       echo '<div class="col-md-12 pblctn_paramtr padding_left"><a href="&page='.($paged+1).'" data-page-number="'.($paged+1).'" data-page="show_all_search" data-base-url="'.$base_url.'" data-max-page="'.$max_page.'" data-posts="'.json_encode($unique).'" class="btn-load-more">Load More</a></div>';
								       }

								       ?>

										       </div>
									       <?php
								}

						}
				}
				/*?>if($_REQUEST['action'] == 'Search')
				{
					extract($_REQUEST);
					$searcharr = array();
					if(!empty($searchtext) || !empty($district_location) || !empty($district_size))
					{
						$s = trim($searchtext, " ");
						if(!empty($district_location))
						{
							foreach($district_location as $location)
							{
								$searchlocation .=  "location.meta_value LIKE '%$location%' OR ";
							}
							$searchlocation = substr($searchlocation, 0, -3);
						}
						else
						{
							$searchlocation .=  "$wpdb->posts.post_content LIKE '%$s%'
											 		OR $wpdb->posts.post_title LIKE '%$s%'";
						}

						if(!empty($district_size))
						{
							foreach($district_size as $size)
							{
								$searchsize .=  "size.meta_value LIKE '%$size%' OR ";
							}
							$searchsize = substr($searchsize, 0, -3);
						}
						else
						{
							$searchsize .=  "$wpdb->posts.post_content LIKE '%$s%'
											 		OR $wpdb->posts.post_title LIKE '%$s%'";
						}

						$querystr = "SELECT ID FROM $wpdb->posts
								 LEFT JOIN $wpdb->postmeta as location
								 ON $wpdb->posts.ID = location.post_id
								 LEFT JOIN $wpdb->postmeta as size
								 ON $wpdb->posts.ID = size.post_id
									WHERE (($searchlocation)
										AND ($searchsize)
										AND ($wpdb->posts.post_content LIKE '%$s%'
											 OR $wpdb->posts.post_title LIKE '%$s%'))
								AND $wpdb->posts.post_type = 'stories'
								AND $wpdb->posts.ID = location.post_id
								AND $wpdb->posts.ID = size.post_id
								ORDER BY $wpdb->posts.post_date DESC";
						$pageposts1 = $wpdb->get_results($querystr, OBJECT_K);
					}

					if(!empty($taxonomy_state))
					{
						$searcharr[] = array('taxonomy' => 'state', 'field' => 'slug', 'terms' => $taxonomy_state,);
					}
					if(!empty($taxonomy_program))
					{
						$searcharr[] = array('taxonomy' => 'program', 'field' => 'slug', 'terms' => $taxonomy_program,);
					}
					if(!empty($taxonomy_grade_level))
					{
						$searcharr[] = array('taxonomy' => 'grade_level', 'field' => 'slug', 'terms' => $taxonomy_grade_level,);
					}
					if(!empty($story_tags))
					{
						$searcharr[] = array('taxonomy' => 'story_tag', 'field' => 'slug', 'terms' => $story_tags,);
					}

					if(!empty($searcharr))
					{
						$args = array('post_type' => 'stories','tax_query' => array('relation' => 'AND',$searcharr),);
						$query = new WP_Query( $args );
						$pageposts2 = $wpdb->get_results($query->request, OBJECT_K);
					}

					if(isset($pageposts1) && isset($pageposts2) )
					{
						if(!empty($pageposts1) && !empty($pageposts2) )
						{
							$pageposts = array_intersect_key($pageposts1, $pageposts2);
						}
						else
						{
							$pageposts = array();
						}
					}
					elseif(isset($pageposts1))
					{
						$pageposts = $pageposts1;
					}
					elseif(isset($pageposts2))
					{
						$pageposts = $pageposts2;
					}

					if(isset($pageposts) && !empty($pageposts))
					{ ?>
                        <div class="col-md-4 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
                        	<?php get_stories_side_nav($searchtext, $taxonomy_state, $taxonomy_program, $taxonomy_grade_level, $district_location, $district_size,$story_tags); ?>
                        </div>

                        <div class="col-md-8 col-sm-12 col-xs-12 pblctn_lft_sid_img_cntnr map_cntnr">
                            <div class="col-md-12 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
                                 <?php get_storiesmap($pageposts);?>
                            </div>
                            <header class="archive-header">
                                <h1 class="archive-title">
                                     <?php printf( __( 'Results %s', 'twentytwelve' ), '<span>(' . count($pageposts).' Stories)</span>' );?>
                                </h1>
                            </header><!-- .archive-header -->

                            <?php
                                foreach($pageposts as $key => $data )
                                {
                                    $post = get_post($key);
                                    setup_postdata($post);
                                    get_story_template_part( 'content', 'substory' );
                                }
                                wp_reset_postdata();
                            ?>
                        </div>
                    <?php
					}
					else
					{
						?>
                        <div class="col-md-4 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
                        <?php get_stories_side_nav($searchtext, $taxonomy_state, $taxonomy_program, $taxonomy_grade_level, $district_location, $district_size,$story_tags); ?>
                        </div>

                        <div class="col-md-8 col-sm-12 col-xs-12 pblctn_lft_sid_img_cntnr map_cntnr">
                            <div class="col-md-12 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
                                 <?php get_storiesmap();?>
                            </div>
                            <header class="archive-header">
                                <h1 class="archive-title">
                                     <?php printf( __( 'Results %s', 'twentytwelve' ), '<span>(0 Stories)</span>' );?>
                                </h1>
                            </header><!-- .archive-header -->
                            <div class="col-md-12 pblctn_paramtr padding_left">
                                <?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.' ); ?>
                            </div>
                        </div>

                        <?php
					}
				}<?php */
			}
			else
			{

                // topics query
                $args = array('post_type' => 'stories','post_status' => 'publish','meta_query' => array(array('key' => 'story_highlight','value' => 'true')));
				$postquery = new WP_Query( $args );
				
				if ( $postquery->have_posts() )
				{ ?>
				<?php if ($enable_sidebar) { ?>
					<div class="col-md-4 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
						 <?php get_stories_side_nav(); ?>
					</div>
				<?php } ?>
				<!-- Slider -->
				<?php if (!isset($_REQUEST['tax'])) { ?>
				<div class="slidermainwrpr scp_slider_content" style="background-image:url('<?php echo SCP_URL; ?>/images/profile-background.jpg');">
					<div class="slidersubwrpr">
					<h1><?php _e('Featured Profiles', SCP_SLUG); ?></h1>
                        		<ul class="bxslider">
						<?php while ( $postquery->have_posts() ) : $postquery->the_post(); ?>
                                    	<li class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="sliderinnrwrap">
                                                <div class="sliderimgwrpr">
                                                    <?php
                                                    $img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                                                    $img_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
                                                    if(isset($img_url) && !empty($img_url))
                                                    {
                                                        echo '<a href="'.get_permalink($post->ID).'"><img src="'.$img_url.'" alt="'.$img_alt. '" /></a>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="slidercontentnrwrpr">
                                                	<!--<div class="sldr_top_hdng"> <?php _e( "Featured Story:", "nn-story-custom-post-type" ); ?> </div>-->
                                                    <h4>
                                                    	<!--<a href="<?php echo get_the_permalink($post->ID); ?>">-->
								<?php echo get_the_title($post->ID); ?>
                                                        <!--</a>-->
                                                    </h4>

                                                    <?php
                                                    $states = get_the_terms( $post->ID, "state" );
                                                    if(isset($states) && !empty($states))
                                                    {
                                                        foreach($states as $state) {
                                                            $state_name = $state->name;
                                                        }
                                                    }
						    
						    $district = get_post_meta($post->ID, "story_district", true);
						    if ($district)
								$district .= ', ';
                                                    ?>

                                                    <h5><?php echo  $district . $state_name ?></h5>
                                                    <p>
                                                       <?php
								echo display_story_content($post->ID);
								?>
                                                    </p>
						    <p><a href="<?php echo get_permalink($post->ID);?>"><?php _e( "Read More &gt;" , "nn-story-custom-post-type" ); ?></a></p>
                                                </div>
                                                <!--<div class="sldr_readmr">
                                                	<a href="<?php echo get_permalink($post->ID);?>"><?php _e( "Read More &gt;" , "nn-story-custom-post-type" ); ?></a>
                                                </div>-->
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                        		</ul>
                    		</div>
                        </div>
			<?php } ?>
				<div class="<?php if ($enable_sidebar) { ?>col-md-8<?php } else { ?>col-md-12<?php } ?> col-sm-12 col-xs-12 pblctn_lft_sid_img_cntnr map_cntnr">
						<?php  if (!isset($_REQUEST['tax']))
								get_top_heading(); ?>
				<?php
				$main_args = array('post_type' => 'stories', 'posts_per_page' => -1);
				$tax_terms = array();
				if ($_REQUEST['tax']){
					$tax_term_objects = get_terms($_REQUEST['tax']);
					
					foreach($tax_term_objects as $tax_term_object){
						$tax_terms[] = $tax_term_object->slug;
					}
					
					$main_args['tax_query'] = array(array( 'taxonomy' => $_REQUEST['tax'], 'field' => 'slug', 'terms' => $tax_terms));
				} 
				$postquery = new WP_Query($main_args);

				$post_ids = wp_list_pluck( $postquery->posts, 'ID' );
				$post_count = count($post_ids);
				$args = array('orderby' => 'term_order','order' => 'ASC','hide_empty' => true);
				$tags = get_terms('story_tag', $args);
				?>
					<div class="col-md-12 col-sm-12 col-xs-12 pblctn_right_sid_mtr">
							 <?php get_storiesmap($post_ids);?>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 profile-filters">
								<?php get_story_filters(); ?>
						 </div>
				<?php
				if ( $postquery->have_posts() ) {
						$max_args = array('post_type' => 'stories', 'posts_per_page' => 6);
						
						if ($_REQUEST['tax']){
							$max_args['tax_query'] = array(array( 'taxonomy' => $_REQUEST['tax'], 'field' => 'slug', 'terms' => $tax_terms));
						}
						
						//Get number of pages
						$postquery = new WP_Query($max_args);
						$max_page = $postquery->max_num_pages;
		
						$paged = 1;
						if ($_GET['page'])
								$paged = (int)$_GET['page'];
		
						$args = array('post_type' => 'stories', 'posts_per_page' => 6 * $paged);
						
						if ($_REQUEST['tax']){
							$args['tax_query'] = array(array( 'taxonomy' => $_REQUEST['tax'], 'field' => 'slug', 'terms' => $tax_terms));
						}
						
						//Apply sort args
						$args = apply_sort_args($args);
						
						//Reset Post query to show only 10 stories
						$postquery = new WP_Query($args);
		
						echo '<div id="content-stories">';
						
						$i = 1;
						//Display initial stories
						while ( $postquery->have_posts() ) : $postquery->the_post();
								if (($i%3)==1)
										echo '<div class="row">';
										
								echo '<div class="col-md-4 col-sm-12 col-xs-12">';
								get_story_template_part( 'content', 'subprofile' );
								echo '</div>';
								
								if (($i%3)==0)
										echo '</div>';
								$i++;
						endwhile;
						echo '</div>';
		
						//Show load more button
						if ($post_count>6 & $paged<$max_page) {
								$base_url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
								if (strpos($base_url,"page"))
										$base_url = substr($base_url,0,strpos($base_url, "page")-1);
								
								$tax_html = "";
								if ($_REQUEST['tax'])
									$tax_html = ' data-taxonomy="'.$_REQUEST['tax'].'"';
								echo '<div class="col-md-12 pblctn_paramtr padding_left"><a href="&page='.($paged+1).'" data-page-number="'.($paged+1).'" data-page="show_all" data-base-url="'.$base_url.'" data-max-page="'.$max_page.'" class="btn-load-more btn-more-profiles"'.$tax_html.'>Load More</a></div>';
						}
				}
		}
}
		?>
		</div>
	</div><!-- #row -->

<?php get_footer(); ?>
