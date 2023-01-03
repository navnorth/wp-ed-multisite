jQuery.getScript('//www.youtube.com/player_api');

var arrPlayer = [];
sideytplayer = {
    init: function(container, videoId, instance) {
        if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {
            window.onYouTubePlayerAPIReady = function() {
                setTimeout(function(){ 
                    console.log('wow1');               
                    var numItems = jQuery('.oet_youtube_side_container').length;
                    jQuery('.oet_youtube_side_container').each(function() {
                        var ctrn = jQuery(this).attr('id');
                        var yid = jQuery(this).attr('yid');
                        var inst = jQuery(this).attr('inst');
                        var type = jQuery(this).attr('ytype');
                        var pid = jQuery(this).attr('ypid');
                        console.log(ctrn+'--'+yid+'--'+inst+'--'+type+'--'+pid);
                        sideytplayer.loadPlayer(ctrn, yid, inst, type, pid);
                    });
                }, 1000);
            };
            console.log('wow2');
            //jQuery.getScript('//www.youtube.com/player_api');
        } else {
            console.log('wow3');
            sideytplayer.loadPlayer(container, videoId, instance);
        }
    },
    loadPlayer: function(container, videoId, instance, type, playlistId) {
        if (type=="playlist"){
            arrPlayer[instance] = new YT.Player(container, {
                playerVars: {
                    modestbranding: 1,
                    rel: 0,
                    showinfo: 0,
                    autoplay: 0,
                    listType:type,
                    list: playlistId,
                    origin: oet_object.domain
                },
                height: 480,
                width: 854,
                videoId: videoId,
                events: {
                    //'onReady' : this.onPlaylistReady
                      //'onStateChange': onPlayerStateChange
                }
            });
        } else {
            arrPlayer[instance] = new YT.Player(container, {
                playerVars: {
                    modestbranding: 1,
                    rel: 0,
                    showinfo: 0,
                    autoplay: 0,
                    origin: oet_object.domain
                },
                height: 480,
                width: 854,
                videoId: videoId,
                events: {
                      //'onStateChange': onPlayerStateChange
                }
            });
        }
    },
    play:function(inst){
        arrPlayer[inst].playVideo();
    },
    pause:function(inst){
      arrPlayer[inst].pauseVideo();
    }
};

window.setInterval(function(){
    jQuery('.oet-youtube-modal-wrapper .modal').focus();
}, 1000);


if (jQuery('.oet_youtube_side_container').length)
    sideytplayer.init();