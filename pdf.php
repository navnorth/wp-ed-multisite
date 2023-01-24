<?php
/**
 * The Template for displaying PDF Media Files
 *
 * @package wp_oese_theme
 * @since 1.5.0
 */

get_header(); ?>
<style>
#Iframe-Master-CC-and-Rs {max-width: 2000px; max-height: 100%; overflow: hidden;}
.responsive-wrapper {position: relative; height: 0; padding-bottom: 70%;border: 1px solid #9c9c9c;}
.responsive-wrapper iframe {position: absolute; top: 0;left: 0; width: 100%; height: 100%; margin: 0; padding: 0; border: none;}
.responsive-wrapper-wxh-572x612 {padding-bottom: 107%;}
.set-border {border: 5px inset #4f4f4f;}
.set-box-shadow { -webkit-box-shadow: 4px 4px 14px #4f4f4f; -moz-box-shadow: 4px 4px 14px #4f4f4f; box-shadow: 4px 4px 14px #4f4f4f;}
.set-padding {padding: 40px;}
.set-margin {margin: 30px;}
.center-block-horiz {margin-left: auto !important; margin-right: auto !important;}

header.oese-entry-header {color: #4b4e53 !important; margin:20px 0px 20px 0px !important;}
header.oese-entry-header>h1 { display:block; margin: 0px 0px 5px 0px !important; }
header.oese-entry-header>p { display:block; font-size:16px !important; line-height:20px !important; color:inherit !important; }
@media screen and (max-width: 768px) {
  header.oese-entry-header>h1 { font-size: 22px !important;}
}
.oese-media-tags { margin-top: 20px; }

</style>
  
	<div id="content" class="site-content">
		<div class="col-md-12 col-sm-12 col-xs-12 padding_left padding_right lft_sid_cntnr">
			<?php while ( have_posts() ) : the_post(); ?>  
            
        <?php      
        $media_title = $post->post_title;
        $media_desc = $post->post_content;
        $media_mod_date = $post->post_modified;
        $media_categories = wp_get_post_categories($post->ID);
        $media_tags = wp_get_post_tags($post->ID);
        
        
        //print_r($media_categories);
        
        ?>
        <header class="entry-header oese-entry-header">
          <h1 class="entry-title"><?php echo $media_title ?></h1>
          <?php if(trim($media_desc," ") !== ''){ ?>
          <p><?php echo $media_desc ?></p>
          <?php } ?>
        </header>
            
        <div class="responsive-wrapper" style="-webkit-overflow-scrolling: touch; overflow: auto;">
          <iframe src="<?php echo wp_get_attachment_url($post->ID); ?>"> 
            <p style="font-size: 110%;"><em><strong>ERROR: </strong>  
      An &#105;frame should be displayed here but your browser version does not support &#105;frames. </em>Please update your browser to its most recent version and try again.</p>
          </iframe> 
        </div>
        
        <div class="oese-media-tags">
          
          
          <?php if(count($media_categories) > 0){
            echo 'This entry was posted in '; 
            foreach ($media_categories as $catid) {
              $cat = get_category($catid);
              $media_cat_name = $cat->name;
              $media_cat_slug = $cat->slug;
              ?>
              <a href="<?php echo get_site_url().'/category/'.$media_cat_slug ?>" target="_blank"><?php echo $media_cat_name ?></a>
              <?php
            }
          } ?>
          
          
          <?php if(count($media_tags) > 0){         
            $_text = (count($media_categories) > 0)? 'and tagged ':'This entry was tagged ';
            echo $_text;
            foreach ($media_tags as $tag) {
              $media_tag_name= $tag->name;
              $media_tag_slug = $tag->slug;
              ?>
              <a href="<?php echo get_site_url().'/tag/'.$media_tag_slug ?>" target="_blank"><?php echo $media_tag_name ?></a>
              <?php
            }
          } ?>
          
          
          
          
        </div>

        <script>
        var tout;
        jQuery(document).ready(function(){
          jQuery(window).resize(function(){
            clearTimeout(tout);
            tout = setTimeout(function(){
              jQuery('.responsive-wrapper iframe').attr('src', "<?php echo wp_get_attachment_url($post->ID) ?>?#view=fitH");
            }, 500);  
          });
        });
        </script>


				<?php #comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>
		</div>
    <div class="col-md-3 col-sm-12 col-xs-12 right_sid_mtr">
        <?php get_sidebar(); ?>
    </div>
	</div><!-- #row -->

<?php get_footer(); ?>
