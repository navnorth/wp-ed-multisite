<?php
    $content = get_the_content($post->ID);
    $content = apply_filters('the_content', $content);

    // get progress, to display continue or results button
    $assess_data = get_GAT_response($post->ID, htmlspecialchars($_COOKIE['GAT_token']));
?>

<div class="col-md-9 col-sm-12 col-xs-12">
    <h3><?php echo get_the_title($post->ID); ?></h3>

    <div class="gat_moreContent">
        <?php echo $content; ?>
    </div>

    <div class="get_domainlist_button">
    	<ul class="gat_domainsbmt_btn">
    	    <?php if ($assess_data->progress==100) : ?>
        	    <li><a href="<?php echo get_permalink($post->ID); ?>?action=analysis-result" class="btn btn-default gat_buttton">Get Results</a></li>
        	    <li><a href="<?php echo get_permalink($post->ID); ?>?action=video-playlist" class="btn btn-default gat_buttton">Get Your Video Playlist</a></li>
    	    <?php endif; ?>
    	    <li class="right<?php if($assess_data->progress==100) echo ' retake' ?>"><a class="btn btn-default gat_button_continue btn-right" href="<?php echo get_permalink()."?action=token-saved&list=1"; ?>" role="button"><?php if($assess_data->progress==100) echo 'Retake'; else echo 'Continue'; ?></a></li>
    	</ul>
   </div>
</div>

<div class="col-md-3 col-sm-12 col-xs-12">
    <div class="gat_sharing_widget">
        <p class="pblctn_scl_icn_hedng"> Share the GAP analysis tool </p>
        <div class="pblctn_scl_icns">
            <?php echo do_shortcode("[ssba]"); ?>
        </div>
    </div>


    <?php progress_indicator_sidebar($post->ID, htmlspecialchars($_COOKIE['GAT_token'])); ?>
</div>
