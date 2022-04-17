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
.oese-attachment-icon {width: 12%;float: left; margin:0 0 1% 0;}
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
$mme = (isset(explode('/',get_post_mime_type())[1]))? explode('/',get_post_mime_type())[1]: '';
$ics = array(
  "msword"=>array("word-icon.png","Microsoft Word Document"),
  "vnd.openxmlformats-officedocument.wordprocessingml.document"=>array("word-icon.png","Microsoft Word Document"),
  "jpeg"=>array("jpg-icon.png","Image file (JPG)"),
  "png"=>array("png-icon.png","Image file (PNG)"),
  "csv"=>array("csv-icon.png","CSV File (Comma-separated Values)"),
  "vnd.ms-excel"=>array("excel-icon.png","Microsoft Excel Spreadsheet"),
  "vnd.openxmlformats-officedocument.spreadsheetml.sheet"=>array("excel-icon.png","Microsoft Excel Spreadsheet"),
  "vnd.ms-powerpoint"=>array("ppt-icon.png","Powerpoint Presentation"),
  "wav"=>array("audio-icon.png","Audio File (Wav)"));

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
                
                    <?php if($ics[$mme][0] == "audio-icon.png"){ //Audio ?>
                      <tr>
                        <td class="oese_attachment_info_row" colspan="2">
                          <audio controls>
                            <source src="<?php echo $media_url ?>">
                          </audio>
                        </td>
                      </tr>
                    <?php }elseif($ics[$mme][0] == 'jpg-icon.png' || $ics[$mme][0] == 'png-icon.png'){ //img?>
                      <tr>
                        <td class="oese_attachment_info_row" colspan="2">
                          <img src="<?php echo $media_url ?>" alt="<?php echo $media_filename ?>">
                        </td>
                      </tr>
                    <?php }else{ ?>
                      <tr>
                        <td class="oese_attachment_info_row" colspan="2">
                          <div class="oese-attachment-icon">
                            <a href="<?php echo $media_url; ?>" download="true" class="oese_attachement_link">
                              <img src="<?php echo get_template_directory_uri() ?>/images/filetypes/<?php echo $ics[$mme][0] ?>"  alt="<?php echo $media_filename ?>" />
                            </a>
                          </div>
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

<div id="content" class="site-content">
  <div class="col-md-9 col-sm-12 col-xs-12 padding_left lft_sid_cntnr">
    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'content', 'single' ); ?>
      
      <hr class="post_bottom_hr" />

      <nav class="nav-single">
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
        <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
        <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
      </nav><!-- .nav-single -->

      <?php #comments_template( '', true ); ?>

    <?php endwhile; // end of the loop. ?>
  </div>
      <div class="col-md-3 col-sm-12 col-xs-12 right_sid_mtr">
          <?php get_sidebar(); ?>
      </div>
</div><!-- #row -->

<?php
}
?>
<p>&nbsp;</p>
<?php comments_template(); ?>

<?php get_footer(); ?>