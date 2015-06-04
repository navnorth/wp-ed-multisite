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
					echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list='.$next_domain.'"</script>';
				}
				else
				{
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
			if(!empty($id))
			{
				$wpdb->query("UPDATE $response_table SET email='$email', state='$state', last_saved=now() WHERE id=$id");
			}
			else
			{
				$wpdb->query("INSERT INTO $response_table (assessment_id, token, email, email_verified, state, organization_id, organization, start_date, last_saved, progress, overall_score) VALUES ($post->ID, '$token', '$email', '', '$state', '', '', now(), '', '0', '0')");
			}
			echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=token-saved&list=1"</script>';
		}
		
		//Action perform when resum from existing token
		if(isset($_POST['restart_token']))
		{
			extract($_POST);
			$status = check_token_exists($post->ID, $token);
			if( date('d') == 31 || (date('m') == 1 && date('d') > 28)){
				$date = strtotime('last day of next month');
			} else {
				$date = strtotime('+1 months');
			}
			$expire = date("l j F Y h:i:s A", $date);
			$path = parse_url(get_option('siteurl'), PHP_URL_PATH);
			if (isset($_COOKIE['GAT_token']))
			{
				unset($_COOKIE['GAT_token']);
				setcookie('GAT_token', '', time() - 3600);
			}
			echo "<script>
					document.cookie = 'GAT_token=$token; expires=$expire; path=$path'
				  </script>";
			if($status)
			{
				echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=resume-analysis"</script>';
			}
			else
			{
				echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'?action=restart_token&tkn_error=true"</script>';
			}
		}
	}
	if(!empty($_GET))
	{
		// last stage where user wants to view his resulting video
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'analysis-result')
		{
			global $wpdb;
			$results_table = PLUGIN_PREFIX . "results";
			$videotable = PLUGIN_PREFIX . "videos";
			$token = $_COOKIE['GAT_token'];
			
			if(isset($_GET["sortby"]) && !empty($_GET["sortby"]))
			{
				switch ($_GET["sortby"]) {
					case "priority":
						$data_rslts = $wpdb->get_results("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token='$token' AND b.assessment_id=$post->ID AND a.`rating_scale` LIKE CONCAT('%', b. `rating_scale`, '%')  group by a.dimensions_id ORDER BY b.rating_scale ASC");
						break;
					case "domains":
						$data_rslts = $wpdb->get_results("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token='$token' AND b.assessment_id=$post->ID AND a.`rating_scale` LIKE CONCAT('%', b. `rating_scale`, '%')  group by a.dimensions_id ORDER BY b.domain_id ASC");
						break;
					case "watched":
						$data_rslts = $wpdb->get_results("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token='$token' AND b.assessment_id=$post->ID AND a.`rating_scale` LIKE CONCAT('%', b. `rating_scale`, '%')  group by a.dimensions_id ORDER BY b.rating_scale ASC");
						break;
				}
			}
			else
			{
				$data_rslts = $wpdb->get_results("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token='$token' AND b.assessment_id=$post->ID AND a.`rating_scale` LIKE CONCAT('%', b. `rating_scale`, '%')  group by a.dimensions_id ORDER BY b.rating_scale ASC");
			}
			?>
			<div class="col-md-9 col-sm-12 col-xs-12 analysis_result">
                 <h3><?php echo get_the_title($post->ID); ?></h3>
                 <p><?php echo apply_filters("the_content", get_the_content($post->ID)); ?></p>
                 <div class="gat_priority_form">
                 	<form method="get" action="<?php echo get_permalink($post->ID); ?>?action=analysis-result&sortby=" id="gat_priorityfrm">
                    	<select name="sortby" onchange="priority_submit(this);">
                        	<option value="priority" <?php echo $a = ($_GET["sortby"] == 'priority') ? 'selected="selected"' : ''; ?>>Priority</option>
                            <option value="domains" <?php echo $a = ($_GET["sortby"] == 'domains') ? 'selected="selected"' : ''; ?> >Domains</option>
                            <option value="watched" <?php echo $a= ($_GET["sortby"] == 'watched') ? 'selected="selected"' : ''; ?> >Priviously Watched</option>
                        </select>
                    </form>
                 </div>
                 <div class="gat_player_videos">
                 	<div id="player"></div>
                 </div>
                 <ul class="gat_reslt_listvideos">
                 	<?php
						if(!empty($data_rslts))
						{
							foreach($data_rslts as $data_rslt)
							{
								echo '<li>';
									echo '<div class="gat_imgcntnr">
											<img src="http://img.youtube.com/vi/'.$data_rslt->youtubeid.'/0.jpg" width="80" height="80" />
										  </div>';
									echo '<div class="gat_desccntnr">';
										echo '<span>'.get_the_title($data_rslt->domain_id).' : </span>';
										echo '<span>'.$data_rslt->label.'</span>';
									echo '</div>';	
								echo '</li>';
							}
						}
					?>
                 </ul>
                 <ul class="gat_domainsbmt_btn">
                  	<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default">Back to Domains</a></li>
                  	<li><input type="submit" class="btn btn-default" name="gat_results" value="Email Results" /></li>
                  	<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default">Continue Analysis</a></li>
                  </ul> 
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
            	<h4>Priority Domains</h4>
				<?php priority_domain_sidebar($post->ID, $token); ?>
                <?php progress_indicator_sidebar($post->ID, $token); ?>
            </div>
            <?php
		}
		
		// third stage if user select resume analysis and after token is verified from db
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'resume-analysis')
		{
			?>
            <h3><?php echo get_the_title($post->ID); ?></h3>
            <p>
                <?php
                    $content = get_the_content($post->ID);
                    $content = apply_filters('the_content', $content);
                    echo substr(strip_tags($content), 0, 250)." [...]";
                ?>
            </p>
            
            <div class="col-md-9 col-sm-12 col-xs-12">
                <ul class="get_domainlist">
                <?php
                    $domainids = get_domainid_by_assementid($post->ID);
                    if(isset($domainids) && !empty($domainids))
                    {
						$i = 1;
                        foreach($domainids as $domainid)
                        {
                            $domain = get_post($domainid);
							$total_dmnsn = get_dimensioncount($domainid);
							$total_dmnsn_rated = get_dimensioncount_domainid($domainid, $_COOKIE['GAT_token']);
                            
							echo '<li>';
                                    echo $domain->post_title;
									echo '<ul class="gat_indicatorlights">';
									if($total_dmnsn_rated != 0)
									{
										$progress = ($total_dmnsn_rated/$total_dmnsn)*100;
										if($progress == 100)
										{
											echo '<li><a href="javascript:"><div class="get_indicator_btn red"></div></a></li>
												  <li><a href="javascript:"><div class="get_indicator_btn yellow"></div></a></li>
												  <li><a href="javascript:"><div class="get_indicator_btn green selected_indicatorlght"></div></a></li>';
										}
										else
										{
											echo '<li><a href="javascript:"><div class="get_indicator_btn red"></div></a></li>
												  <li><a href="javascript:"><div class="get_indicator_btn yellow selected_indicatorlght"></div></a></li>
												  <li><a href="javascript:"><div class="get_indicator_btn green"></div></a></li>';
										}
									}
									else
									{
										echo '<li><a href="javascript:"><div class="get_indicator_btn red selected_indicatorlght"></div></a></li>
											  <li><a href="javascript:"><div class="get_indicator_btn yellow"></div></a></li>
											  <li><a href="javascript:"><div class="get_indicator_btn green"></div></a></li>';
									}
									  
  							  echo '</ul>';
                              echo '<a href="'.get_permalink().'?action=token-saved&list='.$i.'">';
                                   		if($total_dmnsn_rated != 0)
										{
											$progress = ($total_dmnsn_rated/$total_dmnsn)*100;
											if($progress == 100)
											{
												echo '<label><i class="fa fa-check"></i></label>';
											}
											else
											{
												echo '<label class="meter"><span style="width: '.$progress.'%"></span></label>';
											}
										}
										else
										{
											echo '<label><i class="fa fa-play"></i></label>';
										}
                            	echo '</a>';
							echo '</li>';
							$i++;	  
                        }
                    }
                ?>
                </ul>
                <div class="get_domainlist_button">
                    <a class="btn btn-default" href="<?php echo get_permalink()."?action=token-saved&list=1"; ?>" role="button">Continue Analysis</a>
               </div>
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
            	<div class="gat_sharing_widget">
                    <p class="pblctn_scl_icn_hedng"> Share the GAP analysis tool </p>
                    <div class="pblctn_scl_icns">	
                        <?php echo do_shortcode("[ssba]"); ?>
                    </div>    
                </div>	
            	<?php progress_indicator_sidebar($post->ID, $_COOKIE['GAT_token']); ?>
            </div>
            
            <?php
		}
		
		// third stage if user select start analysis and after token is saved in db
		if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'token-saved')
		{
			global $wpdb;
			$table = PLUGIN_PREFIX . "results";
			$domainids = get_domainid_by_assementid($post->ID);
			$list = $_GET['list'];
			$nextdomain = $list+1;
			$l =1;
			foreach($domainids as $domainid)
			{
				if($l == $list)
				{
					$domain = get_post($domainid);
					$title =  $domain->post_title;
					$content =  $domain->post_content;
				}
				if($list == count($domainids))
				{
					$nextdomain = "resume";
				}
				$l++;
			}
			$dimensions = get_alldimension_domainid($domain->ID);
			?>
            <form method="post" id="assessment_data">
            	<input type="hidden" name="assessment_id" value="<?php echo $post->ID; ?>" />
                <input type="hidden" name="domain_id" value="<?php echo $domain->ID; ?>" />
                <input type="hidden" name="token" value="<?php echo $_COOKIE['GAT_token']; ?>" />
                <input type="hidden" name="next_domain" value="<?php echo $nextdomain; ?>" />
                
                <h2><?php echo $post->post_title; ?></h2>
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <h4><?php echo $title; ?></h4>
                    <div class="gat_content"><?php echo $content; ?></div>
                    <hr />
                    <?php
                    if(isset($dimensions) && !empty($dimensions))
                    {
                        $i=1;
                        foreach($dimensions as $dimension)
                        {
                            echo '<b>'.$i.': '.$dimension->title.'</b>';
                            echo '<p>'.$dimension->description.'</p>';
                            $scales = get_rating_scale('1-4 scale');
							$result = $wpdb->get_row("SELECT rating_scale from $table where dimension_id=$dimension->id && token='".$_COOKIE['GAT_token']."'");
							if(!empty($result->rating_scale))
							{
								$scale_slctd = $result->rating_scale;
								$divcls = 'selectedarea';
							}
                            ?>
                            	<input type="hidden" name="dimension_id[]" value="<?php echo $dimension->id; ?>" />
                                <ul class="gat_domain_rating_scale">
                                    <?php
									$j = 1;
									foreach($scales as $scale)
									{
										if(!empty($scale_slctd))
										{
											if($j == $scale_slctd):
												$selected_content =  $scale->post_content;
												$licls = 'selectedli';
											else:
												$licls = '';
											endif;	
										}
									?>
                                    <li tabindex="0" onclick="select_rating(this)" class="rating_scaleli <?php echo $licls;?>" data-rating="<?php echo $j;?>">
										<?php echo $j.' '.$scale->post_title; ?>
                                        <input type="hidden" name="rating_<?php echo $dimension->id; ?>[]" value="<?php echo $scale_slctd; ?>" />
                                        <div class="rating_scale_description">
                                          	<?php echo $scale->post_content; ?>
                                        </div>
                                    </li>
                                    <?php
										$j++;
										}
									?>    
                                </ul>
                                <div class="gat_scaledescription_cntnr <?php echo $divcls; ?>"><?php echo $selected_content; ?></div>
                            <?php
							$i++;
                        }
                    }
                    ?>
                  <ul class="gat_domainsbmt_btn">
                  	<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default">Back to Domains</a></li>
                  	<li><input type="submit" class="btn btn-default" name="gat_results" value="Get Results Now" /></li>
                  	<li><input type="submit" class="btn btn-default" name="domain_submit" value="Continue to next Domain"/></li>
                  </ul>  
                </div>
            </form>
            <div class="col-md-3 col-sm-12 col-xs-12">
            	<?php progress_indicator_sidebar($post->ID, $_COOKIE['GAT_token']); ?>
            </div>
            <?php
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
                <div class="">
                	<?php
						if(isset($_GET['tkn_error']))
						{
							echo '<div class="error">Token you enter is not found !</div>';
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
            <div class="col-md-12 col-sm-12 col-xs-12">
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
                <div class="">
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
            <div class="col-md-9 col-sm-12 col-xs-12 pblctn_lft_sid_img_cntnr">
                <div class="col-md-12 pblctn_paramtr padding_left">
                    <h3><?php echo get_the_title($post->ID); ?></h3>
                    <p>
                        <?php
                            $content = get_the_content($post->ID);
                            $content = apply_filters('the_content', $content);
                            echo do_shortcode($content);
                        ?>
                    </p>
                 </div>
            </div>
            
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
            </div>
            
            <div class="col-md-7 col-sm-12 col-xs-12">
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
            
            <div class="col-md-5  col-sm-12 col-xs-12">
                <iframe width="100%" height="300px" src="https://www.youtube.com/embed/kvVdzZX18kY" frameborder="0" allowfullscreen></iframe>
            </div>
		<?php
		}
	}
?>	