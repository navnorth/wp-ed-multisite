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
<script type="text/javascript">
	__gaTracker('send', 'pageview', {
	  'page': '<?php echo $_SERVER["REQUEST_URI"];?>',
	  'title': '<?php echo get_the_title($post->ID);?>'
	});
</script>
<?php
	if(isset($_COOKIE['GAT_token']) && !empty($_COOKIE['GAT_token']))
	{
    	$token = $_COOKIE['GAT_token'];
		$status = check_token_exists($post->ID, $token);
	}
	else
	{
		echo '<script type="text/javascript">location.reload();</script>';
	}
?>
<?php
	if(!empty($_POST))
	{
		if(isset($_POST['retrive_token']))
		{
			extract($_POST);
			$table = PLUGIN_PREFIX."response";
			$result = $wpdb->get_row("SELECT token FROM $table WHERE email = '$email' ORDER BY id DESC ");
			if(isset($result->token) && !empty($result->token))
			{
				$to      = $email;
				$subject = 'Forgot Token';
				$message = 'Your Token :' . $result->token;
				wp_mail( $to, $subject, $message );
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
					echo '<script type="text/javascript">__gaTracker("send", "event", "Submit Domain", "'.count($dimension_id).'");</script>';
					echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list='.$next_domain.'"</script>';
				}
				else
				{
					echo '<script type="text/javascript">__gaTracker("send", "event", "Submit Domain", "'.count($dimension_id).'");</script>';
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
			$org_label = $wpdb->get_row("SELECT DISTINCT LEANM FROM $organizations WHERE LEAID = '$district'");
			if(!empty($id))
			{
				$wpdb->query("UPDATE $response_table SET email='$email', state='$state', district='$district', organization_id='$district', organization = '$org_label->LEANM', last_saved=now() WHERE id=$id");
			}
			else
			{
				$wpdb->query("INSERT INTO $response_table (assessment_id, token, email, email_verified, state, district, organization_id, organization, start_date, last_saved, progress, overall_score) VALUES ($post->ID, '$token', '$email', '', '$state', '$district', '$district', '$org_label->LEANM', now(), '', '0', '0')");
			}
			echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list=1"</script>';
		}
		
		//Action perform when resum from existing token
		if(isset($_POST['restart_token']))
		{
			extract($_POST);
			global $wpdb;
			$response_table = PLUGIN_PREFIX . "response";
			$data = $wpdb->get_row("select * from $response_table where token='$token'");
			
			if( date('d') == 31 || (date('m') == 1 && date('d') > 28)){
				$date = strtotime('last day of next month');
			} else {
				$date = strtotime('+1 months');
			}
			$expire = date("l j F Y h:i:s A", $date);
			$path = parse_url(get_option('siteurl'), PHP_URL_PATH);
			
			if(isset($data) && !empty($data))
			{
				if (isset($_COOKIE['GAT_token']))
				{
					unset($_COOKIE['GAT_token']);
					@setcookie('GAT_token', '', time() - 3600);
				}
				echo "<script>
						document.cookie = 'GAT_token=$token; expires=$expire; path=$path'
					  </script>";
				if($data->assessment_id == $post->ID)
				{
					echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
				}
				else
				{
					$wpdb->query("INSERT INTO $response_table (assessment_id, token, email, email_verified, state, district, organization_id, organization, start_date, last_saved, progress, overall_score) VALUES ($post->ID, '$token', '$data->email', '', '$data->state', '$data->district', '$data->organization_id', '$data->organization', now(), '', '0', '0')");
					echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list=1"</script>';
				}
			}
			else
			{
				echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=restart_token&tkn_error=true"</script>';
			}
		}
	}
	if(!empty($_GET))
	{
		//retrive token from email
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'retrive-token')
		{
			?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h3><?php echo get_the_title($post->ID); ?></h3>
                <p>
                    <?php
                        $content = get_the_content($post->ID);
                        $content = apply_filters('the_content', $content);
                        echo substr(strip_tags($content), 0, 250)." [...]";
                    ?>
                </p>
                <div class="gat_emailform">
                	<?php
						if(isset($_GET['tkn_error']))
						{
							echo '<div class="gat_error">Email does not exists ?</div>';
						}
						if(isset($_GET['tkn_msg']))
						{
							echo '<div class="gat_error">Token send to your email address !</div>';
						}
					?>
                    <form method="post">
                        <div class="gat_tokenfrm_brd">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your Email</label>
                                <input type="email" name="email" value="" class="form-control gatfields" />
                            </div>
                        </div>
                    	<button type="submit" name="retrive_token" class="btn btn-default gat_tokenfrm_btn">Submit Email</button>
                    </form>
                </div>
            </div>
            <?php
		}
		
		// last stage where user wants to view his resulting video
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'analysis-result')
		{
			?>
			<script type="text/javascript">
				__gaTracker('send', 'pageview', {
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
                <p>
                    <?php
                        $content = get_the_content($post->ID);
                        $content = apply_filters('the_content', $content);
                        echo substr(strip_tags($content), 0, 250)." [...]";
                    ?>
                </p>
                <span class="gat_alreadytoken">
                	Already have a token?
                	<a href="<?php echo get_permalink()."?action=retrive-token"; ?>">Forgot Token</a>
                </span>
                <div class="gat_tokenform">
                	<?php
						if(isset($_GET['tkn_error']))
						{
							echo '<div class="gat_error">Token you enter is not found !</div>';
						}
					?>
                    <form method="post">
                        <div class="gat_tokenfrm_brd">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your Token</label>
                                <input type="text" name="token" value="" class="form-control gatfields" />
                            </div>
                        </div>
                    	<button type="submit" name="restart_token" class="btn btn-default gat_tokenfrm_btn">Continue</button>
                    </form>
                </div>
            </div>
            <?php
		}
		
		// second stage if user select start analysis
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'start-analysis')
		{
			$token = $_COOKIE['GAT_token'];
			$response_table = PLUGIN_PREFIX . "response";
			$data = $wpdb->get_row("select * from $response_table where token='$token'");
			?>
            <div class="col-md-12 col-sm-12 col-xs-12 leftpad">
                <h3><?php echo get_the_title($post->ID); ?></h3>
                <p>
                    <?php
                        $content = get_the_content($post->ID);
                        $content = apply_filters('the_content', $content);
                        echo substr(strip_tags($content), 0, 250)." [...]";
                    ?>
                </p>
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
                    	<button type="submit" name="save_token" class="btn btn-default gat_tokenfrm_btn">Save / Continue</button>
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
                    <p>
                        <?php
                            $content = get_the_content($post->ID);
                            $content = apply_filters('the_content', $content);
                            echo do_shortcode($content);
                        ?>
                    </p>
                 </div>
                 
                 <div class="col-md-12 col-sm-12 col-xs-12 leftpad">
                    <ul class="get_domainlist">
                    <?php
                        $domainids = get_domainid_by_assementid($post->ID);
                        if(isset($domainids) && !empty($domainids))
                        {
                            foreach($domainids as $domainid)
                            {
                                $domain = get_post($domainid);
                                echo '<li>
                                        '.$domain->post_title.'
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
                        <a class="btn btn-default" href="<?php echo get_permalink()."?action=start-analysis"; ?>" role="button">Start Analysis</a>
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
                    <a class="btn btn-default" href="<?php echo get_permalink()."?action=start-analysis"; ?>" role="button">Start Analysis</a>
               </div>
               <div>
                    <a class="btn btn-default" href="<?php echo get_permalink()."?action=restart_token"; ?>" role="button">Resume / Result</a>
               </div>
               
               <div class="col-md-12 col-sm-12 col-xs-12 leftpad">
                    <iframe width="100%" height="300px" src="https://www.youtube.com/embed/kvVdzZX18kY" frameborder="0" allowfullscreen></iframe>
               </div>
                
            </div>
        <?php
		}
	}
?>	