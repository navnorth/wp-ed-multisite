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
				$sql = $wpdb->prepare("SELECT DISTINCT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
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
			case "unwatched":
				$sql = $wpdb->prepare("SELECT a.*, ((a.seek/a.end)*100) as percent, b.* FROM $watchtable as a INNER JOIN $videotable as b ON (a.domain_id=b.domain_id AND a.dimensions_id=b.dimensions_id) where assessment_id=%d AND token=%s AND ((a.seek/a.end)*100) is null ORDER BY CAST(percent as DECIMAL(10,5)) DESC", $post->ID, $token);
				$data_rslts = $wpdb->get_results($sql);
				break;
			default:
				$sql = $wpdb->prepare("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.domain_id=%d AND <condition> ORDER BY b.assessment_id ASC", $token, $_GET["sortby"]);
				$sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('%".'"'."', b. `rating_scale`, '".'"'."%')", $sql));
				$data_rslts = $wpdb->get_results($sql);
				break;
		}
	}
	else
	{
		$sql = $wpdb->prepare("SELECT DISTINCT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
		where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.assessment_id=%d AND <condition> ORDER BY b.rating_scale ASC", $token, $post->ID);
		$sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('%".'"'."', b.rating_scale, '".'"'."%') OR
		 a.`rating_scale` LIKE IF((b.rating_scale = NULL OR b.rating_scale = ''), '%1%', b.rating_scale)", $sql));

		$data_rslts = $wpdb->get_results($sql);
	}

	//Email Result POST
	if(isset($_POST['email_results']))
	{
		$alert_message = email_results($_POST, $data_rslts, $token);
	}
	?>
	<a id="content" tabindex="0"></a>
	<div class="col-md-8 col-sm-12 col-xs-12 video-playlist-result leftpad">
		 <h3><?php echo get_the_title($post->ID) . ": " . "Your Custom Video Playlist"; ?></h3>
          <?php
			  if(isset($alert_message) && !empty($alert_message))
				 {
					echo '<div class="gat_error">'.$alert_message.'</div>';
				 }
		 ?>
		 <div class="gat_playlist_content">
		 	<?php
				$content = get_post_meta($post->ID, "playlist_content", true);
				echo '<p>' . $content . '</p>';
			?>
         </div>
		 <div class="gat_player_videos loadvideo">
			<div id="player" data-resultedid=''></div>
            <!--<div class="unclickablevideo" style="display: block;" title="Play from Playlist"></div>-->
         </div>
		 <!--<ul class="gat_domainsbmt_btn">
			<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default gat_button">Back to Home</a></li>
			<li>
            	<?php
					$response = PLUGIN_PREFIX . "response";
					$sql = $wpdb->prepare("select email from $response where assessment_id = %d AND token = %s", $post->ID, $token);
					$result = $wpdb->get_row($sql);
				?>
            	<form method="post">
                	<input type="hidden" name="email" value="<?php echo $result->email; ?>" />
                	<input type="hidden" name="assessment_id" value="<?php echo $post->ID; ?>" />
                	<input type="submit" class="btn btn-default gat_button" name="email_results" value="Email Results & Playlist" />
                </form>
            </li>
			<li><a href="<?php echo get_permalink($post->ID); ?>?action=analysis-result" class="btn btn-default gat_button">Get Results</a></li>
		  </ul>-->
	</div>
        <div class="col-md-4 col-sm-12 col-xs-12 gat-video-list">
		<div class="gat-video-sidebar">
            <div class="gat_priority_form">
			<form method="get" action="<?php echo get_permalink($post->ID); ?>?action=video-playlist&sortby=" id="gat_priorityfrm">
				<div class="gat_priority_form_label"><label>Videos:</label></div>
				<div class="gat_priority_form_selector">
					<select name="sortby" onchange="priority_submit(this);">
						<option value="priority" <?php echo $a = ($_GET["sortby"] == 'priority') ? 'selected="selected"' : ''; ?>>Recommended For You</option>
						<option value="unwatched" <?php echo $a= ($_GET["sortby"] == 'unwatched') ? 'selected="selected"' : ''; ?> >Unwatched</option>
						<!--<option value="domains" <?php echo $a = ($_GET["sortby"] == 'domains') ? 'selected="selected"' : ''; ?> >Focus Areas</option>-->
						<option value="domains" <?php echo $a = ($_GET["sortby"] == 'domains') ? 'selected="selected"' : ''; ?> >All Videos</option>
						<?php
							$args = array(
								      'post_type' => 'domain',
								      'orderby' => 'id',
								      'order' => 'ASC'
								);
							$domains = get_posts($args);
							foreach($domains as $domain){
								?>
									<option value="<?php echo $domain->ID ?>" <?php echo $a = ($_GET["sortby"] == $domain->ID) ? 'selected="selected"' : ''; ?> > - <?php echo $domain->post_title; ?></option>
								<?php
							}
						?>
					</select>
				</div>

			</form>
			</div>
			<!--<div class="clear"></div>-->
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
								  height: '400',
								  width: '720',
								  videoId: '".$data_rslts[0]->youtubeid."',
								  playerVars: {
									  'autoplay': 0,
									  'controls': 1,
									  'rel' : 0
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
						  </script>
						  <script>
							jQuery(document).ready(function(e) {
								jQuery('.cntrollorbtn').click(function(){
									var utubeid = jQuery(this).attr('data-youtubeid');
									utubeid = String(utubeid);
									var currenid = jQuery(this).attr('data-resultedid');
									jQuery('#player').attr('data-resultedid', currenid );
									player.loadVideoById(utubeid);
								});
								jQuery('.cntrollorbtn').keypress(function(e){
									var key = e.which;
									if (key==13)
										jQuery(this).trigger('click');
								});
							});
						  </script>
						  ";
					$i=0;
					foreach($data_rslts as $data_rslt)
					{
						$defaultvideo = ($i==0)?' defaultvideo':'';
						$resulted_video = PLUGIN_PREFIX . "resulted_video";
						$sql = $wpdb->prepare( "select * from $resulted_video where assessment_id = %d AND domain_id = %d AND dimensions_id = %d AND token= %s AND youtubeid= %s", $post->ID, $data_rslt->domain_id, $data_rslt->dimensions_id, $token, $data_rslt->youtubeid );
						$exists = $wpdb->get_row($sql);
						if(!empty($exists))
						{
							echo '<li>';
								echo '<div class="gat_imgcntnr">
										<span tabindex="0" class="cntrollorbtn'.$defaultvideo.'" data-resultedid="'.$exists->id.'" data-youtubeid="'.$exists->youtubeid.'"><img src="http://img.youtube.com/vi/'.$exists->youtubeid.'/default.jpg" /></span>';

								if (!($exists->seek == NULL || $exists->seek == '')){
									echo '<span class="watched">Watched</span>';
								}
								echo '	  </div>';
								echo '<div class="gat_desccntnr">';
									echo '<span  tabindex="0" class="video-title cntrollorbtn" data-resultedid="'.$exists->id.'" data-youtubeid="'.$exists->youtubeid.'">'.ucwords(stripslashes($data_rslt->label)).'</span>';
									echo '<span class="video-domain-title"> - '.ucwords(stripslashes(get_the_title($exists->domain_id))).' </span>';
								echo '</div>';
								/*echo '<div class="gat_videodetails" style="display:none;>';
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
								echo '<div class="unclickable" style="display:none"></div>';*/
							echo '</li>';
						}
						else
						{
							$sql = $wpdb->prepare("insert into $resulted_video (assessment_id, domain_id, dimensions_id, token, youtubeid) values (%d, %d, %d, %s, %s)", $post->ID, $data_rslt->domain_id, $data_rslt->dimensions_id, $token, $data_rslt->youtubeid);
							$wpdb->query($sql);
							$lastid = $wpdb->insert_id;
							echo '<li>';
								echo '<div class="gat_imgcntnr">
										<img src="http://img.youtube.com/vi/'.$data_rslt->youtubeid.'/default.jpg" />
									  </div>';
								echo '<div class="gat_desccntnr">';
									echo '<span class="video-title">'.ucwords(stripslashes($data_rslt->label)).'</span>';
									echo '<span class="video-domain-title"> - '.ucwords(stripslashes(get_the_title($exists->domain_id))).' </span>';
								echo '</div>';
							echo '</li>';
						}
						$i++;
					}
				} else {
					echo '<li>No videos found!</li>';
				}
			?>
		 </ul>
		 <div class="email-list"><?php
					$response = PLUGIN_PREFIX . "response";
					$sql = $wpdb->prepare("select email from $response where assessment_id = %d AND token = %s", $post->ID, $token);
					$result = $wpdb->get_row($sql);
				?>
            	<form id="email_playlist_form" method="post">
                	<input type="hidden" id="email" name="email" value="<?php echo $result->email; ?>" />
                	<input type="hidden" id="assessment_id" name="assessment_id" value="<?php echo $post->ID; ?>" />
                	<input type="submit" tabindex="0" id="gat_email_results_playlist_link" class="btn btn-default gat_button gat_email_results_button" name="email_results" value="Email My Playlist" />
                </form></div><div class="clear"></div>
		 </div>
		 <div class="browse-library center">
			<a href="<?php echo get_permalink($post->ID); ?>?action=full-video-library" tabindex="0" class="btn btn-default gat_button gat_button_browse_library">Browse Full Video Library</a>
		 </div><div class="clear"></div>
	</div>