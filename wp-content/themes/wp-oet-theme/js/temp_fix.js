jQuery(document).ready(function(){

    // This code loads the IFrame Player API code asynchronously 
    var tag = document.createElement('script'); 
    tag.src = "https://www.youtube.com/iframe_api"; 
    var ytplayer = []; 
    var yplayer;
    var pauseFlag = false; 
    var gaSent = false; 
    var playQueue = {
        content:null,
        push: function(fn) {
            this.content = fn;
        },
        pop: function() {
            this.content.call();
            this.content = null;
        }
    }
    var firstScriptTag = document.getElementsByTagName('script')[0]; 
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); 

    // This code is called by the YouTube API to create the player object 
    window.onYouTubePlayerAPIReady = function() { 
        setTimeout(function(){  
            console.log('YT loading'); 
            loadYTPlayers(); 
        }, 6000);  
    }
    
    jQuery('.vdo_bg').each(function(index){
        let pId = index+1;
        let vidLink = jQuery(this).find('a.oet-video-link');
        
        vidLink.removeClass('oet-video-link');
        vidLink.addClass('oet-video-temp-link')
        vidLink.attr('data-Id',pId);
        vidLink.attr('data-target','#oet-video-overlayytvideo'+pId.toString());
        jQuery(this).find('.modal').attr('id','oet-video-overlayytvideo'+pId.toString());
        jQuery(this).find('.modal').attr('data-Id',pId);
        
    });

    jQuery(document).on('click','a.oet-video-temp-link', function(e){
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
        let Id = jQuery(this).attr('data-Id');
        console.log(Id);
        setTimeout(function(){  
            if(typeof ytplayer[Id] != 'undefined'){
                ytplayer[Id].playVideo();
            }
        }, 2000);
    });

    /*jQuery(document).on('click','div[id^="oet-video-overlay"]', function(e){
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
        let Id = jQuery(this).attr('data-Id');
        console.log(Id);
        setTimeout(function(){  
                oet_toggletempmodal(0, Id);
        },1000);
    });*/

    jQuery(document).on('shown.bs.modal', ".oet-video-overlay", function(e){
        e.preventDefault();
        let pId = jQuery(this).attr('data-Id');
        var vidSrc = jQuery(this).children('iframe').attr('src');
        console.log(ytplayer[pId]);
        if (typeof ytplayer[pId].playVideo == 'function'){
            ytplayer[pId].playVideo();
        } else {
            playQueue.push(function(){ ytplayer[pId].playVideo(); })
            var fn = function() {
                ytplayer[pId].playVideo();
            }
            setTimeout(fn, 2000);
        }
        //jQuery(this).children('iframe').attr('src', vidSrc);
        jQuery(this).fadeIn();
    });

    jQuery(document).on('hidden.bs.modal', ".oet-video-overlay", function(e){

        e.preventDefault();

        let pId = jQuery(this).attr('data-Id');
        console.log(ytplayer[pId]);
        if (typeof ytplayer[pId].pauseVideo == 'function'){
            ytplayer[pId].pauseVideo();
        } else {
            var fn = function() {
                ytplayer[pId].pauseVideo();
            }
            setTimeout(fn, 2000);
        }
        //jQuery(this).children('iframe').attr('src', '');
        jQuery(this).fadeOut();
    });

    /*setTimeout(function(){  
        console.log('YT loading'); 
        loadYTPlayers(); 
        if (typeof(player)!=='undefined')
            player = null;
    }, 10000);  */

    function onTempPlayerError(event) { 
        if (event.data) { 
            if (gaSent === false) { 
                ga('send',  'event', 'Featured Video: STEM', 'Failed', ''  ); 
                gaSent = true; 
            } 
        } 
    } 

    function onTempPlayerStateChange(event) { 
        videoId = 0;
        if (typeof(event.target)!=="undefined"  && typeof(event.target.getVideoUrl)=="function") {
            var url = event.target.getVideoUrl(); 
            var match = url.match(/[?&]v=([^&]+)/); 
            if( match != null) 
            { 
                var videoId = match[1]; 
            } 
            videoId = String(videoId); 
        }
        // track when user clicks to Play 
        if (event.data == YT.PlayerState.PLAYING) { 
            console.log('playing'); 
            ga('send','event','Featured Video: STEM','Play', videoId);
            pauseFlag = true; 
        }
        // track when user clicks to Pause 
        if (event.data == YT.PlayerState.PAUSED && pauseFlag) { 
            console.log('pausing');
            ga('send','event','Featured Video: STEM', 'Pause', videoId); 
            pauseFlag = false; 
        } 
        // track when video ends 
        if (event.data == YT.PlayerState.ENDED) { 
            console.log('stoping');
            ga('send', 'event','Featured Video: STEM', 'Finished', videoId); 
        }
    } 

    function oet_toggletempmodal(bol, Id){
      if(bol){ //show and play
        console.log(ytplayer[Id]);
        if (typeof(ytplayer[Id]) !== 'undefined'  && typeof ytplayer[Id].playVideo == 'function'){ 
            ytplayer[Id].playVideo();
        } 
        jQuery('#oet-video-overlayytvideo'+Id).modal('show');
      }else{ //pause and hide
        if (typeof(ytplayer[Id]) !== 'undefined'  && typeof ytplayer[Id].pauseVideo == 'function'){ 
            console.log(ytplayer[Id]);
            ytplayer[Id].pauseVideo();
        } 
        jQuery('#oet-video-overlayytvideo'+Id).modal('hide');
      }
    }


    function loadYTPlayers() {
        vids = ['GBT4f146h9U','Aki99TM5MMI','7ssz7ZiHoTo','OLyIZaUw0m8','0BDYGOEsSoA','yvl_xTXGcs8','V3XlKqEDtR4','QX18iiFWtP8','MJOGK--sNdY','4RvgEIJsRek'];
        jQuery.each(vids, function(key,value){
            let id = key+1;
            setTimeout(function(){  
                loadYTPlayer(value,id.toString());
            }, 1000);
        });
    }

    function loadYTPlayer(videoId, Id) { 
        var playerId = 'ytvideo' + Id;
        ytplayer[Id] = new YT.Player(playerId, { 
        videoId: videoId, 
        playerVars: { 
            'autoplay': 0, 
            'controls': 1, 
            'enablejsapi': 1, 
            'rel' : 0, 
            'origin' : 'https://oet-test.navigationnorth.com', 
            'host' : 'https://www.youtube.com' 
        }, 
        events: { 
            'onError': onTempPlayerError, 
            'onReady': onTempPlayerReady, 
            'onStateChange': onTempPlayerStateChange 
            } 
        }); 
    } 

    function onTempPlayerReady(event) { 
        // do nothing, no tracking needed 
        //console.log(playQueue);
        //if (playQueue.content) playQueue.pop();
    } 
});