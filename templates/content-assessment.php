<?php
/**
 * The Template for displaying all single assessment
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php global $post, $wpdb;?>
<?php
	if(!empty($_POST))
	{
		if(isset($_POST['retrive_token']))
		{
			extract($_POST);
			$table = PLUGIN_PREFIX."response";
			$sql = $wpdb->prepare("SELECT token, assessment_id FROM $table WHERE email = %s ORDER BY id DESC ", $email);
			$result = $wpdb->get_row($sql);
			if(isset($result->token) && !empty($result->token))
			{
				$to      = $email;
				$subject = get_bloginfo('name','raw').' '.get_the_title($result->assessment_id).' Token';
				$token 	 = htmlspecialchars($result->token);
				$message = 'Your Token: ' . '<a href="'.get_permalink($post->ID).'?action=resume-analysis&token='.$token.'">'.$token.'</a>';
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
		if(isset($_POST['gat_results']))
		{
			$result = gat_save_domaindata($_POST);
			if($result)
			{
				echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=analysis-result"</script>';
			}
		}
		//Action perform when continue to next domain
		if(isset($_POST['domain_submit']))
		{
			$result = gat_save_domaindata($_POST);
			if($result)
			{
				extract($_POST);
				if($next_domain != 'resume')
				{
					echo '<script type="text/javascript">ga("send", "event", "Submit Domain", "'.count($dimension_id).'");</script>';
					echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list='.$next_domain.'"</script>';
				}
				else
				{
					echo '<script type="text/javascript">ga("send", "event", "Submit Domain", "'.count($dimension_id).'");</script>';
					echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
				}
			}
		}
		//Action perform when first time token save for assessment
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
			if(!empty($id))
			{
				$sql = $wpdb->prepare("UPDATE $response_table SET email=%s, state=%s, district=%s, organization_id=%s, organization = %s, last_saved=now() WHERE id=%d", $email, $state, $district, $district, $org_label->LEANM, $id);
				$wpdb->query($sql);
			}
			else
			{
				$sql = $wpdb->prepare("INSERT INTO $response_table (assessment_id, token, email, email_verified, state, district, organization_id, organization, start_date, last_saved, progress, overall_score) VALUES (%d, %s, %s, '', %s, %s, %s, %s, now(), '', '0', '0')", $post->ID, $token, $email, $state, $district, $district, $org_label->LEANM);
				$wpdb->query($sql);
			}
			echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list=1"</script>';
		}
		//Action perform when resum from existing token
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
	}
	
	//Check for token
	if(isset($_COOKIE['GAT_token']) && !empty($_COOKIE['GAT_token']))
	{
		$token = htmlspecialchars($_COOKIE['GAT_token']);
		$status = check_token_exists($post->ID, $token);
	}
	else
	{
		echo '<script type="text/javascript">location.reload();</script>';
	}

	if(!empty($_GET))
	{
		//retrive token from email
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'retrive-token')
		{
			?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h3><?php echo get_the_title($post->ID); ?></h3>
                <div class="gat_moreContent">
                    <?php
                        $content = get_the_content($post->ID);
                        $content = apply_filters('the_content', $content);
                        echo strip_tags($content);
                    ?>
                </div>
                <div class="gat_emailform">
                	<?php
						if(isset($_GET['tkn_error']))
						{
							echo '<div class="gat_error"><p>Email address not found. Please try again.</p><p><strong>Note:</strong> Token can only be retrieved by email if you specified your email address when accessing the tool with your token.</p></div>';
						}
						if(isset($_GET['tkn_msg']))
						{
							echo '<div class="gat_error">Token has been sent to your email. If you have trouble locating the message, be sure to check your spam folder.</div>';
						}
					?>
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
		// last stage where user wants to view his resulting video
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'analysis-result')
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
			include_once( GAT_PATH ."/templates/inner-template/analysis-result.php" );
		}
		// third stage if user select resume analysis and after token is verified from db
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'resume-analysis')
		{
			if(isset($_REQUEST['token']) && !empty($_REQUEST['token']))
			{
				echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
			}
			include_once( GAT_PATH ."/templates/inner-template/resume-analysis.php" );
		}
		// third stage if user select start analysis and after token is saved in db
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'token-saved')
		{
			include_once( GAT_PATH ."/templates/inner-template/token-saved.php" );
		}

		// second stage if user select resume analysis (form display for enter token)
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'restart_token')
		{
			?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h3><?php echo get_the_title($post->ID); ?></h3>
                <div class="gat_moreContent">
                    <?php
                        $content = get_the_content($post->ID);
                        $content = apply_filters('the_content', $content);
                        echo strip_tags($content);
                    ?>
                </div>
                <span class="gat_alreadytoken">
                	Already have a token?
                	<a href="<?php echo get_permalink()."?action=retrive-token"; ?>">Forgot Token</a>
                </span>
                <div class="gat_tokenform">
                	<?php
						if(isset($_GET['tkn_error']))
						{
							echo '<div class="gat_error">The token you entered could not be found. Please try again, or if you provided your email address, you can <a href="' . get_permalink(). '?action=retrive-token"; ?>">have your token emailed to you</a>.</div>';
						}
					?>
                    <form method="post">
                        <div class="gat_tokenfrm_brd">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your Token</label>
                                <input type="text" name="token" value="" class="form-control gatfields" />
                            </div>
                        </div>
                    	<button type="submit" name="restart_token" class="btn btn-default gat_buttton">Continue</button>
                    </form>
                </div>
            </div>
            <?php
		}
		// second stage if user select start analysis
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'start-analysis')
		{
			$token = htmlspecialchars($_COOKIE['GAT_token']);
			$response_table = PLUGIN_PREFIX . "response";
			$sql = $wpdb->prepare( "select * from $response_table where token= %s", $token );
			$data = $wpdb->get_row($sql);
			?>
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
	            	<?php echo 'Your Token : '.$token; ?>
                </div>
                <span class="gat_alreadytoken">
                	Already have a token?
                	<a href="<?php echo get_permalink()."?action=restart_token"; ?>"> Continue your analysis</a>
                </span>
                <div class="gat_savetokenform">
                    <form method="post">
                        <div class="gat_tokenfrm_brd">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="text" name="email" class="form-control gatfields" value="<?php echo $data->email;?>">
                                <input type="hidden" name="token" value="<?php echo $token; ?>" />
                                <span>If you forget your token, this is the only way to retrieve it.</span>
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
	}
	// First stage
	else
	{
		if($status)
		{
			echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
		}
		else
		{
		?>
        	<!--Left Section-->
            <div class="col-md-9 col-sm-12 col-xs-12 leftpad">
                <div class="col-md-12 pblctn_paramtr leftpad">
                    <h3><?php echo get_the_title($post->ID); ?></h3>
                 </div>
                 <div class="col-md-12 col-sm-12 col-xs-12 leftpad">

                    <?php
                        $content = get_the_content($post->ID);
                        $content = apply_filters('the_content', $content);
                        echo do_shortcode($content);
                    ?>

                    <ul class="get_domainlist">
                    <?php
                        $domainids = get_domainid_by_assementid($post->ID);
                        if(isset($domainids) && !empty($domainids))
                        {
                            foreach($domainids as $domainid)
                            {
                                $domain = get_post($domainid);
                                echo '<li><a href="'.get_permalink().'?action=start-analysis">
                                        <h4 style="float:left;">'.$domain->post_title.'</a></h4>
                                        <a href="'.get_permalink().'?action=start-analysis">
                                            <label>
                                                <i class="fa fa-play"></i>
                                            </label>
                                        </a>
                                      </li>';
                            }
                        }
                    ?>
                    </ul>
                    <div class="get_domainlist_button">
                        <a class="btn btn-default gat_buttton" href="<?php echo get_permalink()."?action=start-analysis"; ?>" role="button">Start Analysis</a>
                   </div>
                </div>

            </div>

            <!--Right Section-->
            <div class="col-md-3 col-sm-12 col-xs-12 assmnt-left">
               <div class="gat_sharing_widget">
                    <p class="pblctn_scl_icn_hedng"> Share the GAP analysis tool </p>
                    <div class="pblctn_scl_icns">
                        <?php echo do_shortcode("[ssba]"); ?>
                    </div>
               </div>
               <div>
                    <a class="btn btn-default gat_buttton" href="<?php echo get_permalink()."?action=start-analysis"; ?>" role="button">Start Analysis</a>
               </div>
               <div>
                    <a class="btn btn-default gat_buttton" href="<?php echo get_permalink()."?action=restart_token"; ?>" role="button">Resume / Result</a>
               </div>

               <div class="col-md-12 col-sm-12 col-xs-12 leftpad">
               		<?php
						$video = get_post_meta($post->ID, "assessment_featurevideo", true);
						if(!empty($video))
						{
						 echo '<iframe width="100%" height="250px" src="https://www.youtube.com/embed/'.$video.'" frameborder="0" allowfullscreen></iframe>';
                    	}
					?>
               </div>

            </div>
        <?php
		}
	}
?>