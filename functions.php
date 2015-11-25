<?php

global $sort_order;


if( ! defined('GAT_INQUIRE_USER_COOKIE'))
    define('GAT_INQUIRE_USER_COOKIE', 'GAT-inquire-user-information');

if( ! defined('GAT_TOKEN_COOKIE'))
    define('GAT_TOKEN_COOKIE', 'GAT_token');

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
	wp_enqueue_style( 'jscrollpane_style', plugin_dir_url( __FILE__ ).'css/jquery.jscrollpane.css' );
	wp_enqueue_style( 'gat_front_style', plugin_dir_url( __FILE__ ).'css/gat_front.css' );
	wp_enqueue_style( 'gat_front_style', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );

	wp_enqueue_script( 'jquery' );
	/* JScroll Pane */
	wp_enqueue_script( 'jquery_mousewheel_script', plugin_dir_url( __FILE__ ).'js/jquery.mousewheel.js' );
	wp_enqueue_script( 'jquery_jscrollpane_script', plugin_dir_url( __FILE__ ).'js/jquery.jscrollpane.min.js' );
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
    /* workaround to only use SSL when on SSL (avoid self-signed cert issues) */
    <?php if (!strpos($_SERVER['REQUEST_URI'],"wp-admin")): ?>
	var ajaxurl = '<?php echo GAT_URL ?>ajax.php';
    <?php else: ?>
	var ajaxurl = '<?php echo admin_url("admin-ajax.php", (is_ssl() ? "https": "http") ); ?>
    <?php endif; ?>
    </script>
    <script>
    /**
	var tag = document.createElement('script');
	tag.src = "//www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    */
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
	$sql = $wpdb->prepare("DELETE a,b
		FROM $dimensiontable AS a
		INNER JOIN $videotable AS b ON a.id = b.dimensions_id
		WHERE a.assessment_id = %d", $postid);
	$wpdb->query($sql);
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
    $path = parse_url(get_option('siteurl'), PHP_URL_PATH);
    $host = parse_url(get_option('siteurl'), PHP_URL_HOST);

    if(isset($_POST['clear-analysis']))
    {
	$name = 'gat-clear-analysis-nonce';

	$nonce = (isset($_POST[$name]) AND wp_verify_nonce($_POST[$name], '55d470caefa93'));
	$token = (isset($_COOKIE['GAT_token']) AND isset($_POST['clear-analysis']) AND $_COOKIE['GAT_token'] == $_POST['clear-analysis']);

	if($nonce AND $token)
	{
	    unset($_COOKIE['GAT_token']);
	    $t = time();

	    setcookie('GAT_token', '', $t + 2678400, $path, $host);
	}
    }

    // Has GAT Token
    if(isset($_COOKIE['GAT_token']) && ! empty($_COOKIE['GAT_token']))
    {
	$action = array('resume-analysis', 'analysis-result', 'restart_token', 'video-playlist');

	if(isset($_REQUEST['token']) AND empty($_REQUEST['token']) == FALSE AND in_array($_REQUEST['action'], $action))
	{
	    if($_REQUEST['action'] == 'restart_token')
	    {
		global $wpdb;
		extract($_POST);
		$response_table = PLUGIN_PREFIX . "response";
		$sql = $wpdb->prepare( "select * from $response_table where token = %s", $token );
		$data = $wpdb->get_row($sql);

		if(isset($data) && !empty($data))
		{
		    $token = htmlspecialchars($token);
		    setcookie("GAT_token", $token, time() + 2678400, $path, $host);

		    if($data->email == NULL)
			setcookie(GAT_INQUIRE_USER_COOKIE, '1', time() + 2678400, $path, $host);
		}
	    }
	    else
	    {
		$time = time() + 2678400;

		$token = htmlspecialchars($_REQUEST['token']);
		setcookie("GAT_token", $token, $time, $path, $host);

		if( ! isset($_COOKIE[GAT_INQUIRE_USER_COOKIE]))
		    setcookie(GAT_INQUIRE_USER_COOKIE, '1', $time, $path, $host);
		else
		    //When GAT-inquire-user-information is set, change it to 0 as not trigger popup info form
		    setcookie(GAT_INQUIRE_USER_COOKIE, '0', $time, $path, $host);
	    }
	}
    }
    // No GAT Token
    else
    {
	$action = array('resume-analysis', 'analysis-result', 'restart_token', 'video-playlist');

	if(isset($_REQUEST['token']) AND empty($_REQUEST['token']) == FALSE AND in_array($_REQUEST['action'], $action))
	{
	    if($_REQUEST['action'] == 'restart_token')
	    {
		global $wpdb;
		extract($_POST);
		$response_table = PLUGIN_PREFIX . "response";
		$sql = $wpdb->prepare( "select * from $response_table where token= %s", $token );
		$data = $wpdb->get_row($sql);

		if(isset($data) && !empty($data))
		{
		    $token = htmlspecialchars($token);
		    setcookie("GAT_token", $token, time() + 2678400, $path, $host);

		    if($data->email == NULL)
			setcookie(GAT_INQUIRE_USER_COOKIE, '1', time() + 2678400, $path, $host);
		}
	    }
	    else
	    {
		$token = htmlspecialchars($_REQUEST['token']);
		setcookie("GAT_token", $token, time() + 2678400, $path, $host);

		if( ! isset($_COOKIE[GAT_INQUIRE_USER_COOKIE]))
		    setcookie(GAT_INQUIRE_USER_COOKIE, '0', $time, $path, $host);
	    }
	}
	// Nothing, not even a token.
	else
	{
	    $t = time();

	    $token = generateRandomString(8);

	    setcookie("GAT_token", $token, $t + 2678400, $path, $host);
	    setcookie(GAT_INQUIRE_USER_COOKIE, '1', $t + 2678400, $path, $host);
	}
    }
}
//Fatch data functions
/*This function get dimentions data on metboxs*/
function get_dimensions_data($postid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$videotable = PLUGIN_PREFIX . "videos";
	$sql = $wpdb->prepare("select * from $dimensiontable where domain_id=%d", $postid);
	$datas = $wpdb->get_results($sql);
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
								$sql = $wpdb->prepare("select * from $videotable where dimensions_id=%d", $data->id);
                            	$videos = $wpdb->get_results($sql);
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
                                            	<input type="text" name="dimension_<?php echo $i; ?>_videolabel[]" value="<?php echo stripslashes($video->label); ?>" />
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
	$sql = $wpdb->prepare("select assessment_id from $dimensiontable where domain_id=%d", $postid);
	$data = $wpdb->get_row($sql);
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
	$sql = $wpdb->prepare("select domain_id from $dimensiontable ogd INNER JOIN ".$wpdb->prefix."posts op ON ogd.domain_id=op.ID where ogd.assessment_id=%d ORDER BY op.menu_order", $postid);
	$data = $wpdb->get_results($sql, OBJECT_K);
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
	$sql = $wpdb->prepare("SELECT COUNT(*) FROM $dimensiontable where domain_id=%d", $domainid);
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	return  $data[0];
}
/*This function get total dimension count for the assessment*/
function get_total_dimensioncount($assessmentid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$sql = $wpdb->prepare("SELECT COUNT(*) FROM $dimensiontable where assessment_id=%d", $assessmentid);
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	return  $data[0];
}
/*This function get video count for domain id*/
function get_videocount($domainid)
{
	global $wpdb;
	$videotable = PLUGIN_PREFIX . "videos";
	$sql = $wpdb->prepare("SELECT COUNT(*) FROM $videotable where domain_id=%d", $domainid);
	$data = $wpdb->get_results( $sql, OBJECT_K  );
	$data = array_keys($data);
	return  $data[0];
}
/*This function get all dimension data by domain id*/
function get_alldimension_domainid($domainid)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$sql = $wpdb->prepare("SELECT * FROM $dimensiontable where domain_id=%d", $domainid);
	$data = $wpdb->get_results($sql);
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
				$rating[0] = '';
			}
			$sql = $wpdb->prepare("delete from $results_table where dimension_id = %d && token = %s", $dimensionid, $token);
			$wpdb->query($sql);

			$sql = $wpdb->prepare("INSERT INTO $results_table (assessment_id, domain_id, dimension_id, token, rating_scale) VALUES (%d, %d, %d, %s, %s)", $assessment_id, $domain_id, $dimensionid, $token, $rating[0]);
			$wpdb->query($sql);
		}
	}
	$progress = gat_progress_total($assessment_id, $token);
	$overallscore = gat_overall_score($assessment_id, $token);

	$sql = $wpdb->prepare("UPDATE $response_table SET progress=%s, overall_score=%s, last_saved=now() where assessment_id = %d && token = %s", $progress, $overallscore, $assessment_id, $token);
	$wpdb->query($sql);
	return true;
}
function filter_callback($val)
{
	$val = trim($val);
	return $val != '';
}
function gat_progress_total($assessment_id, $token)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";

	$sql = $wpdb->prepare("SELECT COUNT(*) FROM $dimensiontable where assessment_id=%d", $assessment_id );
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	$total_dimension = $data[0];

	$sql = $wpdb->prepare("SELECT count(*) AS cnt FROM $results_table WHERE assessment_id = %d && token=%s &&( rating_scale != NULL
OR rating_scale != '' )", $assessment_id, $token );
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	$total_rated = $data[0];

	$progress = @($total_rated/$total_dimension)*100;
	return $progress;
}
function gat_overall_score($assessment_id, $token)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";

	$sql = $wpdb->prepare("SELECT count(*) AS cnt FROM $results_table WHERE assessment_id =%d && token=%s &&( rating_scale != NULL
OR rating_scale != '' )", $assessment_id, $token);
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	$total_dimension = $data[0];

	$sql = $wpdb->prepare("SELECT sum(rating_scale) FROM $results_table WHERE assessment_id =%d && token=%s &&( rating_scale != NULL
OR rating_scale != '' )", $assessment_id, $token);
	$data = $wpdb->get_results( $sql, OBJECT_K );
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

	$sql = $wpdb->prepare("SELECT count(*) AS cnt FROM $results_table WHERE domain_id =%d && token=%s &&( rating_scale != NULL
OR rating_scale != '' )", $domainid, $token);
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	return $total_dimension = $data[0];
}
/*This function get total number of dimentions where user rated in an assessment */
function get_total_ratedcount($assessmentid, $token)
{
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";

	$sql = $wpdb->prepare("SELECT count(*) AS cnt FROM $results_table WHERE assessment_id =%d && token=%s &&( rating_scale != NULL
OR rating_scale != '' )", $assessmentid, $token);
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	return $total_dimension = $data[0];
}
/*This function get total rating count for a domain*/
function get_ratingcount_domainid($domainid, $token)
{
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";

	$sql = $wpdb->prepare("SELECT sum(rating_scale) FROM $results_table WHERE domain_id =%d && token=%s &&( rating_scale != NULL
OR rating_scale != '' )", $domainid, $token);
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	return $ratings = $data[0];
}
/*Sidebar for progress indicator and priority domains*/
function progress_indicator_sidebar($assessment_id, $token)
{
    $data = get_GAT_response($assessment_id, $token);

    if( ! empty($data->email))
    {
	$email = explode("@", $data->email);

	for($i = 1; $i < strlen($email[0]); $i++)
	    $email[0][$i] = '*';

    $personal_info = '<div><span><b>Email : </b></span><span>'.$email[0].'@'.$email[1].'</span></div>';
    }
    // Doesn't Have E-mail
    else
    {
	// $email = '<a href="'. get_permalink().'?action=start-analysis">Set Your Email</a>';
	// $personal_info = '<div><span><b>Email : </b></span><span class="gat-user-email"><a href="#" id="show-gat-user-info-modal">Set Your E-mail</a></span></div>';
        $personal_info = '<div class="gat_saveinfo"><a class="btn btn-default gat_button_saveinfo" href="#" id="show-gat-user-info-modal" role="button">Save Your Session</a></div>';
    }

	echo '<div class="gat_indicatorwidget">
			<div class="meter">
			  <span style="width: ' . ceil($data->progress) . '%">'.ceil($data->progress).'%</span>
		  	</div>
			<div>
				<form id="clear-analysis" method="post" action="' . get_permalink() . '">
					' . wp_nonce_field('55d470caefa93', 'gat-clear-analysis-nonce') . '
					<input type="hidden" name="clear-analysis" value="' . $token . '" />
					<a href="#" id="do-clear-analysis">
						<span class="access-code">
							<b>Your access code: </b>'
							. $token .
							'<span class="fa fa-times text-danger">&nbsp;</span>
						</span>
					</a>
				</form>
			</div>
			'.$personal_info.'

			<!--<div>
				<span><b>Last Saved : </b></span>
				'.$data->last_saved.'
			</div>-->
		  </div>';
}
function priority_domain_sidebar($assessment_id, $token)
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";

	$sql = $wpdb->prepare("SELECT distinct(a.domain_id), (SELECT (SUM(b.rating_scale)/count(b.rating_scale)) as totalRating FROM $results_table as b WHERE a.domain_id = b.domain_id AND token=%s) AS totalRating FROM $dimensiontable as a WHERE a.assessment_id=%d  ORDER BY totalRating", $token, $assessment_id);
	$data = $wpdb->get_results($sql);

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
function set_html_content_type()
{
    return 'text/html';
}
/**
 * Register User Information Action Hook
 * Description
 */
add_action('wp_ajax_register_user_info', 'register_user_info_callback');
add_action( 'wp_ajax_nopriv_register_user_info', 'register_user_info_callback' );
/**
 * Register User Information Callback
 * Description
 */
function register_user_info_callback()
{
    $name = 'gat-user-information-nonce';
    $nonce = (isset($_POST[$name]) AND wp_verify_nonce($_POST[$name], '55e80bfb3ea74'));

    if($nonce)
    {
	global $wpdb;

	$assessment = url_to_postid($_POST['_wp_http_referer']);

	if(check_token_exists($assessment, $_POST['token']) == FALSE)
	    register_GAT_response($assessment, $_POST['token']);

	$organization = NULL;

	if($_POST['district'])
	{
	    $organization_table = PLUGIN_PREFIX . "organizations";

	    $organization_sql = $wpdb->prepare("SELECT DISTINCT LEANM FROM `" . $organization_table . "` WHERE `LEAID` = %s", $_POST['district']);
	    $organization_row = $wpdb->get_row($organization_sql);

	    $organization = $organization_row->LEANM;
	}

	$response_table = PLUGIN_PREFIX . "response";
	$sql = $wpdb->prepare("UPDATE
	    `" . $response_table . "`
	SET
	    `email` = %s, `state` = %s,
	    `district` = %s, `organization_id` = %s, `organization_id` = %s
	WHERE
	    `assessment_id` = %d AND
	    `token` = %s",
	    $_POST['email'], $_POST['state'],
	    $_POST['district'], $_POST['district'], $organization,
	    $assessment,
	    $_POST['token']
	);

	$reply = array(
	    "status" => (FALSE === $wpdb->query($sql)) ? 'error' : 'success'
	);

	echo json_encode($reply);
    }
    else
    {
	echo json_encode(array("status" => "error"));
    }

    wp_die();
}
/**
 * GET GAT Response
 * Description
 *
 * @param integer $assessment The assessment ID.
 * @param string $token The user token.
 *
 * @return object The response.
 */
function get_GAT_response($assessment, $token)
{
    global $wpdb;

    $response_table = PLUGIN_PREFIX . "response";

    $sql = $wpdb->prepare( "SELECT
	*
    FROM
	`" . $response_table . "`
    WHERE
	`assessment_id` = %d AND
	`token` = %s",
    $assessment, $token);

    $data = $wpdb->get_row($sql);

    return $data;
}
/**
 * Register GAT Response
 * Register GAT response to OET database.
 *
 * @param array $GAT The response data.
 */
function register_GAT_response($assessment = 0, $token = '', $email = '', $state = '', $district = '', $progress = 0, $score = 0)
{
    if($assessment == 0 OR $token == NULL)
	return FALSE;

    global $wpdb;

    $organization = NULL;

    if($district)
    {
	$organization_table = PLUGIN_PREFIX . "organizations";

	$organization_sql = $wpdb->prepare("SELECT DISTINCT LEANM FROM `" . $organization_table . "` WHERE `LEAID` = %s", $district);
	$organization_row = $wpdb->get_row($organization_sql);

	$organization = $organization_row->LEANM;
    }

    $response_table = PLUGIN_PREFIX . "response";

    // Build Query
    $response_sql = $wpdb->prepare("INSERT INTO
	`" . $response_table . "`
	(
	    `assessment_id`, `token`, `email`,
	    `state`, `district`, `organization_id`,
	    `organization`, `progress`, `overall_score`,
	    `start_date`, `last_saved`, `email_verified`
	)
    VALUES
	(
	    %d, %s, %s,
	    %s, %s, %s,
	    %s, %f, %f,
	    NOW(), NOW(), ''
	)",
	$assessment, $token, $email,
	$state, $district, $district,
	$organization, $progress, $score
    );

    // Send Query and return result
    return $wpdb->query($response_sql);
}
/**
 *
 * Get Rating Scale based on dimension id and domain id
 *
 **/
function get_rating_by_dimensionid($dimensionid, $token){
	global $wpdb;
	$rating = 0;
	$result_table = PLUGIN_PREFIX . "results";

	$sql = $wpdb->prepare("SELECT rating_scale from $result_table where dimension_id=%d && token=%s", $dimensionid, $token);
	$result = $wpdb->get_row($sql);

	if( ! empty($result->rating_scale))
	{
	    $rating = $result->rating_scale;
	}

	return $rating;
}
/**
 *
 * Get Maximum Possible Scale based on dimension id
 *
 **/
function get_max_rating_scale(){
	global $wpdb;
	$max_rating = 0;
	$ratings_table = $wpdb->prefix . "term_taxonomy";

	$sql = $wpdb->prepare("SELECT count as max_rating_scale from $ratings_table where taxonomy='scale' and count>%d", 0);
	$result = $wpdb->get_row($sql);

	if( ! empty($result->max_rating_scale))
	{
	    $max_rating = $result->max_rating_scale;
	}

	return $max_rating;
}
/**
 *
 * Email Results
 *
 **/
function email_results($_params, $data_results, $token){
	global $wpdb;
	extract($_params);
	$assign = "";
	if(!empty($data_results))
	{
		$i = 1;
		foreach($data_results as $data)
		{
			if($i <= 3)
			{
				$sql = $wpdb->prepare("SELECT title FROM ".PLUGIN_PREFIX."dimensions as a WHERE id = %d", $data->dimensions_id);
				$dimensionTitle = $wpdb->get_row($sql);
				$assign .= '<ul>
								<li>
									<a href="'.get_permalink($assessment_id).'?action=video-playlist&token='.$token.'">
										'.get_the_title($data->domain_id).' - '.$dimensionTitle->title.' - '.$data->label.'
									</a>
								</li>
							</ul>';
			}
			else
			{
				break;
			}
			$i++;
		}
	}

	$to = $email;

	$from = "Ed.Tech@ed.gov";

	$subject = 'Link to your customized '.get_the_title($assessment_id).' playlist';

	$message = '<p>Thank you for participating in the '.get_the_title($assessment_id).' Assessment!  Based on the answers you provided we suggest you start by looking at the following videos:';

	$message .= $assign;
	$message .= '<p>To view your entire customized playlist, <a href="'.get_permalink($assessment_id).'?action=video-playlist&token='.$token.'">click this link</a> (or go to '.get_permalink($assessment_id).' and enter this access code: <u>'.$token.'</u>)</p>';

    $message .= '<p>If you would like to return to the questions to continue your exploration or update your results <a href="'.get_permalink($assessment_id).'?action=resume-analysis&token='.$token.'">click this link</a> or go to '.get_permalink($assessment_id).' and enter this access code: <u>'.$token.'</u></p>';

	//Support Text
	$message .= '<p>If you have any questions, please email us at <a href="mailto:tech@ed.gov">tech@ed.gov</a><br /><br />Enjoy!<br /><br />Office of Educational Technology Team<br />United States Department of Education';

	$headers = 'From: Ed Tech <' .$from. ">\r\n" .
				'Reply-To: ' . $from."\r\n" .
				'X-Mailer: PHP/' . phpversion();

	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	if(wp_mail( $to, $subject, $message, $headers ))
	{
		$alert_message = 'Your assessment result sent';
	}
	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

	return $alert_message;
}

//Sort Domains according to sortby parameter
function sort_domains_by_order($domains) {
	$order = array();
	$id = array();
	foreach ($domains as $key => $val) {
		$id[$key] = $val->ID;
		$order[$key] =  $val->menu_order;
	}
	
	array_multisort($order, SORT_ASC, $id, SORT_ASC, $domains);
	
	return $domains;
}

//Update Domain with new order
function set_domain_order($domainid, $order) {
	global  $wpdb;
	$result = $wpdb->query($wpdb->prepare('UPDATE '.$wpdb->prefix.'posts SET menu_order = %d WHERE ID = %d', $order, $domainid));
	return $result;
}

?>
