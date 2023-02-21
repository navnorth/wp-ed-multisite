<?php 
/**
 * ENQUEUE CSS & JS
 **/
add_action( 'wp_enqueue_scripts', 'oese_acf_slider_enqueue',2 );
function oese_acf_slider_enqueue() {
  global $post;
  if(!is_404()):
    $post_id = $post->ID;

    // if NALRC Page template or resource, load NALRC ACF Slider from settings
    if (is_page_template('page-templates/nalrc-template.php') || 'resource'==get_post_type())
      $post_id = "options";

    if(get_field('oese_acf_slider', $post_id)):
      wp_enqueue_style( 'oese-acf-slider-style', get_template_directory_uri() . '/modules/oese-acf-slider/css/style.css', array(), null );
      wp_enqueue_script( 'oese-acf-slider-script', get_template_directory_uri() . '/modules/oese-acf-slider/js/script.js' , array('jquery') , null, true);
  	endif;
  endif;
}

/**
 * OESE ACF SLIDER SHORTCODE
 * Shortcode Example : [oese_acf_slider]
 **/
add_shortcode("oese_acf_slider", "oese_acf_slider_func" );
function oese_acf_slider_func($attr, $content = null){
    $nalrc_template = false;
		$_id = get_the_ID();

    // if NALRC Page template or resource, load NALRC ACF Slider from settings
    if (is_page_template('page-templates/nalrc-template.php') || 'resource'==get_post_type()){
      $_id = "options";
      $nalrc_template = true;
    }

		if(get_field('oese_acf_slider', $_id)):
  			$_slides  = get_field('oese_acf_slider', $_id);
        $_slide_count = count($_slides);
        $_slider_autoplay = (get_field('oese_slider_autoplay', $_id))? 1: 0;
        $_slider_autoplay_interval = (get_field('oese_slider_autoplay_interval', $_id) * 1000);
        $_slider_animation = get_field('oese_slider_animation', $_id);
  			$_cnt = 0; $_html = '';
        $addtl_class = "";
  			foreach ($_slides as $key => $_slide):
          if(!empty($_slide['oese_acf_slider_image'])):
  					$_image_url = $_slide['oese_acf_slider_image']['url'];
            if(!empty($_slide['oese_acf_slider_image_alt'])){
              $_image_alt = $_slide['oese_acf_slider_image_alt'];
            }else{
              if(trim($_slide['oese_acf_slider_image']['alt']," ") != ""){
                  $_image_alt = $_slide['oese_acf_slider_image']['alt'];
              }else{
                  $_image_alt = 'slide image '.($_cnt + 1);
              }
            }          
  					$_image_caption = trim($_slide['oese_acf_slider_caption']," ");
  					$_image_link = trim($_slide['oese_acf_slider_url']," ");
            $_image_link_target = $_slide['oese_acf_slider_url_target'];
            if (!empty($_image_caption))
              $addtl_class = " wCaption";

  					$_vis = ($_cnt > 0)? 'style="visibility:hidden;"': '';
                $_html .= '<li class="slide" data-index="'.$_cnt.'">';
                    $_html .= '<div class="slide-content" '.$_image_link_target.'>';   
                        $_caption_html = ($_image_caption != '')?'<h3 class="slide-title">'.$_image_caption.'</h3>': '';  
                        if($_image_link != ''){                        
                          $_html .= '<a href="'.$_image_link.'" target="'.$_image_link_target.'" class="no_target_change external_link" tabindex="-1">';					  
                              $_html .= '<img src="'.$_image_url.'" style="width:100%" alt="'.$_image_alt.'">';   
                              $_html .= $_caption_html;             
                          $_html .= '</a>';                                         
                        }else{
                          $_html .= '<img src="'.$_image_url.'" style="width:100%" alt="'.$_image_alt.'">';
                          $_html .= $_caption_html;
                        }      
                    $_html .= '</div>';
                $_html .= '</li>';
    
  					$_cnt++;
          endif;
  			endforeach;
        
        $_ret = '';
        $_ret .= '<div id="oese-acf-slider">';
          $_ret .= '<div class="oese-acf-slider-content-wrapper" style="display:none;">';
            $_ret .= '<div class="oese-acf-slider-wrapper" tabindex="0">';
              $_ret .= '<div aria-live="polite" aria-atomic="true" class="oese-acf-slider-accessibility-liveregion visuallyhidden"></div>';
      				$_ret .= '<ul class="slider-list'.$addtl_class.'">'.$_html.'</ul>';
            $_ret .= '</div>';
            
            if($_slide_count > 1){
              if ($nalrc_template){
                $_ret .= '<div id="pause-control"><button id="pauseplay-button" class="pause" role="button" aria-label="Pause"></button></div>';
                $_ret .= '<ul class="bullet-list nalrc-list'.$addtl_class.'"></ul>';
              } else {
                $_ret .= '<button class="oese-slider-sidenavs left slider-button arrow previous" role = "button" aria-label="previous slide" data-index="0">&#10094;</button>';
                $_ret .= '<button class="oese-slider-sidenavs right slider-button arrow next" role = "button" aria-label="next slide" data-index="0">&#10095;</button>';  
                /**--$_ret .= '<div id="pause-control"><button id="pauseplay-button" class="pause" role="button" aria-label="Play"></button></div>';--**/    
                $_ret .= '<ul class="bullet-list"></ul>';
              }
            }else{
              $_slider_autoplay = 0;
            }
          $_ret .= '</div>';
          $_ret .= '<div class="oese-acf-slider-preloader-wrapper">';
            $_ret .= '<div class="oeseslider-ring"><div></div><div></div><div></div><div></div></div>';
          $_ret .= '</div>';
        $_ret .= '</div>';
        
        $_ret .= '<script>';
          $_ret .= 'jQuery(document).ready(function() {';
          	$_ret .= 'jQuery("#oese-acf-slider").slider(true,"'.$_slider_animation.'",'.$_slider_autoplay.','.$_slider_autoplay_interval.');';
          $_ret .= '});';
        $_ret .= '</script>';
      
		endif;
      
	  return $_ret;
}
?>