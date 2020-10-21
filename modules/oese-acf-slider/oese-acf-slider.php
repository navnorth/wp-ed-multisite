<?php 
/**
 * ENQUEUE CSS & JS
 **/
add_action( 'wp_enqueue_scripts', 'oese_acf_slider_enqueue',2 );
function oese_acf_slider_enqueue() {
  if(get_field('oese_acf_slider', $_id)):
    wp_enqueue_style( 'oese-acf-slider-style', get_template_directory_uri() . '/modules/oese-acf-slider/css/style.css', array(), null );
    wp_enqueue_script( 'oese-acf-slider-script', get_template_directory_uri() . '/modules/oese-acf-slider/js/script.js' , array('jquery') , null, true);
	endif;
}

/**
 * OESE ACF SLIDER SHORTCODE
 * Shortcode Example : [oese_acf_slider]
 **/
add_shortcode("oese_acf_slider", "oese_acf_slider_func" );
function oese_acf_slider_func($attr, $content = null){
		$_id = get_the_ID();
		if(get_field('oese_acf_slider', $_id)):
  			$_slides  = get_field('oese_acf_slider', $_id);
        $_slider_autoplay = (get_field('oese_slider_autoplay', $_id))? 1: 0;
        $_slider_autoplay_interval = (get_field('oese_slider_autoplay_interval', $_id) * 1000);
        $_slider_animation = get_field('oese_slider_animation', $_id);
  			$_cnt = 0;
  			foreach ($_slides as $key => $_slide):
          if(!empty($_slide['oese_acf_slider_image'])):
  					$_image_url = $_slide['oese_acf_slider_image']['url'];
  					$_image_caption = trim($_slide['oese_acf_slider_caption']," ");
  					$_image_link = trim($_slide['oese_acf_slider_url']," ");
            $_image_link_target = trim($_slide['oese_acf_slider_url_target']," ");
  					$_vis = ($_cnt > 0)? 'style="visibility:hidden;"': '';
                $_html .= '<li class="slide" data-index="'.$_cnt.'">';
                    $_html .= '<div class="slide-content">';   
                        $_caption_html = ($_image_caption != '')?'<h3 class="slide-title">'.$_image_caption.'</h3>': '';  
                        if($_image_link != ''){                        
                          $_html .= '<a href="'.$_image_link.'" target="'.$_image_link_target.'" class="external_link" tabindex="-1">';					                    
                              $_html .= '<img src="'.$_image_url.'" style="width:100%" alt="">';   
                              $_html .= $_caption_html;             
                          $_html .= '</a>';                                         
                        }else{
                          $_html .= '<img src="'.$_image_url.'" style="width:100%" alt="">';
                          $_html .= $_caption_html;
                        }      
                    $_html .= '</div>';
                $_html .= '</li>';
    
  					$_cnt++;
          endif;
  			endforeach;
        
        $_ret .= '<div id="oese-acf-slider">';
          $_ret .= '<div class="oese-acf-slider-content-wrapper" style="display:none;">';
            $_ret .= '<div class="oese-acf-slider-wrapper">';
      				$_ret .= '<ul class="slider-list">'.$_html.'</ul>';
            $_ret .= '</div>';
            $_ret .= '<button class="oese-slider-sidenavs right slider-button arrow next" data-index="">&#10095;</button>';
            $_ret .= '<button class="oese-slider-sidenavs left slider-button arrow previous" data-index="">&#10094;</button>';
            $_ret .= '<ul class="bullet-list"></ul>';
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