window.oeseblkFeatVideoOrigin = oese_featured_video_block_video_origin;
jQuery(window).bind("load", function() {
    //YOUTUBE API
    setTimeout(function(){
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }, 1000);
});


//YOUTUBE API
var oese_featured_video_block_player = [];
function onYouTubeIframeAPIReady() {
  jQuery.each(jQuery('.oese-embedded-youtube-video'), function(i, elm) { 
    //let blkid = jQuery(elm).attr('blkid');
    let blkid = jQuery(elm).attr('id');
    blkid = blkid.replace("oese-embedded-youtube-video-", "");
    let ytid = jQuery("#oese-embedded-youtube-video-"+blkid+" .oese-featured-video-block-youtubeid").val();
    oese_featured_video_block_player[blkid] = new YT.Player('oese-embedded-youtube-video-container-'+blkid, {
      height: '450',
      width: '800',
      videoId: ytid,
      playerVars: {
        autoplay: 1, // Auto-play the video on load
        controls: 1, // Show pause/play buttons in player
        showinfo: 0, // Hide the video title
        modestbranding: 1, // Hide the Youtube Logo
        loop: 0, // Run the video in a loop
        fs: 0, // Hide the full screen button
        cc_load_policy: 0, // Hide closed captions
        iv_load_policy: 3, // Hide the Video Annotations
        autohide: 0, // Hide video controls when playing
        rel: 0,
        origin: window.oeseblkFeatVideoOrigin
      },
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
    
    jQuery(document).on('click','.oese-featured-video-block-wrapper-'+blkid+' .oese-featured-video-block-embed',function(e){
      jQuery('body').addClass('modal-open');
      jQuery('.oese-featured-video-block-modal-'+blkid).show(500);
      oese_featured_video_block_player[blkid].playVideo();
    })
    
    jQuery(document).on('click','.oese-featured-video-block-modal-'+blkid,function(e){
      jQuery('body').removeClass('modal-open');
      oese_featured_video_block_player[blkid].pauseVideo();
      jQuery(this).closest('.oese-featured-video-block-modal-'+blkid).hide(500);
    })
    
    var pauseFlag = false;
    function onPlayerStateChange(event) {
      let vttl = jQuery('#oese-featured-video-block-modal-embed-content-'+blkid).attr('ttl');
      let vdid = jQuery('#oese-featured-video-block-modal-embed-content-'+blkid).attr('vid');
      
      // track when user clicks to Play
      if (event.data == YT.PlayerState.PLAYING) {
      	ga('send', 'event','Featured Video: '+ vttl, 'Play', vdid);
      	pauseFlag = true;
      }
      
      // track when user clicks to Pause
      if (event.data == YT.PlayerState.PAUSED && pauseFlag) {
      	ga('send', 'event','Featured Video: '+ vttl, 'Pause', vdid);
      	pauseFlag = false;
      }
      
      // track when video ends
      if (event.data == YT.PlayerState.ENDED) {
      	ga('send', 'event','Featured Video: '+ vttl, 'Finished', vdid);
    	}
      
    }
    
    function onPlayerReady(event) {
      //console.log('player is ready');
    }

    var done = false;
    function onPlayerReady(event) {
    	// do nothing, no tracking needed
    }
    
  });
  
  
}



/*
var oese_featured_video_block_player = [];
function onYouTubeIframeAPIReady() {
  jQuery.each(jQuery('.oese-featured-video-block-wrapper'), function(i, elm) { 
    //let blkid = jQuery(elm).attr('blkid');
    let blkid = jQuery(elm).attr('id');
    blkid = blkid.replace("oese-featured-video-block-wrapper-", "");
    oese_featured_video_block_player[blkid] = new YT.Player('oese-featured-video-block-modal-iframe-'+blkid, {
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
    
    jQuery(document).on('click','.oese-featured-video-block-wrapper-'+blkid+' .oese-featured-video-block-embed',function(e){
      jQuery('body').addClass('modal-open');
      jQuery('.oese-featured-video-block-modal-'+blkid).show(500);
      oese_featured_video_block_player[blkid].playVideo();

    })
    
    jQuery(document).on('click','.oese-featured-video-block-modal-'+blkid,function(e){
      jQuery('body').removeClass('modal-open');
      oese_featured_video_block_player[blkid].pauseVideo();
      jQuery(this).closest('.oese-featured-video-block-modal-'+blkid).hide(500);
    })
    
    var pauseFlag = false;
    function onPlayerStateChange(event) {
      let vttl = jQuery('#oese-featured-video-block-modal-embed-content-'+blkid).attr('ttl');
      let vdid = jQuery('#oese-featured-video-block-modal-embed-content-'+blkid).attr('vid');
      
      // track when user clicks to Play
      if (event.data == YT.PlayerState.PLAYING) {
      	ga('send', 'event','Featured Video: '+ vttl, 'Play', vdid);
      	pauseFlag = true;
      }
      
      // track when user clicks to Pause
      if (event.data == YT.PlayerState.PAUSED && pauseFlag) {
      	ga('send', 'event','Featured Video: '+ vttl, 'Pause', vdid);
      	pauseFlag = false;
      }
      
      // track when video ends
      if (event.data == YT.PlayerState.ENDED) {
      	ga('send', 'event','Featured Video: '+ vttl, 'Finished', vdid);
    	}
      
    }
    
    function onPlayerReady(event) {
      //console.log('player is ready');
    }
    
  });
  
}
*/



