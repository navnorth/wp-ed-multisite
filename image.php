<?php
/**
 * The Template for displaying PDF Media Files
 *
 * @package wp_oese_theme
 * @since 1.5.0
 */

get_header(); ?>
<style>
.responsive-wrapper {margin-top: 30px;}
a.oese_attachement_link {display: block;box-sizing: border-box;}
a.oese_attachement_link>img {width: 100%;}
.oese-attachment-icon {width: 12%;float: left; margin:0 1% 0 0;}
.oese-attachment-info table.border {border: 1px solid #b1aaaa !important;}
.oese-attachment-info table tr td span span.dashicons {font-size: 26px;color: #00539f;}
.oese-attachment-info {width: 100%;float: left;}
.oese-attachment-info table tr td span {display: inline-block; text-decoration: none;}
/*
@media screen and (max-width: 1200px) {
  .oese-attachment-icon {width: 15%;float: left; margin:0 1% 0 0;}
  .oese-attachment-info {width: 84%;float: left;}
}
@media screen and (max-width: 992px) {
  .oese-attachment-icon {width: 20%;float: left; margin:0 1% 0 0;}
  .oese-attachment-info {width: 79%;float: left;}
}
@media screen and (max-width: 768px) {
  a.oese_attachement_link>img {width: 100%; margin:0px auto;}
  .oese-attachment-icon {width: 160px;float: none; margin:0 auto 2% auto;}
  .oese-attachment-info {width: 100%;float: left;}
}
*/
span.oese_attachment_info_row {display: block;}
.oese-attachment-info table {width: 100%;}
.oese-attachment-info table tr td:nth-of-type(1) {width: 130px;}
.oese-attachment-info table tr td {vertical-align: top;}
p.comment-form-comment label { display: block; }
p.comment-form-comment textarea#comment {width: 100%;border: 1px solid #b1aaaa;}
.oese-attachment-display table tr td {padding: 0px !important;}
.oese-attachment-display {margin-bottom:10px;}
</style>

<?php 
$mme = explode('/',get_post_mime_type())[1];

$ics = array(
  "jpeg"=>array("jpg-icon.png","Image file (JPG)"),
  "png"=>array("png-icon.png","Image file (PNG)"));

if(array_key_exists($mme, $ics)){

    ?>
    <div id="content" class="site-content">
      <div class="col-md-12 col-sm-12 col-xs-12 padding_left padding_right lft_sid_cntnr">
        <?php while ( have_posts() ) : the_post(); ?>  
              
          <?php      
          //print_r($post);
          $media_filename = wp_basename(wp_get_attachment_url($post->ID));
          $media_title = $post->post_title;
          $media_author = get_the_author_meta('display_name', $post->post_author);
          $media_capt = $post->post_excerpt;
          $media_desc = $post->post_content;
          $media_pub_date = $post->post_date;
          $media_mod_date = $post->post_modified;
          $media_categories = wp_get_post_categories($post->ID);
          $media_tags = wp_get_post_tags($post->ID);
          $media_url = $post->guid;
          
          
          //print_r($media_categories);
          
          ?>
          <header class="entry-header oese-entry-header">
            <h1 class="entry-title"><?php echo $media_title ?></h1>
            <?php if(trim($media_desc," ") !== ''){ ?>
            <!--<p><?php echo $media_desc ?></p>-->
            <?php } ?>
          </header>
              
          <div class="responsive-wrapper" style="-webkit-overflow-scrolling: touch; overflow: auto;">    

            <?php /* ?>
            <div class="oese-attachment-icon">
              <a href="<?php echo $media_url; ?>" download="true" class="oese_attachement_link">
                <img src="<?php echo get_template_directory_uri() ?>/images/filetypes/<?php echo $ics[$mme][0] ?>"  alt="<?php echo $media_filename ?>" />
              </a>
            </div>
            <?php */ ?>
            <div class="oese-attachment-info oese-attachment-display">
              <table border="0">
                
                    <?php if($ics[$mme][0] == 'jpg-icon.png' || $ics[$mme][0] == 'png-icon.png'){ //img?>
                      <tr>
                        <td class="oese_attachment_info_row" colspan="2">
                          <img src="<?php echo $media_url ?>" alt="<?php echo $media_filename ?>">
                        </td>
                      </tr>
                    <?php } ?>
                  
                <tr>
              </table>
            </div>
            
            <div class="oese-attachment-info">
              <table class="border" border="1">

                  
                <tr>
                  <td class="oese_attachment_info_row">Filename:</td>
                  <td><span><?php echo $media_filename ?> <span><a href="<?php echo $media_url; ?>" download="true" class="oese_attachement_link"><span class="dashicons dashicons-download"></span></a></td>
                </tr>
                <?php if(trim($media_capt, " ") != ""){ ?>
                <tr>
                  <td class="oese_attachment_info_row">Caption:</td>
                  <td><?php echo $media_capt ?></td>
                </tr>
                <?php } ?>
                <?php if(trim($media_desc, " ") != ""){ ?>
                <tr>
                  <td class="oese_attachment_info_row">Description:</td>
                  <td><?php echo $media_desc ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td class="oese_attachment_info_row">Author:</td>
                  <td><?php echo $media_author ?></td>
                </tr>
                <tr>
                  <td class="oese_attachment_info_row">Date Published:</td>
                  <td><?php echo $media_pub_date ?></td>
                </tr>
                <tr>
                  <td class="oese_attachment_info_row">Date Modified:</td>
                  <td><?php echo $media_mod_date ?></td>
                </tr>  
                <tr>
                  <td class="oese_attachment_info_row">File Type:</td>
                  <td><?php echo $ics[$mme][1] ?></td>
                </tr>  
                <?php if(count($media_categories) > 0){ ?>
                <tr>
                  <td class="oese_attachment_info_row">Categories:</td>
                  <td>
                  <?php 
                    foreach ($media_categories as $catid) {
                      $cat = get_category($catid);
                      $media_cat_name = $cat->name;
                      $media_cat_slug = $cat->slug;
                      ?>
                      <a href="<?php echo get_site_url().'/category/'.$media_cat_slug ?>" target="_blank"><?php echo $media_cat_name ?></a>
                      <?php
                    }
                  ?>
                  </td>
                </tr>
                <?php }
                if(count($media_tags) > 0){ ?>
                <tr>
                  <td class="oese_attachment_info_row">Tags:</td>
                  <td>
                    <?php         
                      foreach ($media_tags as $tag) {
                        $media_tag_name= $tag->name;
                        $media_tag_slug = $tag->slug;
                        ?>
                        <a href="<?php echo get_site_url().'/tag/'.$media_tag_slug ?>" target="_blank"><?php echo $media_tag_name ?></a>
                        <?php
                      }
                    ?>
                  </td>
                </tr>
                <?php } ?>
            </table>
              
            </div>
          </div>

        <?php endwhile; // end of the loop. ?>
        
      </div>
      
      <div class="col-md-3 col-sm-12 col-xs-12 right_sid_mtr">
          <?php get_sidebar(); ?>
      </div>
    </div><!-- #row -->

<?php
}else{
?>

    <div id="primary" class="site-content">
      <div id="content" role="main">

      <?php
      while ( have_posts() ) :
        the_post();
        ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
            <header class="entry-header">
              <h1 class="entry-title"><?php the_title(); ?></h1>

              <footer class="entry-meta">
                <?php
                  $metadata = wp_get_attachment_metadata();
                  printf(
                    __( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'twentytwelve' ),
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    esc_url( wp_get_attachment_url() ),
                    $metadata['width'],
                    $metadata['height'],
                    esc_url( get_permalink( $post->post_parent ) ),
                    esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
                    get_the_title( $post->post_parent )
                  );
                ?>
                <?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
              </footer><!-- .entry-meta -->

              <nav id="image-navigation" class="navigation" role="navigation">
                <span class="previous-image"><?php previous_image_link( false, __( '&larr; Previous', 'twentytwelve' ) ); ?></span>
                <span class="next-image"><?php next_image_link( false, __( 'Next &rarr;', 'twentytwelve' ) ); ?></span>
              </nav><!-- #image-navigation -->
            </header><!-- .entry-header -->

            <div class="entry-content">

              <div class="entry-attachment">
                <div class="attachment">
        <?php
        /*
        * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
        * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
        */
        $attachments = array_values(
          get_children(
            array(
              'post_parent'    => $post->post_parent,
              'post_status'    => 'inherit',
              'post_type'      => 'attachment',
              'post_mime_type' => 'image',
              'order'          => 'ASC',
              'orderby'        => 'menu_order ID',
            )
          )
        );
        foreach ( $attachments as $k => $attachment ) :
          if ( $attachment->ID == $post->ID ) {
            break;
          }
    endforeach;

        // If there is more than 1 attachment in a gallery
        if ( count( $attachments ) > 1 ) :
          $k++;
          if ( isset( $attachments[ $k ] ) ) :
            // get the URL of the next image attachment
            $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
          else :
            // or get the URL of the first image attachment
            $next_attachment_url = get_attachment_link( $attachments[0]->ID );
          endif;
    else :
    // or, if there's only 1 image, get the URL of the image
    $next_attachment_url = wp_get_attachment_url();
    endif;
    ?>
                  <a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
                            <?php
                            /**
                             * Filter the image attachment size to use.
                             *
                             * @since Twenty Twelve 1.0
                             *
                             * @param array $size {
                             *     @type int The attachment height in pixels.
                             *     @type int The attachment width in pixels.
                             * }
                             */
                            $attachment_size = apply_filters( 'twentytwelve_attachment_size', array( 960, 960 ) );
                            echo wp_get_attachment_image( $post->ID, $attachment_size );
                            ?>
                  </a>

                  <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                  <div class="entry-caption">
                    <?php the_excerpt(); ?>
                  </div>
                  <?php endif; ?>
                </div><!-- .attachment -->

              </div><!-- .entry-attachment -->

              <div class="entry-description">
                <?php the_content(); ?>
                <?php
                wp_link_pages(
                  array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ),
                    'after'  => '</div>',
                  )
                );
                ?>
              </div><!-- .entry-description -->

            </div><!-- .entry-content -->

          </article><!-- #post -->

          <?php comments_template(); ?>

        <?php endwhile; // end of the loop. ?>

      </div><!-- #content -->
    </div><!-- #primary -->

<?php
}
?>
<p>&nbsp;</p>
<?php comments_template(); ?>

<?php get_footer(); ?>