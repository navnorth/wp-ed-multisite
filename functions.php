<?php
add_action( 'admin_enqueue_scripts', 'gat_back_enqueue_script' );
function gat_back_enqueue_script()
{
	wp_enqueue_style( 'gat_back_style', plugin_dir_url( __FILE__ ).'css/gat_back.css' );
	wp_enqueue_script( 'gat_editor-js', plugin_dir_url( __FILE__ ).'js/tinymce.min.js' );
	wp_enqueue_script( 'gat_back_script', plugin_dir_url( __FILE__ ).'js/gat_back.js' );
}

add_action( 'wp_enqueue_scripts', 'gat_front_enqueue_script' );
function gat_front_enqueue_script()
{
	wp_enqueue_style( 'gat_front_style', plugin_dir_url( __FILE__ ).'css/gat_front.css' );
	wp_enqueue_style( 'gat_front_style', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );
	wp_enqueue_script( 'gat_front_script', plugin_dir_url( __FILE__ ).'js/gat_front.js' );
}

add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl()
{?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
    <script>
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '260',
          width: '420',
          videoId: 'M7lc1UVf-VE',
          events: {
            'onReady': onPlayerReady
          }
        });
      }
      function onPlayerReady(event) {
        event.target.playVideo();
      }
    </script>
<?php
}
add_action('admin_footer', 'gat_post_validation');
function gat_post_validation()
{
	global $post;
	if ($post->post_type != 'domain')
	{
		 return;
	}
	echo '<script>
		 jQuery( "form#post #publish" ).hide();
 		 jQuery( "form#post #publish" ).after("<input type=\'button\' value=\'Publish\' class=\'sb_publish button-primary\' /><span class=\'sb_js_errors\'></span>");
		 jQuery( ".sb_publish" ).click(function()
		 {
			var error = true;
			var i = 1;
			var length = jQuery(".gat_editablediv").length;
			jQuery(".gat_editablediv").each(function() {
				var value = jQuery(this).html();
				jQuery(this).prev("textarea.gat_editabletextarea").text(value);
				
				if(i == length)
				{
					error = false;
				}
				i++
			});
			if (!error)
			{
			 	jQuery( "form#post #publish" ).click();
			}
		 });
	</script>';
}
add_action("init", "gap_init_function");
function gap_init_function()
{
	$post_types = array("Assessment"=>"Assessments", "Domain"=>"Domains", 'Rating' => 'ratings');
	
	foreach($post_types as $key => $posttype)
	{
		if($key == 'Rating')
		{
			$support = array( 'title', 'editor' );
		}
		else
		{
			$support = array( 'title', 'editor', 'thumbnail' );
		}
		$labels = array(
			'name'               => _x( $posttype, 'post type general name', PLUGIN_DOMAIN ),
			'singular_name'      => _x( $key, 'post type singular name', PLUGIN_DOMAIN ),
			'menu_name'          => _x( $posttype, 'admin menu', PLUGIN_DOMAIN ),
			'name_admin_bar'     => _x( $key, 'add new on admin bar', PLUGIN_DOMAIN ),
			'add_new'            => _x( 'Add New', strtolower($key), PLUGIN_DOMAIN ),
			'add_new_item'       => __( 'Add New '.$key, PLUGIN_DOMAIN ),
			'new_item'           => __( 'New '.$key, PLUGIN_DOMAIN ),
			'edit_item'          => __( 'Edit '.$key, PLUGIN_DOMAIN ),
			'view_item'          => __( 'View '.$key, PLUGIN_DOMAIN ),
			'all_items'          => __( 'All '.$posttype, PLUGIN_DOMAIN ),
			'search_items'       => __( 'Search '.$posttype, PLUGIN_DOMAIN ),
			'parent_item_colon'  => __( 'Parent '.$posttype.':', PLUGIN_DOMAIN ),
			'not_found'          => __( 'No '.strtolower($posttype).' found.', PLUGIN_DOMAIN ),
			'not_found_in_trash' => __( 'No '.strtolower($posttype).' found in Trash.', PLUGIN_DOMAIN )
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => strtolower($key) ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => $support,
			'register_meta_box_cb' => strtolower($key)."_metabox_func"
		);
		register_post_type( strtolower($key), $args );
	}
	$labels = array(
		'name'                       => _x( 'Tags', 'taxonomy general name' ),
		'singular_name'              => _x( 'Tag', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Tags' ),
		'popular_items'              => __( 'Popular Tags' ),
		'all_items'                  => __( 'All Tags' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Tag' ),
		'update_item'                => __( 'Update Tag' ),
		'add_new_item'               => __( 'Add New Tag' ),
		'new_item_name'              => __( 'New Tag Name' ),
		'separate_items_with_commas' => __( 'Separate tags with commas' ),
		'add_or_remove_items'        => __( 'Add or remove tags' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags' ),
		'not_found'                  => __( 'No tags found.' ),
		'menu_name'                  => __( 'Tags' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'tag' ),
	);

	register_taxonomy( 'tag', array('assessment', 'domain'), $args );
	
	$labels = array(
		'name'                       => _x( 'Scales', 'taxonomy general name' ),
		'singular_name'              => _x( 'Scale', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Scales' ),
		'popular_items'              => __( 'Popular Scales' ),
		'all_items'                  => __( 'All Scales' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Scale' ),
		'update_item'                => __( 'Update Scale' ),
		'add_new_item'               => __( 'Add New Scale' ),
		'new_item_name'              => __( 'New Scale Name' ),
		'separate_items_with_commas' => __( 'Separate scales with commas' ),
		'add_or_remove_items'        => __( 'Add or remove scales' ),
		'choose_from_most_used'      => __( 'Choose from the most used scales' ),
		'not_found'                  => __( 'No scales found.' ),
		'menu_name'                  => __( 'Scales' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'scale' ),
	);

	register_taxonomy( 'scale', array('rating'), $args );	
}

add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page()
{
	add_menu_page( 'Gap Assessment', 'Gap Assessment', 'edit_private_pages', 'edit.php?post_type=assessment', '', 'dashicons-editor-help', 4 );
	add_submenu_page( 'edit.php?post_type=assessment' , 'Assessment', 'Assessment', 'edit_private_pages', 'edit.php?post_type=assessment' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'Rating Systems' , 'Rating Systems' , 'edit_private_pages' , 'edit.php?post_type=rating' , '' );
    add_submenu_page( 'edit.php?post_type=assessment' , 'Reporting' , 'Reporting' , 'edit_private_pages' , 'reporting' , 'show_reports' );
    add_submenu_page( 'edit.php?post_type=assessment' , 'Settings' , 'Settings' , 'edit_private_pages' , 'settings' , 'import_organizations' );
	
	add_submenu_page( 'edit.php?post_type=assessment' , 'add assessment', 'add assessment', 'edit_private_pages', 'post-new.php?post_type=assessment' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'add domain', 'add domain', 'edit_private_pages', 'post-new.php?post_type=domain' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'add rating', 'add rating', 'edit_private_pages', 'post-new.php?post_type=rating' );
}

add_action('before_delete_post', 'delete_post_metadata_function');
function delete_post_metadata_function($postid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$videotable = PLUGIN_PREFIX . "videos";
	$domainids = get_domainid_by_assementid($postid);
	foreach($domainids as $domainid)
	{
		wp_delete_post($domainid);
	}
	$wpdb->query("DELETE a,b 
		FROM $dimensiontable AS a 
		INNER JOIN $videotable AS b ON a.id = b.dimensions_id 
		WHERE a.assessment_id = $postid");
}

add_action("admin_init", "wpse_60168_var_dump_and_die");
function wpse_60168_var_dump_and_die() 
{
    global $menu,$submenu;
	if(!empty($menu))
	{
		foreach( $menu as $key => $value )
		{
			if( 'Gap Assessment' == $value[0] )
				$menu[$key][4] .= " gap_analysis_tool";
		}
	}
}
add_action('init', 'GAT_setcookie');
function GAT_setcookie()
{
	if(isset($_COOKIE['GAT_token']) && !empty($_COOKIE['GAT_token']))
	{
		//
    }
	else
	{
		$token = generateRandomString(8);
		$path = parse_url(get_option('siteurl'), PHP_URL_PATH);
		$host = parse_url(get_option('siteurl'), PHP_URL_HOST);
		setcookie("GAT_token", $token, time() + 2678400, $path, $host);
	}
}

//Fatch data functions
/*This function get dimentions data on metboxs*/
function get_dimensions_data($postid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$videotable = PLUGIN_PREFIX . "videos";
	$datas = $wpdb->get_results("select * from $dimensiontable where domain_id=$postid");
	if(isset($datas) && !empty($datas))
	{
		$i = 1;
		foreach($datas as $data)
		{
			if($i == 1)
			{
				$order = '<a href="javascript:" class="order_anch" data-order="up" onclick="orderchange(this)"></a>
						  <a href="javascript:" class="order_anch down" data-order="down" onclick="orderchange(this)"></a>';
			}
			elseif($i == count($datas))
			{
				$order = '<a href="javascript:" class="order_anch up" data-order="up" onclick="orderchange(this)"></a>
						  <a href="javascript:" class="order_anch" data-order="down" onclick="orderchange(this)"></a>';
			}
			else
			{
				$order = '<a href="javascript:" class="order_anch up" data-order="up" onclick="orderchange(this)"></a>
						  <a href="javascript:" class="order_anch down" data-order="down" onclick="orderchange(this)"></a>';
			}
			$title = stripslashes($data->title);
			$description = stripslashes($data->description);
	?>
    	<div class="gat_dimention_wrpr">
        	<div class="gat_cntrlr_wrpr">
            	<span class="count"><?php echo $i; ?>.</span>
                <div class="action">
                	<a href="javascript:" onclick="delete_dimension(this)" class="button button-primary">Delete</a>
                </div>
                <div class="order">
                	<?php echo $order; ?>
                </div>
            </div>
            <div class="gat_inside_wrpr">
            	<div class="gat_fldwrpr">
                	<input type="hidden" name="dimension_id[]" value="<?php echo $data->id; ?>" />
                	<input type="text" name="dimension_title[]" autocomplete="off" spellcheck="true" value="<?php echo $title; ?>" class="wp_title" />
                </div>
                <div class="gat_fldwrpr">
                 	<textarea rows="1" name="dimension_content[]" class="gat_editabletextarea" style="display: none"></textarea>
                    <div class="gat_editablediv" onclick="initareaodoo();">
						<?php echo $description; ?>
                    </div>
                </div>
                <div class="gat_fldwrpr">
                	<div class="gat_fldtopwrpr">
                    	<label>Associated Videos : </label>
                        <p><a href="javascript:" onclick="add_video(this)" class="button button-primary" data-count="<?php echo $i; ?>" >Add +</a></p>
                    </div>
                    <div class="gat_fldinsidewrpr">
                    	<table class="wp-list-table widefat fixed gat_table">
                        	<thead>
                            	<tr>
                                	<th>Label</th>
                                    <th>YouTube Id</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            	$videos = $wpdb->get_results("select * from $videotable where dimensions_id=$data->id");
								$j = 0;
								foreach($videos as $video)
								{
									$rating_scale = unserialize($video->rating_scale);
									if(isset($rating_scale) && !empty($rating_scale))
									{
										
									}
									else
									{
										$rating_scale = array();
									}
									?>
                                    	<tr>
                                        	<td>
                                            	<input type="text" name="dimension_<?php echo $i; ?>_videolabel[]" value="<?php echo $video->label; ?>" />
                                            </td>
                                            <td>
                                            	<input type="text" name="dimension_<?php echo $i; ?>_videoid[]" value="<?php echo $video->youtubeid; ?>" />
                                            </td>
                                            <td>
                                            	<?php if(in_array(1,$rating_scale)){ $ck1 = 'checked="checked"'; }else{ $ck1 = ''; }?>
                                            	<input type="checkbox" name="dimension_<?php echo $i; ?>_ratingscale<?php echo $j; ?>[]" value="1" <?php echo $ck1; ?> />
                                            </td>
                                            <td>
                                            	<?php if(in_array(2,$rating_scale)){ $ck2 = 'checked="checked"'; }else{ $ck2 = ''; }?>
                                            	<input type="checkbox" name="dimension_<?php echo $i; ?>_ratingscale<?php echo $j; ?>[]" value="2" <?php echo $ck2; ?> />
                                            </td>
                                            <td>
                                            	<?php if(in_array(3,$rating_scale)){ $ck3 = 'checked="checked"'; }else{ $ck3 = ''; }?>
                                            	<input type="checkbox" name="dimension_<?php echo $i; ?>_ratingscale<?php echo $j; ?>[]" value="3" <?php echo $ck3; ?> />
                                            </td>
                                            <td>
                                            	<?php if(in_array(4,$rating_scale)){ $ck4 = 'checked="checked"'; }else{ $ck4 = ''; }?>
                                            	<input type="checkbox" name="dimension_<?php echo $i; ?>_ratingscale<?php echo $j; ?>[]" value="4" <?php echo $ck4; ?> />
                                            </td>
                                            <td>
                                            	<a href="javascript:" onclick="delete_video(this)" class="button button-primary">Delete</a>
                                            </td>
                                         </tr>
                                    <?php
									$j++;
								}
							?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
			$i++;
		}
	}
}
/*This function generates token*/
function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/*This function get parent assessment id by child domain id*/
function get_assessmentid_by_domainid($postid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$data = $wpdb->get_row("select assessment_id from $dimensiontable where domain_id=$postid");
	if(isset($data) && !empty($data))
	{
		return $data->assessment_id;
	}
	else
	{
		return  '0';
	}
}
/*This function get all child domains id from parent assessment id*/
function get_domainid_by_assementid($postid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$data = $wpdb->get_results("select domain_id from $dimensiontable where assessment_id=$postid", OBJECT_K);
	if(isset($data) && !empty($data))
	{
		$domainid = array_keys($data);
		return $domainid;
	}
	else
	{
		return  array();
	}
}
/*This function get dimentions count for domain id*/
function get_dimensioncount($domainid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$data = $wpdb->get_results( "SELECT COUNT(*) FROM $dimensiontable where domain_id=$domainid", OBJECT_K );
	$data = array_keys($data);
	return  $data[0];
}
/*This function get video count for domain id*/
function get_videocount($domainid)
{
	global $wpdb;
	$videotable = PLUGIN_PREFIX . "videos";
	$data = $wpdb->get_results( "SELECT COUNT(*) FROM $videotable where domain_id=$domainid", OBJECT_K  );
	$data = array_keys($data);
	return  $data[0];
}
/*This function get all dimension data by domain id*/
function get_alldimension_domainid($domainid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$data = $wpdb->get_results( "SELECT * FROM $dimensiontable where domain_id=$domainid");
	if(isset($data) && !empty($data))
	{
		return $data;
	}
	else
	{
		return array();
	}
}
/*This function check token is exist or not*/
function check_token_exists($assessment_id, $token, $value = NULL)
{
	global $wpdb;
	$response_table = PLUGIN_PREFIX . "response";
	$data = $wpdb->get_row("select * from $response_table where assessment_id=$assessment_id AND token='$token'");
	if(isset($data) && !empty($data))
	{
		if(!empty($value) && $value == 'id')
		{
			return $data->id;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}
function progress_indicator_sidebar($assessment_id, $token)
{
	global $wpdb;
	$response_table = PLUGIN_PREFIX . "response";
	$data = $wpdb->get_row("select * from $response_table where assessment_id=$assessment_id AND token='$token'");
	if(!empty($data->email))
	{
		$email = explode("@", $data->email);
		for($i=0; $i < strlen($email[0]); $i++)
		{
			if($i != 0)
			{
				$email[0][$i] = '*';
			}
		}
		$email = $email[0].'@'.$email[1];
	}
	else
	{
		$email = '<a href="'. get_permalink().'?action=start-analysis">Set Your Email</a>';
	}
	
	echo '<div class="gat_indicatorwidget">
			<div class="meter">
			  <span style="width: '.$data->progress.'%">'.$data->progress.'%</span>
		  	</div>
			<div>
				<span><b>Token : </b></span>
				'.$token.'
			</div>
			<div>
				<span><b>Email : </b></span>
				'.$email.'
			</div>
			<div>
				<span><b>Last Saved : </b></span>
				'.$data->last_saved.'
			</div>
		  </div>';
}
function get_rating_scale($cat)
{
	global $wpdb;
	$posts = $wpdb->prefix.'posts';
	$postmeta = $wpdb->prefix.'postmeta';
	$args = array('post_type' => 'rating','tax_query' =>  array('taxonomy' => 'scale', 'field' => 'name', 'terms' => $cat), 'fields' => 'ids');
	$ratings = get_posts($args);
	if(!empty($ratings))
	{
		$ratings = implode(",", $ratings);
		$order_rating = $wpdb->get_results("select * from $posts AS a LEFT JOIN $postmeta as b ON a.ID = b.post_id where a.post_status = 'publish' && b.meta_key = 'rating_order' && b.post_id IN ($ratings) ORDER BY b.meta_value ASC");
		return $order_rating;
	}
	else
	{
		return array();
	}
}
function gat_save_domaindata($post)
{
	global $wpdb;
	$response_table = PLUGIN_PREFIX . "response";
	$results_table = PLUGIN_PREFIX . "results";
	extract($post);
	if(is_array($dimension_id))
	{
		for($i=0; $i < count($dimension_id); $i++)
		{
			$dimensionid = $dimension_id[$i];
			$rating = ${'rating_' . $dimensionid};
			$filtered = array_filter($rating, 'filter_callback');
			if(!empty($filtered))
			{
				$rating = array_values($filtered);
			}
			$wpdb->query("delete from $results_table where dimension_id = $dimensionid && token = '$token'");
			$wpdb->query("INSERT INTO $results_table (assessment_id, domain_id, dimension_id, token, rating_scale) VALUES ($assessment_id, $domain_id, $dimensionid, '$token', '$rating[0]')");
		}
	}
	$progress = gat_progress_totle($assessment_id, $token);
	$overallscore = gat_overall_score($assessment_id, $token);
	$wpdb->query("UPDATE $response_table SET progress='$progress', overall_score='$overallscore', last_saved=now() where assessment_id = $assessment_id && token = '$token'");
	return true;
}
function filter_callback($val)
{
	$val = trim($val);
	return $val != '';
}
function gat_progress_totle($assessment_id, $token)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";
	
	$data = $wpdb->get_results( "SELECT COUNT(*) FROM $dimensiontable where assessment_id=$assessment_id", OBJECT_K );
	$data = array_keys($data);
	$total_dimension = $data[0];
	
	$data = $wpdb->get_results( "SELECT count(*) AS cnt FROM $results_table WHERE assessment_id =$assessment_id && token='$token' &&( rating_scale != NULL
OR rating_scale != '' )", OBJECT_K );
	$data = array_keys($data);
	$total_rated = $data[0];
	
	$progress = ($total_rated/$total_dimension)*100;
	return $progress;
}
function gat_overall_score($assessment_id, $token)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";
	
	$data = $wpdb->get_results("SELECT count(*) AS cnt FROM $results_table WHERE assessment_id =$assessment_id && token='$token' &&( rating_scale != NULL
OR rating_scale != '' )", OBJECT_K );
	$data = array_keys($data);
	$total_dimension = $data[0];
	
	$data = $wpdb->get_results( "SELECT sum(rating_scale) FROM $results_table WHERE assessment_id =$assessment_id && token='$token' &&( rating_scale != NULL
OR rating_scale != '' )", OBJECT_K );
	$data = array_keys($data);
	$ratings = $data[0];
	
	$score = ($ratings/($total_dimension*4))*100;
	return $score;
}
function get_dimensioncount_domainid($domainid, $token)
{
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";
	
	$data = $wpdb->get_results("SELECT count(*) AS cnt FROM $results_table WHERE domain_id =$domainid && token='$token' &&( rating_scale != NULL
OR rating_scale != '' )", OBJECT_K );
	$data = array_keys($data);
	return $total_dimension = $data[0];
}
function priority_domain_sidebar($assessment_id, $token)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";
	$data = $wpdb->get_results("SELECT distinct(a.domain_id), (SELECT (SUM(b.rating_scale)/(count(b.rating_scale)*4))*100 as totalRating FROM $results_table as b WHERE a.domain_id = b.domain_id AND token='$token') AS totalRating FROM $dimensiontable as a WHERE a.assessment_id=$assessment_id  ORDER BY totalRating");
	
	$top = array(); $mid = array(); $last = array(); 
	if(!empty($data))
	{
		$key = count($data);
		$last[] = $data[$key-1];
		unset($data[$key-1]);
		foreach($data as $res)
		{
			if($res->totalRating == '0' || $res->totalRating == NULL || $res->totalRating == '')
			{
				$mid[] = $res;
			}
			else
			{
				$top[] = $res;
			}
		}
		echo '<ul class="gat_prioritydomaind_list">';
			if(!empty($top))
			{
				foreach($top as $result)
				{
					echo '<li>';
							echo get_the_title($result->domain_id);
							echo '<ul class="gat_indicatorlights">';
								echo '<li><a href="javascript:"><div class="get_indicator_btn red';
									if($result->totalRating < 33){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn yellow';
									if($result->totalRating >= 33 && $result->totalRating < 75){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn green';
									if($result->totalRating >= 75){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
							echo '</ul>';							
					echo '</li>';
				}
			}
			if(!empty($mid))
			{
				foreach($mid as $result)
				{
					echo '<li>';
							echo get_the_title($result->domain_id);
					echo '</li>';
				}
			}
			if(!empty($last))
			{
				foreach($last as $result)
				{
					echo '<li>';
							echo get_the_title($result->domain_id);
							echo '<ul class="gat_indicatorlights">';
								echo '<li><a href="javascript:"><div class="get_indicator_btn red';
									if($result->totalRating < 33){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn yellow';
									if($result->totalRating >= 33 && $result->totalRating < 75){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn green';
									if($result->totalRating >= 75){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
							echo '</ul>';							
					echo '</li>';
				}
			}
		echo '</ul>';
	}
}
?>