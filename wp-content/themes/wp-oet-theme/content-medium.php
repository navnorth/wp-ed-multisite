<div class="col-md-12 col-sm-12 col-xs-12">
<?php
include_once wp_normalize_path( get_stylesheet_directory() . '/classes/oet_medium.php' );

try {
$self_access_token = get_option("mediumaccesstoken");
//$oet_medium = new OET_Medium($self_access_token);
$pub_display = get_post_meta($post->ID, "mpubdisplay", true);

?>
    <?php
    if ($pub_display=="all"){
        //$oet_medium->display_all_stories();
        echo "All Medium Stories";
    } else {
        echo "Medium Posts";
        //$oet_medium->display_posts();   
    }
    ?>
<?php
} catch(MediumAuthException $e) {
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12 medium-error">
        <div class="archived-disclaimer">
            Invalid Access Token - <a href="https://medium.com/@OfficeofEdTech" target="_blank">Visit our Blog</a>
        </div>
    </div>
    <?php
} catch(Exception $e) {
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12 medium-error">
        <div class="archived-disclaimer">
            Medium integration temporarily unavailable - <a href="https://medium.com/@OfficeofEdTech" target="_blank">Visit our Blog</a>
        </div>
    </div>
    <?php
}
?>
</div>