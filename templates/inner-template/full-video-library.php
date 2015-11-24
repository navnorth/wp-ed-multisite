<?php
    global $wpdb;
    $results_table = PLUGIN_PREFIX . "results";
    $videotable = PLUGIN_PREFIX . "videos";
    $dimensionstable = PLUGIN_PREFIX . "dimensions";
    $watchtable = PLUGIN_PREFIX . "resulted_video";
    $token = htmlspecialchars($_COOKIE['GAT_token']);
?>
<a id="content" tabindex="0"></a>
<div class="col-md-12 col-sm-12 col-xs-12 full-video-library">
    <h3><?php echo get_the_title($post->ID) . ": " . "Full Video Library"; ?></h3>
    <div class="gat_content">
        <?php
            $content = get_post_meta($post->ID, "full_library_content", true);
	    echo '<p>' . $content . '</p>';
        ?>
    </div>
    <?php
    if (isset($_GET['videoId']))
    {
		$videoId = $_GET['videoId'];

		//Get Video Label
		$sql = $wpdb->prepare("select id, youtubeid, label from $videotable where youtubeid = %s", $videoId);
		$vid_result = $wpdb->get_results($sql);

		//If first time watching the video, insert playback tracker
		$sql = $wpdb->prepare("select id, youtubeid, token, assessment_id from $watchtable
			where youtubeid = %s and token = %s and assessment_id = %d", $videoId, $token, $post->ID);
		$watch_result = $wpdb->get_results($sql);
		if (empty($watch_result)) {
			$sql = $wpdb->prepare("insert into $watchtable (assessment_id, domain_id, dimensions_id, token, youtubeid) values (%d, 0, 0, %s, %s)", $post->ID, $token, $videoId);
			$wpdb->query($sql);
			$lastid = $wpdb->insert_id;
		}

		if ($vid_result)
		    $videoLabel = $vid_result[0]->label;

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
		    var videoLabel;
		    function onYouTubeIframeAPIReady_LoadPlayer()
		    {
			    player = new YT.Player('player', {
			      height: '480',
			      width: '100%',
			      videoId: '".$videoId."',
			      playerVars: {
				      'autoplay': 1,
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
			    videoLabel = '". $videoLabel . "';
			    switch (event.data) {
				    case YT.PlayerState.PLAYING:
					    if (cleanTime() == 0) {
						    ga('send', 'event', 'GAT Library Video: ' + videoLabel, 'Play', videoId);
					    } else {
						    ga('send', 'event', 'GAT Library Video: ' + videoLabel, 'Play', 'v: ' + videoId + ' | t: ' + cleanTime());
					    };
				    break;
				    case YT.PlayerState.PAUSED:
						trackrecordbyid(". $post->ID . ", '". $token . "', videoId);

					    if (player.getDuration() - player.getCurrentTime() != 0) {
							ga('send', 'event', 'GAT Library Video: ' + videoLabel, 'Pause', 'v: ' + videoId + ' | t: ' + cleanTime());
					    } else {
							ga('send', 'event', 'GAT Library Video: ' + videoLabel, 'Pause', videoId );
					    };
				    break;
				    case YT.PlayerState.ENDED:
					    trackrecordbyid(". $post->ID . ", '". $token . "', videoId);

					    ga('send', 'event', 'GAT Library Video: ' + videoLabel, 'Finished', videoId);
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
			window.onbeforeunload = function() {
			    player.pauseVideo();
			}
			jQuery('.video-link').click(function(){
				player.pauseVideo();
				var utubeid = jQuery(this).attr('data-youtubeid');
				utubeid = String(utubeid);
				var currenid = jQuery(this).attr('data-resultedid');
				jQuery('#player').attr('data-resultedid', currenid );
				player.loadVideoById(utubeid);
			});
			jQuery('.video-link').keypress(function(e){
				var key = e.which;
				if (key==13)
					jQuery(this).trigger('click');
			});
		    });
	      </script>
	      ";
	    ?>
	    <div class="video-player">
		<div id="player"></div>
	    </div>
	    <?php
    }
    ?>
    <div class="video-list">
        <?php
        $domainids = get_domainid_by_assementid($post->ID);

        foreach($domainids as $domainid) {
            $domain = get_post($domainid);
            unset($vid_list_distinct);

			//Get Videos per domain
			$sql = $wpdb->prepare("SELECT a.* FROM $videotable as a
					      INNER JOIN $dimensionstable as b
					      	ON (a.dimensions_id=b.id) AND (a.domain_id=b.domain_id)

					      WHERE b.assessment_id=%d and a.domain_id=%d
					      ORDER BY a.dimensions_id",
					      $post->ID, $domainid);
			$vid_results = $wpdb->get_results($sql);

			//flag to disable button if there are no videos
			$disabled = "";
			if (empty($vid_results)) {
			    $disabled = "scroll-disabled";
			}
            ?>
            <div class="vlist">
                <h4><?php echo $domain->post_title; ?></h4>
	    		<div class="scroll-left scroll-disabled"></div>
	   			<div class="gat-library-videos" tabindex="0" data-count="<?php echo count($vid_results); ?>">

			<?php
			//Show Videos in a list
			if (!empty($vid_results)) {
			    ?>
			    <ul>
				<?php
				foreach ($vid_results as $video) {
					// don't display duplicates
					if (!is_array($vid_list_distinct) || !in_array($video->youtubeid, $vid_list_distinct, true )) {
						$vid_list_distinct[] = $video->youtubeid;
				?>

					<li>
					    <div class="gat_imgcntnr">
						 <?php
						//Checking for watched video
						$sql = $wpdb->prepare( "select * from $watchtable where assessment_id = %d AND token= %s AND youtubeid= %s",
								      $post->ID, $token, $video->youtubeid );
						$exists = $wpdb->get_row($sql);
						$current = "";
						if (isset($videoId) && $videoId==$video->youtubeid){
						    $current = " current-video";
						}
					       ?>
						<a class="video-link<?php echo $current; ?>" <?php if (!empty($exists)) { echo 'data-resultedid="'.$exists->id.'"'; } ?> href="<?php echo get_permalink($post->ID); ?>?action=full-video-library&videoId=<?php echo $video->youtubeid; ?>" data-youtubeid="<?php echo $video->youtubeid; ?>" title="Watch: <?php echo stripslashes($video->label); ?>">
						   <img src="//img.youtube.com/vi/<?php echo $video->youtubeid; ?>/mqdefault.jpg" width="240" height="135" alt="thumbnail: <?php echo stripslashes($video->label); ?>">
						    <?php
							if(!empty($exists))
							{
								if (!($exists->seek == NULL || $exists->seek == '')) {
									echo '<span class="watched">Watched</span>';
							    }
							}
						    ?>
						</a>
						<div class="gat-video-title"><a class="video-link<?php echo $current; ?>" <?php if (!empty($exists)) { echo 'data-resultedid="'.$exists->id.'"'; } ?> href="<?php echo get_permalink($post->ID); ?>?action=full-video-library&videoId=<?php echo $video->youtubeid; ?>" data-youtubeid="<?php echo $video->youtubeid; ?>" title="Watch: <?php echo stripslashes($video->label); ?>"><strong><?php echo stripslashes($video->label); ?></strong></a></div>
					    </div>
					</li>
				<?php
					}
				}
				?>
			    </ul>
			    <?php
			} else {
			    ?>
			    <p>No Videos Available!</p>
			    <?php
			}
		    ?>
		    </div>
		    <div class="scroll-right <?php echo $disabled ?>"></div>
                </div>
                <?php
            }
        ?>
    </div>

    <ul class="gat_domainsbmt_btn">
		<li><a href="<?php echo get_permalink($post->ID); ?>?action=video-playlist" class="btn btn-default gat_button">Get Your Custom Video Playlist</a></li>
	</ul>

</div>