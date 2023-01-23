<?php
/**
 * Template Name: Publication Template
 */

global $post;

$page_id = get_the_ID();
$file = null;
$file_detail = null;
$head_class = "";
$is_archived = false;
$archived_date = null;

get_header();

if (get_field('select_file')){
    $file = get_field('select_file');
    $file_detail = oese_file_type_from_url($file,'fa-10x');
}

if (get_field('archive_date'))
    $archived_date = get_field('archive_date');
    
if ($archived_date){
    $is_archived = true;
    $head_class = " archived-header";
}
?>
    <!--Publication Template Top Section START-->
    <div id="content" class="row custom-common-padding office-template">
        <div class="row publication-details">
            <div class="col-md-5">
                <?php
                if ( has_post_thumbnail() ) {
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id($page_id), 'single-post-thumbnail' );
                    $img_alt = get_post_meta(get_post_thumbnail_id($page_id), '_wp_attachment_image_alt', true);
                    
                    echo "<div class='left-section-featured-image'>
                            <img src='".$image[0]."' alt='".$img_alt."'></div>";
                } else {
                    if ($file) {
                        echo "<div class='left-section-featured-image'><span class='publication-no-featured-image'>".$file_detail['icon']."</span></div>";
                    }
                }
                $download_button = get_field('show_download_button');
                $share_button = get_field('show_share_button');
                $download_link = get_field('select_file');
                ?>
                <div class="row publication-buttons">
                    <?php if ($download_button): ?>
                    <div class="col-md-7 oese-pubdownload-section">
                        <a href="<?php echo $download_link; ?>" target="_blank" class="btn" onclick="oese_trackEvent('Publication','click','Download','<?php echo $download_link; ?>')><i class="fas fa-download"></i> <span>DOWNLOAD</span></a>
                    </div>
                    <?php endif; ?>
                    <?php if ($share_button): ?>
                    <div class="col-md-5 oese-pubshare-section">
                        <a href="#" class="btn" data-toggle="collapse"  data-target="#ssba-share-buttons" onclick="oese_trackEvent('Publication','click','Share','<?php echo $post->post_title; ?>')"  aria-expanded="false" aria-controls="ssba-share-buttons"><i class="fas fa-share-alt"></i> <span>SHARE</span></a>
                        <?php get_template_part('ssba'); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-7">
                <h1 class="page_header<?php echo $head_class; ?>"><?php echo $post->post_title; ?></h1>
                <?php if ($is_archived): ?>
                <div class="oese-archived-disclaimer">
                        <?php //_e('<span class="fa fa-archive"></span><strong>Archived Content:</strong> The following page was archived on '.$archived_date.' but still has content that may be valuable to some people.', WP_OESE_THEME_SLUG); ?>
                        ARCHIVED INFORMATION
                </div>
                <?php endif; ?>
                <?php if (get_field('sub-title')): ?>
                <h2 class="publication_sub_title"><?php echo the_field('sub-title'); ?></h2>
                <?php endif; ?>
                <?php while (have_posts()) : the_post(); ?>
        
                    <?php get_template_part('content', 'page'); ?>
        
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        if ($file && $file_detail['title']=="PDF"){ ?>
        <div class="row publication-embed">
            <?php
            $viewer = get_option('wp_oese_theme_pdf_viewer');
            $viewer = ($viewer=="2")?"pdfjs":"google";
            $embed_code = oese_pdf_embed_code($file, $viewer);
            echo $embed_code; ?>
        </div>
        <?php
        }
        ?>
    </div>
<?php get_footer(); ?>