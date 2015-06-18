<?php
	global $wpdb;
	$results_table = PLUGIN_PREFIX . "results";
	$videotable = PLUGIN_PREFIX . "videos";
	$watchtable = PLUGIN_PREFIX . "resulted_video";
	$token = $_COOKIE['GAT_token'];

	if(isset($_GET["sortby"]) && !empty($_GET["sortby"]))
	{
		switch ($_GET["sortby"]) {
			case "priority":
				$data_rslts = $wpdb->get_results("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token='$token' AND b.assessment_id=$post->ID AND a.`rating_scale` LIKE CONCAT('%', b. `rating_scale`, '%')  ORDER BY b.rating_scale ASC");
				break;
			case "domains":
				$data_rslts = $wpdb->get_results("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token='$token' AND b.assessment_id=$post->ID AND a.`rating_scale` LIKE CONCAT('%', b. `rating_scale`, '%')  ORDER BY b.domain_id ASC");
				break;
			case "watched":
				$data_rslts = $wpdb->get_results("SELECT a.*, ((a.seek/a.end)*100) as percent FROM $watchtable as a where assessment_id=$post->ID AND token='$token' ORDER BY CAST(percent as DECIMAL(10,5)) DESC");
				break;
		}
	}
	else
	{
		$data_rslts = $wpdb->get_results("SELECT a.* FROM $videotable as a LEFT JOIN $results_table as b ON(a.dimensions_id = b.dimension_id)
where (b.rating_scale != NULL OR b.rating_scale != '') AND b.token='$token' AND b.assessment_id=$post->ID AND a.`rating_scale` LIKE CONCAT('%', b. `rating_scale`, '%') ORDER BY b.rating_scale ASC");
	}
	?>
	<div class="col-md-9 col-sm-12 col-xs-12 analysis_result leftpad">
		 <h3><?php echo get_the_title($post->ID); ?></h3>
		 <p><?php echo apply_filters("the_content", get_the_content($post->ID)); ?></p>
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
									echo '<span>'.get_the_title($exists->domain_id).' : </span>';
									echo '<span>'.$data_rslt->label.'</span>';
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
							$wpdb->query("insert into $resulted_video (assessment_id, domain_id, dimensions_id, token, youtubeid) values ($post->ID, $data_rslt->domain_id, $data_rslt->dimensions_id, '$token', '$data_rslt->youtubeid')");
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

