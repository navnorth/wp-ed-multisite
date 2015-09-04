<?php
/**
 * The Template for displaying all single assessment
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
    global $post, $wpdb;
    
    if( ! empty($_POST))
    {
	/**
	 * Retrieve Token
	 * @code begin
	 */
	if(isset($_POST['retrive_token']))
	{
	    extract($_POST);
	    $table = PLUGIN_PREFIX."response";
	    $sql = $wpdb->prepare("SELECT token, assessment_id FROM $table WHERE email = %s ORDER BY id DESC ", $email);
	    $result = $wpdb->get_row($sql);
	    
	    if(isset($result->token) && !empty($result->token))
	    {
		$to      = $email;
		$subject = get_bloginfo('name','raw').' '.get_the_title($result->assessment_id).' Access Code';
		$token 	 = htmlspecialchars($result->token);
		$message = 'Your Access Code: ' . '<a href="'.get_permalink($post->ID).'?action=resume-analysis&token='.$token.'">'.$token.'</a>';
		$headers = 'From: info@' .$_SERVER['HTTP_HOST']. "\r\n" .
		    'Reply-To: info@' . $_SERVER['HTTP_HOST']."\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		wp_mail( $to, $subject, $message, $headers );
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=retrive-token&tkn_msg=true"</script>';
	    }
	    else
	    {
		echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=retrive-token&tkn_error=true"</script>';
	    }
	    die;
	}
	/**
	 * Retrieve Token
	 * @code end
	 */
	
	/**
	 * GAT Results
	 * @code begin
	 */
	if(isset($_POST['gat_results']))
	{
	    /**
	     * @see wp-gap-analysis/functions.php
	     * check_token_exists(assessment, token, column)
	     */
	    $response_id = check_token_exists($post->ID, $_POST['token'], "id");
	    
	    // Suppose to update but do nothing for awhile
	    if($response_id)
	    {
		
	    }
	    // Save
	    else
	    {
		/**
		 * @see wp-gap-analysis/functions.php
		 */
		register_GAT_response($post->ID, $_POST['token']);
	    }
	    
	    /**
	     * gat_save_domaindata(POST) will fail if there were no 
	     * response saved for the current assessment and token.
	     */
	    $result = gat_save_domaindata($_POST);
	    
	    if($result)
	    {
		$user_response = NULL;
		
		if($response_id)
		{
		    /**
		     * @see wp-gap-analysis/functions.php
		     * get_GAT_response(assessment, token)
		     */
		    $user_response = get_GAT_response($_POST['assessment_id'], $_POST['token']);
		}
		
		$location = get_permalink($post->ID) . "?action=analysis-result" . (($user_response->email OR $_COOKIE[GAT_INQUIRE_USER_COOKIE] == NULL) ? '' : '&inquire=true');
		
		echo '<script type="text/javascript">window.location = "' . $location . '"</script>';
	    }
	}
	/**
	 * GAT Results
	 * @code end
	 */
	
	/**
	 * Domain Submit
	 * Action perform when continue to next domain.
	 * @code begin
	 */
	if(isset($_POST['domain_submit']))
	{
	    /**
	     * @see wp-gap-analysis/functions.php
	     * check_token_exists(assessment, token, column)
	     */
	    $response_id = check_token_exists($post->ID, $_POST['token'], "id");
	    
	    // Suppose to update but do nothing for awhile
	    if($response_id)
	    {
		
	    }
	    // Save
	    else
	    {
		/**
		 * @see wp-gap-analysis/functions.php
		 */
		register_GAT_response($post->ID, $_POST['token']);
	    }
	    
	    /**
	     * gat_save_domaindata(POST) will fail if there were no 
	     * response saved for the current assessment and token.
	     */
	    $result = gat_save_domaindata($_POST); // @see functions.php
	    
	    if($result)
	    {
		extract($_POST);
		
		echo '<script type="text/javascript">ga("send", "event", "Submit Domain", "'.count($dimension_id).'");</script>';
		
		$location = get_permalink($post->ID);
		
		if($next_domain == 'resume')
		{
		    $location .= '?action=resume-analysis';
		}
		else
		{
		    $user_response = NULL;
		    
		    if($response_id)
		    {
			/**
			 * @see wp-gap-analysis/functions.php
			 * get_GAT_response(assessment, token)
			 */
			$user_response  = get_GAT_response($post->ID, $token);
		    }
		    $location .= '?action=token-saved&list=' . $next_domain . (($user_response->email OR $_COOKIE[GAT_INQUIRE_USER_COOKIE] == NULL) ? '' :'&inquire=true');
		}
		
		echo '<script type="text/javascript">window.location = "' . $location . '"</script>';
	    }
	}
	/**
	 * Domain Submit
	 * @code end
	 */
	
	/**
	 * Save Token
	 * Action perform when first time token save for assessment.
	 * @code begin
	 * @deprecated
	 */
	if(isset($_POST['save_token']))
	{
	    extract($_POST);
	    $id = check_token_exists($post->ID, $token, "id");
	    $response_table = PLUGIN_PREFIX . "response";
	    $organizations = PLUGIN_PREFIX . "organizations";
	    $sql = $wpdb->prepare("SELECT DISTINCT LEANM FROM $organizations WHERE LEAID = %s", $district);
	    $org_label = $wpdb->get_row($sql);
	    $token = htmlspecialchars($token);
	    $email = htmlspecialchars($email);
	    
	    if( ! empty($id))
	    {
		$sql = $wpdb->prepare("UPDATE $response_table SET email=%s, state=%s, district=%s, organization_id=%s, organization = %s, last_saved=now() WHERE id=%d", $email, $state, $district, $district, $org_label->LEANM, $id);
		$wpdb->query($sql);
	    }
	    else
	    {
		$progress = (float) gat_progress_total($post->ID, $token);
		$score = (float) gat_overall_score($post->ID, $token);
		
		$sql = $wpdb->prepare("INSERT INTO
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
			NOW(), '', ''
		    )", $post->ID, $token, $email, $state, $district, $district, $org_label->LEANM, $progress, $score);
		
		$wpdb->query($sql);
	    }
	        
	    echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list=1"</script>';
	}
	/**
	 * Save Token
	 * @code end
	 */
	
	/**
	 * Restart Token
	 * Action perform when resuming from existing token.
	 * @code begin
	 */
	if(isset($_POST['restart_token']))
	{
	    extract($_POST);
	    
	    global $wpdb;
	    $response_table = PLUGIN_PREFIX . "response";
	    $sql = $wpdb->prepare( "select * from $response_table where token= %s", $token );
	    $data = $wpdb->get_row($sql);
	    
	    if(isset($data) && !empty($data))
	    {
		if($data->assessment_id == $post->ID)
		{
		    echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
		}
		// Breaking Point
		else
		{
		    $sql = $wpdb->prepare("INSERT INTO $response_table (assessment_id, token, email, email_verified, state, district, organization_id, organization, start_date, last_saved, progress, overall_score) VALUES (%d, %s, %s, '', %s, %s, %s, %s, now(), '', '0', '0')", $post->ID, $token, $data->email, $data->state, $data->district, $data->organization_id, $data->organization);
		    $wpdb->query($sql);
		    echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list=1"</script>';
		}
	    }
	    else
	    {
		echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=restart_token&tkn_error=true"</script>';
	    }
	}
	/**
	 * Restart Token
	 * @code end
	 */
    }
	
    // Has Token
    if(isset($_COOKIE['GAT_token']) && !empty($_COOKIE['GAT_token']))
    {
	$token = htmlspecialchars($_COOKIE['GAT_token']);
	$status = check_token_exists($post->ID, $token);
    }
    // Doesn't Have Token
    else
    {
	echo '<script type="text/javascript">location.reload();</script>';
    }	
    
    // Performed GET action
    if( ! empty($_GET))
    {
	/**
	 * Retrieve Token View
	 * retrive token from email.
	 * @code begin
	 */
	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'retrive-token')
	{ ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
	    <h3><?php echo get_the_title($post->ID); ?></h3>
	    <div class="gat_moreContent">
		<?php
		    $content = get_the_content($post->ID);
		    $content = apply_filters('the_content', $content);
		    
		    echo strip_tags($content); ?>
	    </div>
	    
	    <div class="gat_emailform">
	    <?php
		if(isset($_GET['tkn_error']))
		{
		    echo '<div class="gat_error"><p>Email address not found. Please try again.</p><p><strong>Note:</strong> Access code can only be retrieved by email if you specified your email address when accessing the tool with your access code.</p></div>';
		}
		
		if(isset($_GET['tkn_msg']))
		{
		    echo '<div class="gat_error">Access code has been sent to your email. If you have trouble locating the message, be sure to check your spam folder.</div>';
		} ?>
		<form method="post">
		    <div class="gat_tokenfrm_brd">
			<div class="form-group">
			    <label for="exampleInputEmail1">Your Email</label>
			    <input type="email" name="email" value="" class="form-control gatfields" />
			</div>
		    </div>
		    
		    <button type="submit" name="retrive_token" class="btn btn-default gat_buttton">Submit Email</button>
		</form>
	    </div>
	</div>
    <?php
	}
	/**
	 * Retrieve Token View
	 * @code end
	 */
	
	/**
	 * Analysis Result View
	 * Last stage where user wants to view his resulting video.
	 * @code begin
	 */ 
	if(isset($_GET['action']) && ! empty($_GET['action']) && $_GET['action'] == 'analysis-result')
	{
	    if(isset($_REQUEST['token']) && !empty($_REQUEST['token']))
	    {
		echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=analysis-result"</script>';
	    } ?>
	    <script type="text/javascript">
		ga('send', 'pageview', {
		    'page': '<?php echo $_SERVER["REQUEST_URI"];?>',
		    'title': 'Analysis Result'
		});
	    </script>
        <?php
	    include_once( GAT_PATH ."/templates/inner-template/analysis-result.php" );
	}
	/**
	 * Analysis Result View
	 * @code end
	 */
	
	/**
	 * Video Playlist View
	 * @code begin
	 */
	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'video-playlist')
	{
		if(isset($_REQUEST['token']) && !empty($_REQUEST['token']))
		{
			echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=analysis-result"</script>';
		}
		?>
		<script type="text/javascript">
			ga('send', 'pageview', {
			  'page': '<?php echo $_SERVER["REQUEST_URI"];?>',
			  'title': 'Analysis Result'
			});
		</script>
		<?php
		include_once( GAT_PATH ."/templates/inner-template/video-playlist.php" );
	}
	/**
	 * Video Playlist View
	 * @code end
	 */
	
	/**
	 * Resume Analysis View
	 * Third stage, if user select resume analysis and after token is verified from db.
	 * @code begin
	 */
	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'resume-analysis')
	{
	    if(isset($_REQUEST['token']) && !empty($_REQUEST['token']))
	    {
		echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
	    }
	    
	    include_once( GAT_PATH ."/templates/inner-template/resume-analysis.php" );
	}
	/**
	 * Resume Analysis View
	 * @code end
	 */
	
	/**
	 * Token Saved View
	 * Third stage, if user select start analysis and after token is saved in db.
	 * @code begin
	 */
	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'token-saved')
	{
	    include_once( GAT_PATH ."/templates/inner-template/token-saved.php" );
	}
	/**
	 * Token Saved View
	 * @code end
	 */

	/**
	 * Restart Token View
	 * Second stage, if user select resume analysis (form display for enter token).
	 * @code begin
	 */ 
	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'restart_token')
	{ ?>
	<div class="col-md-12 col-sm-12 col-xs-12">
	    <h3><?php echo get_the_title($post->ID); ?></h3>
	    <div class="gat_moreContent">
	    <?php
		$content = get_the_content($post->ID);
		$content = apply_filters('the_content', $content);
		
		echo strip_tags($content); ?>
	    </div>
	    
	    <span class="gat_alreadytoken">
		Already have an access code?
		<a href="<?php echo get_permalink()."?action=retrive-token"; ?>">Forgot Access Code</a>
	    </span>
	    
	    <div class="gat_tokenform">
		    <?php
					    if(isset($_GET['tkn_error']))
					    {
						    echo '<div class="gat_error">The access code you entered could not be found. Please try again, or if you provided your email address, you can <a href="' . get_permalink(). '?action=retrive-token"; ?>">have your access code emailed to you</a>.</div>';
					    }
				    ?>
		<form method="post">
		    <div class="gat_tokenfrm_brd">
			<div class="form-group">
			    <label for="exampleInputEmail1">Your Access Code</label>
			    <input type="text" name="token" value="" class="form-control gatfields" />
			</div>
		    </div>
		    <button type="submit" name="restart_token" class="btn btn-default gat_buttton">Continue</button>
		</form>
	    </div>
	</div>
    <?php
	}
	/**
	 * Restart Token View
	 * @code end
	 */ 
	
	/**
	 * Start Analysis View
	 * Second stage, if user select start analysis.
	 * @code begin
	 */ 
	if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'start-analysis')
	{
	    $token = htmlspecialchars($_COOKIE['GAT_token']);
	    $response_table = PLUGIN_PREFIX . "response";
	    $sql = $wpdb->prepare( "SELECT * FROM `$response_table` WHERE `token` = %s", $token );
	    $data = $wpdb->get_row($sql); ?>
	    
	<div class="col-md-12 col-sm-12 col-xs-12 leftpad">
	    <h3><?php echo get_the_title($post->ID); ?></h3>
	    <div class="gat_moreContent">
		<?php
		    $content = get_the_content($post->ID);
		    $content = apply_filters('the_content', $content);
		    echo strip_tags($content);
		?>
	    </div>
	    <div class="gat_genratedtoken">
		    <?php echo 'Your Access Code : '.$token; ?>
	    </div>
	    <span class="gat_alreadytoken">
		    Already have an access code?
		    <a href="<?php echo get_permalink()."?action=restart_token"; ?>"> Continue your analysis</a>
	    </span>
	    <div class="gat_savetokenform">
		<form method="post">
		<?php
		    if(array_key_exists("continue", $_GET)): ?>
		    <input type="hidden" name="continue" value="<?php echo urldecode($_GET["continue"]); ?>" />
		<?php
		    endif; ?>
		    <div class="gat_tokenfrm_brd">
			<div class="form-group">
			    <label for="exampleInputEmail1">Email address</label>
			    <input type="text" name="email" class="form-control gatfields" value="<?php echo $data->email;?>">
			    <input type="hidden" name="token" value="<?php echo $token; ?>" />
			    <span>If you forget your access code, this is the only way to retrieve it.</span>
			</div>
			
			<div class="form-group">
			    <label for="state">State</label>
			    <select name="state" class="form-control gatfields" onchange="gat_districtcode(this);" >
				<option value="">Select State</option>
				<?php gat_state($data->state); ?>
			    </select>
			    <span>Location information is for statistical reporting only.</span>
			</div>
			
			<div class="form-group">
			    <label for="district">District</label>
			    <select name="district" class="form-control gatfields" ></select>
			</div>
			
			<div class="form-group gatprivacylink">
			    Read our <a href="#">privacy policy</a>
			</div>
		    </div>
		    <button type="submit" name="save_token" class="btn btn-default gat_buttton">Save / Continue</button>
		</form>
	    </div>
	</div>
	<?php
	}
	/**
	 * Start Analysis View
	 * @code end
	 */ 
    }
    // Initial Stage, first stage
    else
    {
	// Has Token
	if($status)
	{
	    echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
	}
	else
	{
	    $permalink = get_permalink(); ?>
	<div class="col-md-9 col-sm-12 col-xs-12 leftpad">
	    <div class="col-md-12 pblctn_paramtr leftpad">
		<h3><?php echo get_the_title($post->ID); ?></h3>
	     </div>
	     <div class="col-md-12 col-sm-12 col-xs-12 leftpad">
		<?php
		    $content = get_the_content($post->ID);
		    $content = apply_filters('the_content', $content);
		    
		    echo do_shortcode($content);
		    
		    $user_response = get_GAT_response($post->ID, $_COOKIE['GAT_token']);
		?>

                <ul class="get_domainlist">
                <?php
		    $domainids = get_domainid_by_assementid($post->ID);
		    
		    if(isset($domainids) && !empty($domainids))
		    {
			foreach($domainids as $key => $domainid)
			{
			    $domain = get_post($domainid);
			    $href = $permalink . '?action=token-saved&list=' . ($key + 1);
			    
			    echo '<li>
				<a href="' . $href . '">
				    <h4 style="float:left;">'.$domain->post_title.'</h4>
				</a>
				<a href="' . $href . '">
				    <label>
					<i class="fa fa-play"></i>
				    </label>
			        </a>
			    </li>';
			}
		    } ?>
                </ul>
		
		<div class="get_domainlist_button">
		    <a class="btn btn-default gat_buttton" href="<?php echo $permalink . "?action=token-saved&list=1"; ?>" role="button">
			Start Analysis
		    </a>
	       </div>
            </div>
	</div> <!-- Left Section -->

	<div class="col-md-3 col-sm-12 col-xs-12 assmnt-left">
	   <div class="gat_sharing_widget">
		<p class="pblctn_scl_icn_hedng"> Share the GAP analysis tool </p>
		<div class="pblctn_scl_icns">
		    <?php echo do_shortcode("[ssba]"); ?>
		</div>
	   </div>
	   <div>
		<a class="btn btn-default gat_buttton" href="<?php echo $permalink . "?action=token-saved&list=1"; ?>" role="button">
		    Start Analysis
		</a>
	   </div>
	   <div>
		<a class="btn btn-default gat_buttton" href="<?php echo $permalink . "?action=restart_token"; ?>" role="button">
		    Resume / Result
		</a>
	   </div>

	   <div class="col-md-12 col-sm-12 col-xs-12 leftpad">
	    <?php
		$video = get_post_meta($post->ID, "assessment_featurevideo", true);
		
		if( ! empty($video))
		{
		    echo '<iframe width="100%" height="250px" src="https://www.youtube.com/embed/' . $video . '" frameborder="0" allowfullscreen></iframe>';
		} ?>
	   </div>
	</div> <!-- Right Section -->
    <?php
	}
    } ?>