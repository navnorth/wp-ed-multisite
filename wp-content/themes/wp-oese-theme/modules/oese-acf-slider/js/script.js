(function($) {
  let prevslide = 0;
  let gbl_pause = false;
  let fullyloaded = false;
  let paused = false;

      jQuery.fn.slider = function(first_creation, anim, autoplay, autoplay_interval) {

    		var $slider = $(this);


    		/* Variables */

    		var $slides = $slider.find('.slide'),
              	$arrows = $slider.find('.arrow'),
    		$next = $slider.find('.next'),
    		$previous = $slider.find('.previous'),
              	$bullets_container = $slider.find('.bullet-list'),
    		$bullets = $slider.find('.bullet');

          let indice = 0,
              timer,
              progress = 0;


    		/* Functions */

      	function create_bullets() {
                	var li;
      		jQuery('.slide').each(function(i,obj) {
            var slide_title = jQuery(obj).find('.slide-content >a >h3').text();
          	li = jQuery('<li><button class="bullet slider-button" role = "button" aria-label="Slide '+(i+1)+'" data-index="'+i+'"></button></li>');
          	$bullets_container.append(li);
      		});
      	}

        function remove_activeClass(bullets) { // Reset active class
          bullets.each(function() {
            if ( jQuery(this).hasClass('active') ) {
                jQuery(this).removeClass('active');
            }
          });
        }

        function active_bullet() {
          
          if(!jQuery(this).hasClass('active')){
            let curidx = jQuery(this).attr('data-index');          
            var $this_bullet = jQuery(this);
            remove_activeClass( jQuery('.bullet') );    
              if(curidx > prevslide){ //nextshow_slide
                previous_slide(curidx);
              }else{ //prev
                next_slide(curidx);
              }                
            prevslide = curidx;
          }
        }

        function show_first_slide() {
            jQuery('.slide').hide();
            jQuery('.slide:first').show();
            jQuery('.bullet:first').addClass('active');
            jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').addClass('active');
            jQuery('.bullet:first').attr('aria-label','Slide 1 current slide');
            var oese_acf_slider_image_alt_text = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content img').attr('alt');
            //var oese_acf_slider_liveregion_title = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('h3.slide-title').text();
            if (jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content a').length) {
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ ' link');
            } else {
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ '');
            }
        }

        function next_slide(idx) {
            prevslide = indice;
            if (typeof(idx) === 'object' || typeof(idx) === 'undefined'){   
              indice = ((jQuery('.slide').length-1) == indice)? 0: ++indice;
            }else{
              indice = idx;
            }
            left_animate(indice);
            show_slide(indice,'nxt');
            var oese_acf_slider_image_alt_text = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content img').attr('alt');
            //var oese_acf_slider_liveregion_title = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('h3.slide-title').text();
            //jQuery('.oese-acf-slider-accessibility-liveregion').html('next slide button: ' +oese_acf_slider_liveregion_title);
            if (jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content a').length){
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ ' link');
            } else {
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ '');
            }
            progress = 0;
        }
        
        function next_slide_auto(idx) {
            prevslide = indice;
            if (typeof(idx) === 'object' || typeof(idx) === 'undefined'){   
              indice = ((jQuery('.slide').length-1) == indice)? 0: ++indice;
            }else{
              indice = idx;
            }
            left_animate(indice);
            show_slide(indice,'nxt');
            var oese_acf_slider_image_alt_text = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content img').attr('alt');
            //var oese_acf_slider_liveregion_title = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('h3.slide-title').text();
            if (jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content a').length) {
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ ' link');
            } else {
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ '');
            }
            progress = 0;
        }

        function previous_slide(idx) {
            prevslide = indice;
            if (typeof(idx) === 'object'){       
      		    indice = ($('.slide').length + indice - 1) % $('.slide').length;
            }else{
              indice = idx;
            }
            right_animate(indice);
            show_slide(indice,'prv');
            var oese_acf_slider_image_alt_text = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content img').attr('alt');
            //var oese_acf_slider_liveregion_title = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('h3.slide-title').text();
            //jQuery('.oese-acf-slider-accessibility-liveregion').html('previous slide button: '+oese_acf_slider_liveregion_title);
            if (jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').find('.slide-content a').length){
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ ' link');
            } else {
              jQuery('.oese-acf-slider-wrapper').attr('aria-label','current slide: ' +oese_acf_slider_image_alt_text+ '');
            }
            progress = 0;
        }

        function show_slide(indice,typ) { // Show or hide a slide
            remove_activeClass( $('.bullet') );    
            jQuery('.slide').each(function(i, obj) {
                let $this = jQuery(this);
                if ( $this.data('index') == indice ) {
                    $('.bullet[data-index="'+indice+'"').addClass('active');
                    jQuery('.oese-acf-slider-wrapper ul.slider-list li').removeClass('active');
                    jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+indice+'"]').addClass('active');
                    $('.bullet[data-index="'+indice+'"').attr('aria-label','Slide '+ (parseInt($this.data('index')) + 1) +' current slide');
                    $this.show();
                }else {
                    $('.bullet[data-index="'+$this.data('index')+'"').attr('aria-label','Slide '+ (parseInt($this.data('index')) + 1));
                }
            });
        }

        /* Slide Animation */

        function left_animate(indice) { //next
            jQuery('.slide').hide()
            jQuery('.slide').removeClass(anim+'InLeft '+anim+'OutRight '+anim+'OutLeft '+anim+'InRight active hiding');
            jQuery('li[data-index="'+indice+'"]').show().removeClass(anim+'OutRight').addClass(anim+'InLeft animated slide active');
            jQuery('li[data-index="'+prevslide+'"]').show().removeClass(anim+'InLeft').addClass(anim+'OutRight animated slide hiding');
        }

        function right_animate(indice) { //prev
            jQuery('.slide').hide()
            jQuery('.slide').removeClass(anim+'InLeft '+anim+'OutRight '+anim+'OutLeft '+anim+'InRight active hiding');
            jQuery('li[data-index="'+prevslide+'"]').show().removeClass(anim+'InRight').addClass(anim+'OutLeft animated slide active');
            jQuery('li[data-index="'+indice+'"]').show().removeClass(anim+'OutLeft').addClass(anim+'InRight animated slide hiding');
        }
        
        function add_bullets() {
            var i = $('.bullet').length,
                bullet = $('<li><button class="bullet slider-button" data-index="'+i+'"></button></li>');
            $('.bullet-list').append(bullet);
        }

        /* Events */

        if ( first_creation ) {
            create_bullets();
            show_first_slide();
        }

        if ( autoplay ) {
            timer = setInterval(function(){
              
              if(progress > autoplay_interval){
                progress = 0;
                next_slide_auto();
              }else{
                progress = (!gbl_pause)? progress + 50: progress; 
              }
            },60);
        }

        if ( timer && autoplay == false ) {
            clearInterval(timer);
        }


    		$next.click(next_slide);
    		$previous.click(previous_slide);
          	$bullets_container.on('click','.bullet', active_bullet);
        
        
        jQuery( "#oese-acf-slider" )
        .mouseenter(function() {
        	gbl_pause = true;
          progress = 0;
        })
        /**--.mouseleave(function() {
          gbl_pause = false;
        })--**/
        
        
        
        let imglen = jQuery('#oese-acf-slider .slide-content img').length;
        let imgcntr = 0;
        jQuery('#oese-acf-slider .slide-content img')
      	.load(function(){
          ++imgcntr;
      		if(imglen == imgcntr){
            jQuery('.oese-acf-slider-content-wrapper').show(1000);
            jQuery('.oese-acf-slider-preloader-wrapper').hide(1000);
          }
      	})
      	.error(function(){
          ++imgcntr;
      		if(imglen == imgcntr){
            jQuery('.oese-acf-slider-content-wrapper').show(1000);
            jQuery('.oese-acf-slider-preloader-wrapper').hide(1000);
          }
      	})
        .each(function() {
          if(this.complete) {
              jQuery(this).load();
          }
        });
      
	      return this;

  	};  
    
    //ACF SLIDER ACCESSIBILITY

    jQuery(document).on('focus','#oese-acf-slider .slider-button', function(){
          gbl_pause = true;
          //jQuery('#oese-acf-slider').addClass('focused');
    })
    jQuery(document).on('blur','#oese-acf-slider .slider-button', function(){
      if (!paused)
        gbl_pause = false;
          //jQuery('#oese-acf-slider').removeClass('focused');
    })
    jQuery(document).on('click','#oese-acf-slider .slider-button', function(){
          gbl_pause = true;
          setTimeout(function(){
            jQuery('.oese-acf-slider-wrapper').focus();
          }, 1000);
          
          //var oese_acf_slider_liveregion_idx = jQuery(this).attr('data-index');
          //var oese_acf_slider_image_alt_text = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+oese_acf_slider_liveregion_idx+'"]').find('.slide-content a img').attr('alt');
          //var oese_acf_slider_liveregion_title = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+oese_acf_slider_liveregion_idx+'"]').find('h3.slide-title').text();
          //jQuery('.oese-acf-slider-accessibility-liveregion').html('slide '+(parseInt(oese_acf_slider_liveregion_idx) + 1) +' button: '+oese_acf_slider_image_alt_text);
    })
    
    function pauseplay(button){
      if (button.hasClass('pause')){
        gbl_pause = true;
        paused = true;
        button.removeClass('pause');
        button.addClass('play');
        button.attr('aria-label', 'Play');
      } else if (button.hasClass('play')){
        gbl_pause = false;
        paused = false;
        button.removeClass('play');
        button.addClass('pause');
        button.attr('aria-label', 'Pause');
      }
    }

    
    //STOP AUTO SLIDE WHILE SLIDE iS IN FOCUS
    jQuery(document).on('focus','.oese-acf-slider-wrapper', function(){
          gbl_pause = true;
          jQuery('#oese-acf-slider').addClass('focused');
    })
    jQuery(document).on('blur','.oese-acf-slider-wrapper', function(){
        if (!paused)
          gbl_pause = false;
        jQuery('#oese-acf-slider').removeClass('focused');
    })
    
    // TOP SEARCH INPUT ACCESSIBILITY
    jQuery(document).on('focus','#searchform .top-search-input', function(){
          jQuery('form#searchform').addClass('focused');
    })
    jQuery(document).on('blur','#searchform .top-search-input', function(){
          jQuery('form#searchform').removeClass('focused');
    })
    
    // TOP SEARCH BUTTON ACCESSIBILITY
    jQuery(document).on('focus','#searchform .custom-search-btn', function(){
          jQuery('form#searchform').addClass('focused');
    })
    jQuery(document).on('blur','#searchform .custom-search-btn', function(){
          jQuery('form#searchform').removeClass('focused');
    })

    jQuery(document).on('click','#pauseplay-button',function(e){
      pauseplay(jQuery(this));
    });

    jQuery(document).on('keydown','#pauseplay-button',function(e){
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if(keyCode == 13 || keyCode==32){
        e.preventDefault();
        pauseplay(jQuery(this));
      }
    });

    jQuery(document).on('keydown','.oese-acf-slider-wrapper',function(e){
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if(keyCode == 13){
        var oese_acf_active_slider_link = jQuery(this).find('ul.slider-list li.slide.active .slide-content a').attr('href');
        window.location.href = oese_acf_active_slider_link;
      }
    });
    
    /*
    jQuery(document).on('click','.oese-acf-slider-content-wrapper ul.bullet-list li button.bullet',function(){
      var oese_acf_slider_liveregion_idx = jQuery(this).attr('data-index');
      var oese_acf_slider_image_alt_text = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+oese_acf_slider_liveregion_idx+'"]').find('.slide-content a img').attr('alt');
      //var oese_acf_slider_liveregion_title = jQuery('.oese-acf-slider-wrapper ul.slider-list li[data-index="'+oese_acf_slider_liveregion_idx+'"]').find('h3.slide-title').text();
      jQuery('.oese-acf-slider-accessibility-liveregion').html('slide '+(parseInt(oese_acf_slider_liveregion_idx) + 1) +' button: '+oese_acf_slider_image_alt_text);
    });
    */
    
})(jQuery);
