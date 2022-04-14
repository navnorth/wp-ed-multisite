<?php 
/**
 * ENQUEUE CSS & JS
 **/
add_action( 'wp_enqueue_scripts', 'oet_acf_slider_enqueue',2 );
function oet_acf_slider_enqueue() {
  global $post;
  if(!is_404()):
    if(get_field('oet_acf_slides', $post->ID)):
      wp_enqueue_style( 'oet-acf-slider-style', get_stylesheet_directory_uri() . '/modules/oet-acf-slider/css/style.css', array(), null );
      wp_enqueue_script( 'oet-acf-slider-script', get_stylesheet_directory_uri() . '/modules/oet-acf-slider/js/script.js' , array('jquery') , null, true);
  	endif;
  endif;
}

/**
 * OESE ACF SLIDER SHORTCODE
 * Shortcode Example : [oet_acf_slider]
 **/
 
 
 
 add_shortcode("oet_acf_slider", "oet_acf_slider_func" );
 function oet_acf_slider_func($_id){
    ob_start();
 		if(get_field('oet_acf_slides', $_id)):
   		 $_slides  = get_field('oet_acf_slides', $_id);
       $_slide_count = count($_slides);
       $_slider_autoplay = 1;
       $_slider_autoplay_interval = (get_field('oet_acf_seconds_between_changing_slides', $_id) * 1000);
       $_slider_animation = get_field('oet_acf_slides_animation_transition', $_id);
       
 			$_cnt = 0; $_html = '';
      ?>
      
      <div id="oet-acf-slider">
        <div class="oet-acf-slider-content-wrapper" style="display:none;">
          <div class="oet-acf-slider-wrapper">
            <div aria-live="polite" aria-atomic="true" class="oet-acf-slider-accessibility-liveregion visuallyhidden"></div>
            <ul class="slider-list">
      
            <?php
 			      foreach ($_slides as $key => $_slide):
               if(!empty($_slide['oet_acf_slide_image'])):
         					$_image_url = wp_get_attachment_image_src( $_slide['oet_acf_slide_image'], 'full' )[0];
                  if(!empty($_slide['oet_acf_slide_image'])){
                     $_image_alt = $_slide['oet_acf_slide_image_alt_text'];
                  }else{
                    if(trim($_slide['oet_acf_slide_image']['alt']," ") != ""){
                      $_image_alt = $_slide['oet_acf_slide_image_alt_text'];
                    }else{
                      $_image_alt = 'slide image '.($_cnt + 1);
                    }
                  }        
                   
         					$_image_header = trim($_slide['oet_acf_slide_header']," ");
                  $_image_description = trim($_slide['oet_acf_slide_description']," ");
         					$_image_link = trim($_slide['oet_acf_slide_button_url']," ");
                  $_image_link_target = 'target="_blank"';
         					$_vis = ($_cnt > 0)? 'style="visibility:hidden;"': '';
                  ?>
                    <li class="oet_acf_slide" data-index="<?php echo $_cnt ?>"><?php
                       $bgStyle = ' style="background-image:url('.$_image_url.');background-repeat:no-repeat;background-position:center center;background-size:cover;"'; ?>
                       <div class="oet_acf_slide_content" <?php echo $bgStyle ?>>
                         
                         <img src="<?php echo $_image_url ?>" alt="" style="display:none;">
                         <div class="oet_acf_slide_caption_wrapper">
                           <div class="oet_acf_slide_caption_block"> <?php
                               echo ($_image_header != '')?'<h2 class="oet_acf_slide_title">'.$_image_header.'</h2>': ''; ?>
                               <p class="oet_acf_slide_desc"><?php echo $_image_description ?></p>
                               <p class="oet-slide-button-row"> <?php
                                   if(!empty($_slide['oet_acf_slide_button_url'])): ?>
                                     <a href="<?php echo $_image_link ?>" class="oet-slide-button" tabindex="0" aria-label="<?php echo $_image_header ?> Read More Push Button">Read More&nbsp;&nbsp;→</a>
                                   <?php
                                   endif ?>
                               </p>
                           </div>
                         </div>
                           
                       </div>
                    </li>
                  <?php
         					$_cnt++;
               endif;
 			      endforeach;
      
            ?>
            </ul>
          </div>
          
          <?php if($_slide_count > 1){ ?> 
            <div class="oet-acf-nav-wrapper">
              <ul class="bullet-list"></ul>
            </div>
          <?php }else{
           $_slider_autoplay = 0;
          } ?>
      
        </div>
        <div class="oet-acf-slider-preloader-wrapper">
          <div class="oetslider-ring"><div></div><div></div><div></div><div></div></div>
        </div>
      </div>
              
      <script>
        jQuery(document).ready(function() {
        	jQuery("#oet-acf-slider").slider(true,'<?php echo $_slider_animation ?>',<?php echo $_slider_autoplay ?>,<?php echo $_slider_autoplay_interval ?>);
        });
      </script>
      <?php

 		endif;
     
 	  return ob_get_clean();
 }
 
?>