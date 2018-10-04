<?php
include_once wp_normalize_path( get_stylesheet_directory() . '/classes/oet_medium.php' );

$self_access_token = get_option("mediumaccesstoken");
$oet_medium = new OET_Medium($self_access_token);
$pub_display = get_post_meta($post->ID, "mpubdisplay", true);

?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php
    if ($pub_display=="all"){
        $oet_medium->display_all_stories();
    } else {
        $oet_medium->display_posts();   
    }
    ?>
</div>
