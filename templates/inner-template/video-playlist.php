<?php
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";
	$videotable = PLUGIN_PREFIX . "videos";
	$watchtable = PLUGIN_PREFIX . "resulted_video";
	$token = htmlspecialchars($_COOKIE['GAT_token']);

	//
	$total_dimensions = get_total_dimensioncount($post->ID);
	$total_rated = get_total_ratedcount($post->ID, $token);

	if ($total_rated<$total_dimensions){
		echo '<script type="text/javascript">window.location = "'.get_permalink($post->ID).'"</script>';
	}

	// default to priority playlist
	$playlist_selection = (isset($_GET["sortby"]) && !empty($_GET["sortby"])) ? $_GET["sortby"] : 'priority';

	switch ($playlist_selection) {
		case "priority":
			$sql = $wpdb->prepare("SELECT DISTINCT a.id, a.youtubeid, a.label FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
				where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.assessment_id=%d AND (<condition>) ORDER BY b.rating_scale ASC", $token, $post->ID);
			$sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('%".'"'."', b.rating_scale, '".'"'."%') OR
	 			a.`rating_scale` LIKE IF((b.rating_scale = NULL OR b.rating_scale = ''), '%1%', b.rating_scale)", $sql));

			$data_rslts = $wpdb->get_results($sql);
			break;
		case "domains":
			$sql = $wpdb->prepare("SELECT a.id, a.youtubeid, a.label FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
				where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.assessment_id=%d AND (<condition>) ORDER BY b.domain_id ASC", $token, $post->ID);
			$sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('%".'"'."', b. `rating_scale`, '".'"'."%')", $sql));
			$data_rslts = $wpdb->get_results($sql);
			break;
		case "unwatched":
			$sql = $wpdb->prepare("SELECT distinct V.label, V.youtubeid FROM $videotable as V inner join $results_table AS X ON X.domain_id = V.domain_id
				INNER JOIN $watchtable AS R on R.assessment_id = X.assessment_id
				WHERE X.assessment_id = %d AND R.token = %s
					AND V.youtubeID NOT IN (SELECT youtubeID FROM $watchtable WHERE assessment_id=%d AND token=%s and seek > 1)
				ORDER BY R.id DESC", $post->ID, $token, $post->ID, $token);
			$data_rslts = $wpdb->get_results($sql);
			break;
		// not sure when this gets used, if ever.
		default:
			$sql = $wpdb->prepare("SELECT DISTINCT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
				where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token=%s AND b.assessment_id=%d AND b.domain_id=%d AND (<condition>) ORDER BY b.rating_scale ASC", $token, $post->ID, $_GET['sortby']);
			$sql = stripslashes(str_replace("<condition>", "a.`rating_scale` LIKE CONCAT('%".'"'."', b.rating_scale, '".'"'."%') OR
				a.`rating_scale` LIKE IF((b.rating_scale = NULL OR b.rating_scale = ''), '%1%', b.rating_scale)", $sql));
			$data_rslts = $wpdb->get_results($sql);
			break;
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
		 <ul class="gat_domainsbmt_btn">
			<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default gat_button">Back to Home</a></li>
		  </ul>
	</div>
        <div class="col-md-4 col-sm-12 col-xs-12 gat-video-list">
		<div class="gat-video-sidebar">
            <div class="gat_priority_form">
			<form method="get" action="<?php echo get_permalink($post->ID); ?>?action=video-playlist&sortby=" id="gat_priorityfrm">
				<div class="gat_priority_form_label"><label>Videos:</label></div>
				<div class="gat_priority_form_selector">
					<select name="sortby" onchange="priority_submit(this);">
						<option value="priority" <?php echo $a = ($_GET["sortby"] == 'priority') ? 'selected="selected"' : ''; ?>>Recommended For You</option>
						<?php
							$domainids = get_domainid_by_assementid($post->ID);

							foreach($domainids as $domainid) {
								$domain = get_post($domainid);
								?>
									<option value="<?php echo $domain->ID ?>" <?php echo $a = ($_GET["sortby"] == $domain->ID) ? 'selected="selected"' : ''; ?> > - <?php echo $domain->post_title; ?></option>
								<?php
							}
						?>
						<option value="unwatched" <?php echo $a= ($_GET["sortby"] == 'unwatched') ? 'selected="selected"' : ''; ?> >Unwatched</option>
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
							function loadPlayer() {
								if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {

									var tag = document.createElement('script');
									tag.src = '//www.youtube.com/iframe_api';
									var firstScriptTag = document.getElementsByTagName('script')[0];
									firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

									window.onYouTubeIframeAPIReady = function() {
									  onYouTubeIframeAPIReady_LoadPlayer();
									};

								} else {

									onYouTubeIframeAPIReady_LoadPlayer();

								}
							}
							/*var tag = document.createElement('script');
							tag.src = '//www.youtube.com/iframe_api';

							var firstScriptTag = document.getElementsByTagName('script')[0];
							firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);*/

							var player;

							function onYouTubeIframeAPIReady_LoadPlayer()
							{
								player = new YT.Player('player', {
								  height: '400',
								  width: '720',
								  videoId: '".$data_rslts[0]->youtubeid."',
								  playerVars: {
									  'autoplay': 0,
									  'controls': 1,
									  'rel' : 0,
									  'wmode' : 'transparent'
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
								var videoLabel = '". $data_rslts[0]->label ."';
								videoLabel = jQuery('.cntrollorbtn[data-youtubeid=' + videoId +']').attr('data-label');
								switch (event.data) {
									case YT.PlayerState.PLAYING:
										if (cleanTime() == 0) {
											ga('send', 'event', 'GAT Playlist Video: ' + videoLabel, 'Play', videoId );
										} else {
											ga('send', 'event', 'GAT Playlist Video: ' + videoLabel, 'Play', 'v: ' + videoId + ' | t: ' + cleanTime());
										};
									break;
									case YT.PlayerState.PAUSED:
										trackrecordbyid(". $post->ID . ", '". $token . "', videoId);

										if (player.getDuration() - player.getCurrentTime() != 0) {
											ga('send', 'event', 'GAT Playlist Video: ' + videoLabel, 'Pause', 'v: ' + videoId + ' | t: ' + cleanTime());
										} else {
											ga('send', 'event', 'GAT Playlist Video: ' + videoLabel, 'Pause', videoId );
										};
									break;
									case YT.PlayerState.ENDED:
										trackrecordbyid(". $post->ID . ", '". $token . "', videoId);

										ga('send', 'event', 'GAT Playlist Video: ' + videoLabel, 'Finished', videoId );
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
								loadPlayer();
								jQuery('.cntrollorbtn').click(function(){
									player.pauseVideo();
									var utubeid = jQuery(this).attr('data-youtubeid');
									utubeid = String(utubeid);
									var videoTitle = jQuery(this).attr('data-label');
									var currenid = jQuery(this).attr('data-resultedid');
									jQuery('#player').attr({'data-resultedid': currenid, 'data-label' : videoTitle });
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

						// don't display duplicates
						if (!is_array($vid_list_distinct) || !in_array($data_rslt->youtubeid, $vid_list_distinct, true )) {
							$vid_list_distinct[] = $data_rslt->youtubeid;

							$sql = $wpdb->prepare( "select id,seek,youtubeid from $watchtable where assessment_id = %d AND token= %s AND youtubeid= %s limit 1", $post->ID, $token, $data_rslt->youtubeid );
							$exists = $wpdb->get_row($sql);
							$exists_id = $exists->id;;

							if(empty($exists))
							{
								$sql = $wpdb->prepare("insert into $watchtable (assessment_id, domain_id, dimensions_id, token, youtubeid) values (%d, 0, 0, %s, %s)", $post->ID, $token, $data_rslt->youtubeid);
								$wpdb->query($sql);
								$exists_id = $wpdb->insert_id;
							}

							echo '<li>';
								echo '<div class="gat_imgcntnr">
										<span tabindex="0" class="cntrollorbtn'.$defaultvideo.'" data-resultedid="'.$exists->id.'" data-youtubeid="'.$data_rslt->youtubeid.'" data-label="'.ucwords($data_rslt->label).'"><img src="//img.youtube.com/vi/'.$data_rslt->youtubeid.'/mqdefault.jpg" class="gat_vid_thumbnail" alt="thumbnail: '.ucwords(stripslashes($data_rslt->label)).'" /></span>';

								if (!($exists->seek == NULL || $exists->seek == '')){
									echo '<span class="watched">Watched</span>';
								}
								echo '	  </div>';
								echo '<div class="gat_desccntnr">';
									echo '<span  tabindex="0" class="video-title cntrollorbtn" data-resultedid="'.$exists_id.'" data-youtubeid="'.$data_rslt->youtubeid.'"  data-label="'.ucwords($data_rslt->label).'">'.ucwords(stripslashes($data_rslt->label)).'</span>';
									echo '<span class="video-domain-title"> - '.ucwords(stripslashes(get_the_title($data_rslts->domain_id))).' </span>';
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

							$i++;
						}
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
