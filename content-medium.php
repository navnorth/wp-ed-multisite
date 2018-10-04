<?php
include_once wp_normalize_path( get_stylesheet_directory() . '/classes/oet_medium.php' );

$self_access_token = get_option("mediumaccesstoken");
$oet_medium = new OET_Medium($self_access_token);
$publications = $oet_medium->get_publications();
var_dump($_POST);
?>
<div class="col-md-8 col-sm-8 col-xs-12" id="story-options">
    <h3><?php _e("Select Publications", "twentytwelve-child"); ?></h3>
    <form id="storiesform" method="post">
        <input type="radio" name="display" <?php if ($_POST['display']=="all"): ?>checked="checked"<?php endif; ?> value="all"> All Medium Stories <br/>
        <input type="radio" name="display" <?php if ($_POST['display']=="selective"): ?>checked="checked"<?php endif; ?> value="selective"> Select Publication(s) <br/>
        <div class="list-publications">
            <?php if ($publications): foreach($publications as $publication): ?>
            <input type="checkbox" name="publication[]" value="<?php echo $publication->id; ?>" > <?php echo $publication->name; ?> <br/>
            <?php endforeach; endif; ?>
        </div>
        <input type="submit" name="submit" value="Show">
    </form>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php
    $oet_medium->display_posts();
    ?>
</div>
