<?php
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";
	$videotable = PLUGIN_PREFIX . "videos";
	$watchtable = PLUGIN_PREFIX . "resulted_video";
	$token = htmlspecialchars($_COOKIE['GAT_token']);

	if(isset($_GET["sortby"]) && !empty($_GET["sortby"]))
	{
		switch ($_GET["sortby"]) {
			case "priority":
				$sql = $wpdb->prepare("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
        where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.assessment_id=%d AND <condition> ORDER BY b.rating_scale ASC", $token, $post->ID);
				$sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('".'"'."%', b.rating_scale, '".'"'."%') OR
				 a.`rating_scale` LIKE IF((b.rating_scale = NULL OR b.rating_scale = ''), '%1%', b.rating_scale)", $sql));

				$data_rslts = $wpdb->get_results($sql);
				break;
			case "domains":
				$sql = $wpdb->prepare("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.assessment_id=%d AND <condition> ORDER BY b.domain_id ASC", $token, $post->ID);
				$sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('%".'"'."', b. `rating_scale`, '".'"'."%')", $sql));
				$data_rslts = $wpdb->get_results($sql);
				break;
			case "watched":
				$sql = $wpdb->prepare("SELECT a.*, ((a.seek/a.end)*100) as percent FROM $watchtable as a where assessment_id=%d AND token=%s ORDER BY CAST(percent as DECIMAL(10,5)) DESC", $post->ID, $token);
				$data_rslts = $wpdb->get_results($sql);
				break;
		}
	}
	else
	{
		$sql = $wpdb->prepare("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
        where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.assessment_id=%d AND <condition> ORDER BY b.rating_scale ASC", $token, $post->ID);
        $sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('%".'"'."', b.rating_scale, '".'"'."%') OR
         a.`rating_scale` LIKE IF((b.rating_scale = NULL OR b.rating_scale = ''), '%1%', b.rating_scale)", $sql));

		$data_rslts = $wpdb->get_results($sql);
	}

	//Email Result POST
	if(isset($_POST['email_results']))
	{
		extract($_POST);

		$assign = "";
		if(!empty($data_rslts))
		{
			$i = 1;
			foreach($data_rslts as $data)
			{
				if($i <= 3)
				{
					$sql = $wpdb->prepare("SELECT title FROM wp_gat_dimensions as a WHERE id = %d", $data->dimensions_id);
					$dimensionTitle = $wpdb->get_row($sql);
					$assign .= '<ul>
									<li>
										<a href="'.get_permalink($assessment_id).'?action=analysis-result&token='.$token.'">
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
		$from = get_option( 'admin_email' );
		$subject = get_bloginfo('name','raw').' '.get_the_title($assessment_id).' Token';

		$message = '<p>Thank you for participating in the '.get_the_title($assessment_id).' Assessment. If you would like to access the tool again to update your results and gauge your progress in addressing identified gaps, use this token: <a href="'.get_permalink($assessment_id).'?action=resume-analysis&token='.$token.'">'.$token.'</a></p>';

		$message .= '<p>Here are the top videos selected for you based on your self-assessment:</p>';

		$message .= $assign;
		$message .= 'View Complete List of Video <a href="'.get_permalink($assessment_id).'?action=analysis-result&token='.$token.'"> Selections '.$token.'</a>';

		$headers = 'From: ' .$from. "\r\n" .
					'Reply-To: ' . $from."\r\n" .
					'X-Mailer: PHP/' . phpversion();
					
		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		if(wp_mail( $to, $subject, $message, $headers ))
		{
			$alert_message = 'Your assessment result sent';
		}
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' ); 			
	}
	?>
	<div class="col-md-9 col-sm-12 col-xs-12 analysis_result leftpad">
		 <h3><?php echo get_the_title($post->ID); ?></h3>
          <?php
			  if(isset($alert_message) && !empty($alert_message))
				 { 
					echo '<div class="gat_error">'.$alert_message.'</div>'; 
				 }
		 ?>
		 <div class="gat_moreContent">
		 	<?php
				$content = get_post_meta($post->ID, "result_content", true);
				echo apply_filters("the_content", $content);
			?>
         </div>
		 <div class="gat_priority_form">
			<form method="get" action="<?php echo get_permalink($post->ID); ?>?action=analysis-result&sortby=" id="gat_priorityfrm">
				<select name="sortby" onchange="priority_submit(this);">
					<option value="priority" <?php echo $a = ($_GET["sortby"] == 'priority') ? 'selected="selected"' : ''; ?>>Priority</option>
					<option value="domains" <?php echo $a = ($_GET["sortby"] == 'domains') ? 'selected="selected"' : ''; ?> >Domains</option>
					<option value="watched" <?php echo $a= ($_GET["sortby"] == 'watched') ? 'selected="selected"' : ''; ?> >Previously Watched</option>
				</select>
			</form>
		 </div>
		 <div class="gat_player_videos loadvideo">
			<div id="player" data-resultedid=''></div>
            <div class="unclickablevideo" style="display: block;" title="Play from Playlist"></div>
         </div>
		 <ul class="gat_reslt_listvideos">
			<?php
				if(!empty($data_rslts))
				{
					echo "<script type='text/javascript'>
							var tag = document.createElement('script');
							tag.src = 'https://www.youtube.com/iframe_api';
							var firstScriptTag = document.getElementsByTagName('script')[0];
      						firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
							var player;
							function onYouTubeIframeAPIReady()
							{
								player = new YT.Player('player', {
								  height: '260',
								  width: '420',
								  videoId: '',
								  playerVars: {
									  'autoplay': 0,
									  'controls': 1,
									  'rel' : 1
								  },
								  events: {
									'onReady': onPlayerReady,
									'onStateChange': onPlayerStateChange
								  }
								});
							 }
							 function onPlayerReady(event)
							 {
								//event.target.playVideo();
							 }
							 function onPlayerStateChange(event)
							 {
								var url = event.target.getVideoUrl();
								var match = url.match(/[?&]v=([^&]+)/);
								if( match != null)
								{
									var videoId = match[1];
								}
								videoId = String(videoId);
								switch (event.data) {
									case YT.PlayerState.PLAYING:
										if(jQuery('.currentmeter').prev('span').children('i.fa').hasClass('fa-play'))
										{
											jQuery('.currentmeter').prev('span').children('i.fa').removeClass('fa-play')
											jQuery('.currentmeter').prev('span').children('i.fa').addClass('fa-pause')
										}
										var id = jQuery('.currentmeter').prev('span').attr('data-resultedid');
										jQuery('.gat_reslt_listvideos').children('li').each(function()
										{
											if( id == jQuery(this).children('.gat_videodetails').children('span.cntrollorbtn').attr('data-resultedid'))
											{		}
											else
											{
												jQuery(this).children('.unclickable').css('display', 'block');
												jQuery(this).children('.unclickable').attr('title','Please pause/stop current video to play this video!');
											}
										});

										if (cleanTime() == 0) {
											ga('send', 'event', 'video', 'started', videoId);
										} else {
											ga('send', 'event', 'video', 'played', 'v: ' + videoId + ' | t: ' + cleanTime());
										};
									break;
									case YT.PlayerState.PAUSED:
										jQuery('.gat_reslt_listvideos').children('li').each( function(){
											jQuery(this).children('.unclickable').css('display', 'none');
											jQuery(this).children('.unclickable').attr('title','');
										});
										var resultedid = jQuery('#player').attr('data-resultedid');
										if(typeof resultedid != 'undefined')
										{
											trackrecordbyid(resultedid);
										}

										if (player.getDuration() - player.getCurrentTime() != 0) {
											ga('send', 'event', 'video', 'paused', 'v: ' + videoId + ' | t: ' + cleanTime());
										};
									break;
									case YT.PlayerState.ENDED:
									   jQuery('.gat_reslt_listvideos').children('li').each( function(){
											jQuery(this).children('.unclickable').css('display', 'none');
											jQuery(this).children('.unclickable').attr('title','');
										});
										var resultedid = jQuery('#player').attr('data-resultedid');
										if(typeof resultedid != 'undefined')
										{
											trackrecordbyid(resultedid);
										}

										ga('send', 'event', 'video', 'ended', videoId );
									break;
								};
							 }
							 function cleanTime()
							 {
								return Math.round(player.getCurrentTime());
							 }
						  </script>";
					foreach($data_rslts as $data_rslt)
					{
						$resulted_video = PLUGIN_PREFIX . "resulted_video";
						$sql = $wpdb->prepare( "select * from $resulted_video where assessment_id = %d AND domain_id = %d AND dimensions_id = %d AND token= %s AND youtubeid= %s", $post->ID, $data_rslt->domain_id, $data_rslt->dimensions_id, $token, $data_rslt->youtubeid );
						$exists = $wpdb->get_row($sql);
						if(!empty($exists))
						{
							echo '<li>';
								echo '<div class="gat_imgcntnr">
										<img src="http://img.youtube.com/vi/'.$exists->youtubeid.'/0.jpg" width="80" height="80" />
									  </div>';
								echo '<div class="gat_desccntnr">';
									echo '<span>'.stripslashes(get_the_title($exists->domain_id)).' : </span>';
									echo '<span>'.stripslashes($data_rslt->label).'</span>';
								echo '</div>';
								echo '<div class="gat_videodetails">';
									if($exists->seek == NULL || $exists->seek == '')
									{
										echo '<span class="cntrollorbtn" data-seekto="0"  data-resultedid="'.$exists->id.'" data-youtubeid="'.$exists->youtubeid.'"><i class="fa fa-play"></i></span>';
										echo '<div class="meter"><span style="width: 0%"></span></div>';
									}
									else
									{
										$seek = ceil($exists->seek);
										$end = ceil($exists->end);
										$complete = 0;
										if(!empty($seek) && !empty($end))
										{
											$complete = ($seek/$end)*100;
											$complete = ceil($complete);
										}
										if($seek == $end)
										{
											echo '<span class="cntrollorbtn" data-resultedid="'.$exists->id.'" data-youtubeid="'.$exists->youtubeid.'" ><i class="fa fa-check"></i></span>';
										}
										else
										{
										  echo '<span class="cntrollorbtn" data-seekto="'.$exists->seek.'" data-resultedid="'.$exists->id.'" data-youtubeid="'.$exists->youtubeid.'" ><i class="fa fa-play"></i></span>';
										}
										echo '<div class="meter"><span style="width: '.$complete.'%">'.$complete.'%</span></div>';
									}
								echo '</div>';
								echo '<div class="unclickable"></div>';
							echo '</li>';
						}
						else
						{
							$sql = $wpdb->prepare("insert into $resulted_video (assessment_id, domain_id, dimensions_id, token, youtubeid) values (%d, %d, %d, %s, %s)", $post->ID, $data_rslt->domain_id, $data_rslt->dimensions_id, $token, $data_rslt->youtubeid);
							$wpdb->query($sql);
							$lastid = $wpdb->insert_id;
							echo '<li>';
								echo '<div class="gat_imgcntnr">
										<img src="http://img.youtube.com/vi/'.$data_rslt->youtubeid.'/0.jpg" width="80" height="80" />
									  </div>';
								echo '<div class="gat_desccntnr">';
									echo '<span>'.get_the_title($data_rslt->domain_id).' : </span>';
									echo '<span>'.$data_rslt->label.'</span>';
								echo '</div>';
								echo '<div class="gat_videodetails">';
									echo '<span class="cntrollorbtn" data-seekto="0" data-resultedid="'.$lastid.'" data-youtubeid="'.$data_rslt->youtubeid.'"><i class="fa fa-play"></i></span>';
										echo '<div class="meter"><span style="width: 0%"></span></div>';
								echo '</div>';
								echo '<div class="unclickable"></div>';
							echo '</li>';
						}
					}
				}
			?>
		 </ul>
		 <ul class="gat_domainsbmt_btn">
			<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default gat_buttton">Back to Domains</a></li>
			<li>
            	<?php
					$response = PLUGIN_PREFIX . "response";  
					$sql = $wpdb->prepare("select email from $response where assessment_id = %d AND token = %s", $post->ID, $token);
					$result = $wpdb->get_row($sql);
				?>
            	<form method="post">
                	<input type="hidden" name="email" value="<?php echo $result->email; ?>" />
                	<input type="hidden" name="assessment_id" value="<?php echo $post->ID; ?>" />
                	<input type="submit" class="btn btn-default gat_buttton" name="email_results" value="Email Results" />
                </form>
            </li>
			<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default gat_buttton">Continue Analysis</a></li>
		  </ul>
	</div>
	<div class="col-md-3 col-sm-12 col-xs-12">
		<h4>Priority Domains</h4>
		<?php priority_domain_sidebar($post->ID, $token); ?>
		<?php progress_indicator_sidebar($post->ID, $token); ?>
	</div>
