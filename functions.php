<?php
/*Enqueue script and style on backend*/
add_action( 'admin_enqueue_scripts', 'gat_back_enqueue_script' );
function gat_back_enqueue_script()
{
	wp_enqueue_style( 'gat_back_style', plugin_dir_url( __FILE__ ).'css/gat_back.css' );
	wp_enqueue_script( 'gat_editor-js', plugin_dir_url( __FILE__ ).'js/tinymce.min.js' );
	wp_enqueue_script( 'gat_back_script', plugin_dir_url( __FILE__ ).'js/gat_back.js' );
}
/*Enqueue script and style on frontend*/
add_action( 'wp_enqueue_scripts', 'gat_front_enqueue_script' );
function gat_front_enqueue_script()
{
	wp_enqueue_style( 'gat_front_style', plugin_dir_url( __FILE__ ).'css/gat_front.css' );
	wp_enqueue_style( 'gat_front_style', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );
	wp_enqueue_script( 'gat_front_script', plugin_dir_url( __FILE__ ).'js/gat_front.js' );
}
/*Enqueue youtube script and ajax url on frontend*/
add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl()
{
	$yoast = get_option("yst_ga");
	if(!empty($yoast))
	{
		$yoastid = $yoast['ga_general']['manual_ua_code_field'];
	}
	else
	{
		$yoastid = '';
	}
	?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
    <script>
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    </script>
    <script>
	  __gaTracker('create', <?php echo $yoastid; ?>, 'auto');
	  __gaTracker('send', 'pageview');
	</script>
<?php
}

/*Enqueue script in footer for domain posttype on backend*/
add_action('admin_footer', 'gat_post_validation');
function gat_post_validation()
{
	global $post;
	if ($post->post_type != 'domain')
	{
		 return;
	}
	/*echo '<script>
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
	</script>';*/
}
/*add action when assessments delete*/
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
/*add action for adding class on plugin menu*/
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
/*add action for set cookie of a token*/
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
                	<a href="javascript:" data-dimensionid="<?php echo $data->id; ?>" onclick="delete_dimension(this)" class="button button-primary">Delete</a>
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
                 	<textarea rows="5" name="dimension_content[]" class="gat_editabletextarea"><?php echo $description; ?></textarea>
                    <!--<div class="gat_editablediv" onclick="initareaodoo();">
						<?php //echo $description; ?>
                    </div>-->
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
	$sql = $wpdb->prepare( "select * from $response_table where assessment_id= %d AND token= %s", $assessment_id, $token );
	$data = $wpdb->get_row($sql);
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
/*This functions get rating scales for dimensions*/
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
/*This function save domains and assessment data into responce and result table*/
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
			else
			{
				$rating[0] = 1;
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
	
	$score = ($ratings/$total_dimension);
	return $score;
}
/*This function get dimension count for a domain where user rated on dimension only*/
function get_dimensioncount_domainid($domainid, $token)
{
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";
	
	$data = $wpdb->get_results("SELECT count(*) AS cnt FROM $results_table WHERE domain_id =$domainid && token='$token' &&( rating_scale != NULL
OR rating_scale != '' )", OBJECT_K );
	$data = array_keys($data);
	return $total_dimension = $data[0];
}
/*This function get total rating count for a domain*/
function get_ratingcount_domainid($domainid, $token)
{
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";
	
	$data = $wpdb->get_results("SELECT sum(rating_scale) FROM $results_table WHERE domain_id =$domainid && token='$token' &&( rating_scale != NULL
OR rating_scale != '' )", OBJECT_K );
	$data = array_keys($data);
	return $ratings = $data[0];
}
/*Sidebar for progress indicator and priority domains*/
function progress_indicator_sidebar($assessment_id, $token)
{
	global $wpdb;
	$response_table = PLUGIN_PREFIX . "response";
	$sql = $wpdb->prepare( "select * from $response_table where assessment_id= %d AND token= %s", $assessment_id, $token );
	$data = $wpdb->get_row($sql);
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
			  <span style="width: '.$data->progress.'%">'.ceil($data->progress).'%</span>
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
function priority_domain_sidebar($assessment_id, $token)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";
	$data = $wpdb->get_results("SELECT distinct(a.domain_id), (SELECT (SUM(b.rating_scale)/count(b.rating_scale)) as totalRating FROM $results_table as b WHERE a.domain_id = b.domain_id AND token='$token') AS totalRating FROM $dimensiontable as a WHERE a.assessment_id=$assessment_id  ORDER BY totalRating");
	
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
									if($result->totalRating > SCORE_LOW_DOWN && $result->totalRating <= SCORE_LOW_UPPER){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn yellow';
									if($result->totalRating > SCORE_LOW_UPPER && $result->totalRating <= SCORE_HIGH_DOWN){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn green';
									if($result->totalRating > SCORE_HIGH_DOWN && $result->totalRating <= SCORE_HIGH_UPPER){ echo " selected_indicatorlght"; }
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
									if($result->totalRating > SCORE_LOW_DOWN && $result->totalRating <= SCORE_LOW_UPPER){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn yellow';
									if($result->totalRating > SCORE_LOW_UPPER && $result->totalRating <= SCORE_HIGH_DOWN){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
								
								echo '<li><a href="javascript:"><div class="get_indicator_btn green';
									if($result->totalRating > SCORE_HIGH_DOWN && $result->totalRating <= SCORE_HIGH_UPPER){ echo " selected_indicatorlght"; }
								echo '"></div></a></li>';
							echo '</ul>';							
					echo '</li>';
				}
			}
		echo '</ul>';
	}
}
?>