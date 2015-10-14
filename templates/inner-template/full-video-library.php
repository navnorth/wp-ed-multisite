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
    if (isset($_GET['videoId'])) {
	$videoId = $_GET['videoId'];
	echo "<script type='text/javascript'>
	    var tag = document.createElement('script');
	    tag.src = 'https://www.youtube.com/iframe_api';
	    var firstScriptTag = document.getElementsByTagName('script')[0];
	    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	    var player;
	    function onYouTubeIframeAPIReady()
	    {
		    player = new YT.Player('player', {
		      height: '480',
		      width: '100%',
		      videoId: '".$videoId."',
		      playerVars: {
			      'autoplay': 1,
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
				    if (jQuery('.current-video').length>0){
					jQuery('#player').attr('data-resultedid',jQuery('.current-video').attr('data-resultedid'));
				    }
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
		    jQuery('.video-link').click(function(){
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
            foreach($domainids as $domainid){
                $domain = get_post($domainid);
		
		//Get Videos per domain
		$sql = $wpdb->prepare("SELECT a.* FROM $videotable as a
				      INNER JOIN $dimensionstable as b
				      ON (a.dimensions_id=b.id)
				      AND (a.domain_id=b.domain_id)
				      WHERE b.assessment_id=%d and a.domain_id=%d
				      ORDER BY a.dimensions_id",
				      $post->ID, $domainid);
		$vid_results = $wpdb->get_results($sql);
                ?>
                <div class="vlist">
                    <h4><?php echo $domain->post_title; ?></h4>
		    <div class="gat-library-videos">
		    <?php
			//Show Videos in a list
			if (!empty($vid_results)) {
			    ?>
			    <ul>
				<?php foreach ($vid_results as $video){ ?>
				<li>
				    <div class="gat_imgcntnr">
					 <?php
					//Checking for watched video
					$sql = $wpdb->prepare( "select * from $watchtable where assessment_id = %d AND domain_id = %d AND dimensions_id = %d AND token= %s AND youtubeid= %s",
							      $post->ID,
							      $video->domain_id,
							      $video->dimensions_id,
							      $token, $video->youtubeid );
					$exists = $wpdb->get_row($sql);
					$current = "";
					if (isset($videoId) && $videoId==$video->youtubeid){
					    $current = " current-video";
					}
				       ?>
					<a class="video-link<?php echo $current; ?>" <?php if (!empty($exists)) { echo 'data-resultedid="'.$exists->id.'"'; } ?> href="<?php echo get_permalink($post->ID); ?>?action=full-video-library&videoId=<?php echo $video->youtubeid; ?>" data-youtubeid="<?php echo $video->youtubeid; ?>">
					   <img src="http://img.youtube.com/vi/<?php echo $video->youtubeid; ?>/mqdefault.jpg" width="240" height="135">
					    <?php
						if(!empty($exists))
						  {
						      if (!($exists->seek == NULL || $exists->seek == '')){
							  echo '<span class="watched">Watched</span>';
						      }
						  }
					    ?>
					</a>
				    </div>
				</li>
				<?php } ?>
			    </ul>
			    <?php
			} else {
			    ?>
			    <p>No Videos Available!</p>
			    <?php 
			}
		    ?>
		    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>