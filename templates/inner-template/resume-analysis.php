<?php
    $content = get_the_content($post->ID);
    $content = apply_filters('the_content', $content);

    // get progress, to display continue or results button
    $assess_data = get_GAT_response($post->ID, htmlspecialchars($_COOKIE['GAT_token']));
?>
<a id="content" tabindex="0"></a>
<div class="col-md-9 col-sm-12 col-xs-12">
    <h3><?php echo get_the_title($post->ID); ?></h3>
   
    <?php
	//Tracking Video on Main Gat Page
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
	    var player;
	    function onYouTubeIframeAPIReady_LoadPlayer()
	    {
		var iFrame = document.getElementsByTagName('iframe')[0];
		var playerId = String(iFrame.getAttribute('id'));
		    player = new YT.Player('player', {
			height: '',
			width: '',
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
		console.log(event.data);
		    var url = event.target.getVideoUrl();
		    var match = url.match(/[?&]v=([^&]+)/);
		    if( match != null)
		    {
			    var videoId = match[1];
		    }
		    switch (event.data) {
			    case YT.PlayerState.PLAYING:
				console.log('playing');
				ga('send', 'event', 'video', 'started', videoId);
			    break;
			    case YT.PlayerState.PAUSED:
				console.log('paused');
				ga('send', 'event', 'video', 'paused', videoId);
			    break;
			    case YT.PlayerState.ENDED:
				console.log('finished');
				ga('send', 'event', 'video', 'ended', videoId );
			    break;
		    };
	     }
      </script>
      <script>
	jQuery(document).ready(function(e) {
		loadPlayer();
	});
      </script>";
    ?>
   
    <div class="gat_moreContent">
        <?php echo $content; ?>
    </div>

    <div class="get_domainlist_button">
    	<ul class="gat_domainsbmt_btn">
    	    <?php if ($assess_data->progress==100) : ?>
        	    <li><a href="<?php echo get_permalink($post->ID); ?>?action=analysis-result" class="btn btn-default gat_button">Get Results</a></li>
        	    <li><a href="<?php echo get_permalink($post->ID); ?>?action=video-playlist" class="btn btn-default gat_button">Get Your Video Playlist</a></li>
    	    <?php endif; ?>
    	    <li class="right<?php if($assess_data->progress==100) echo ' retake' ?>"><a class="btn btn-default gat_button_continue btn-right" href="<?php echo get_permalink()."?action=token-saved&list=1"; ?>" role="button"><?php if($assess_data->progress==100) echo 'Retake'; else echo 'Continue'; ?></a></li>
    	</ul>
   </div>
</div>

<div class="col-md-3 col-sm-12 col-xs-12">
    <div class="gat_sharing_widget">
        <!-- p class="pblctn_scl_icn_hedng"> Share the GAP analysis tool </p -->
        <div class="pblctn_scl_icns">
            <?php echo do_shortcode("[ssba]"); ?>
        </div>
    </div>


    <?php progress_indicator_sidebar($post->ID, htmlspecialchars($_COOKIE['GAT_token'])); ?>
</div>
