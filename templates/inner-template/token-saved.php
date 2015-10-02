<?php
    global $wpdb;
    $table = PLUGIN_PREFIX . "results";
    $domainids = get_domainid_by_assementid($post->ID);
    $list = $_GET['list'];

    $domain_count = count($domainids);
    $nextdomain = ($list == $domain_count) ? "resume" : $list + 1;

    /**
     * Get Response via Token
     * @code begin
     */
    $response_sql = $wpdb->prepare("SELECT
	*
    FROM
	`" . PLUGIN_PREFIX . "response`
    WHERE
	`assessment_id` = %d AND
	`token` = %s",
	$post->ID,
	htmlspecialchars($_COOKIE["GAT_token"])
    );

    $response = $wpdb->get_row($response_sql);
    /**
     * Get Response via Token
     * @code end
     */

    foreach($domainids as $key => $domainid)
    {
	if(($key + 1) == $list)
	{
	    $domain = get_post($domainid);
	    $title =  $domain->post_title;
	    $content =  $domain->post_content;
	}
    }

    if($list < $domain_count)
    {
	$n_domain = get_post($domainids[$list]);
    }

    $dimensions = get_alldimension_domainid($domain->ID);
    $rating_scale = get_post_meta($post->ID, "rating_scale", TRUE); ?>

<form method="post" id="assessment_data">
    <input type="hidden" name="assessment_id" value="<?php echo $post->ID; ?>" />
    <input type="hidden" name="domain_id" value="<?php echo $domain->ID; ?>" />
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_COOKIE['GAT_token']); ?>" />
    <input type="hidden" name="next_domain" value="<?php echo $nextdomain; ?>" />

    <h3><?php echo $post->post_title . ': ' . $title; ?></h3>
    <div class="col-md-9 col-sm-12 col-xs-12">
	<div class="gat_moreContent"><?php echo $content; ?></div>
	<hr />
	<h4>Options</h4>
	<ul class="key-options">
	<?php
		$scales = get_rating_scale($rating_scale);
		foreach($scales as $scale) {
			?>
			<li><strong><?php echo $scale->post_title; ?>:</strong> <em><?php echo $scale->post_content; ?></em></li>
			<?php
		}
	?>
	</ul>
	<hr />
<?php
    if(isset($dimensions) && !empty($dimensions))
    {
	$i=1;
	

	foreach($dimensions as $dimension)
	{
	    echo '<h4 class="gat_dimension_header" id="gat'.$i.'">'.$i.': '.stripslashes($dimension->title).'</h4>';
	    echo '<p class="gat_dimension_desc">'.stripslashes($dimension->description).'</p>';

	    $sql = $wpdb->prepare("SELECT rating_scale from $table where dimension_id=%d && token=%s", $dimension->id, htmlspecialchars($_COOKIE['GAT_token']));
	    $result = $wpdb->get_row($sql);
	    $divcls = '';

	    if( ! empty($result->rating_scale))
	    {
		$scale_slctd = $result->rating_scale;
		$divcls = 'selectedarea';
	    }
	    else
	    {
		$scale_slctd = '';
	    } ?>
	<input type="hidden" name="dimension_id[]" value="<?php echo $dimension->id; ?>" />
	<div class="dimension_question">
	<ul class="gat_domain_rating_scale">
    <?php
	    $j = 1;
	    foreach($scales as $scale)
	    {
		if(!empty($scale_slctd))
		{
		    if($j == $scale_slctd):
			$selected_content =  $scale->post_content;
			$licls = 'selectedli';
		    else:
			$licls = '';
		    endif;
		} ?>
	    <li tabindex="0" onclick="select_rating(this)" class="rating_scaleli <?php echo $licls;?>" data-rating="<?php echo $j;?>">
		<input type="radio" name="rating_<?php echo $dimension->id; ?>[]" value="<?php echo $scale_slctd; ?>" <?php if ($j==$scale_slctd): ?>checked="true"<?php endif; ?> />
		    <?php echo $scale->post_title; ?>
		    <div class="rating_scale_description">
			<?php //echo $scale->post_content; ?>
		    </div>
	    </li>
	    <?php
		$j++;
	    } ?>
	    </ul>
	</div>
	    <!--<div class="gat_scaledescription_cntnr <?php //echo $divcls; ?>"><?php //echo $selected_content; ?></div>-->
	<?php
	    $i++;
	}
    } ?>
	<ul class="gat_domainsbmt_btn <?php if($list==$domain_count){ echo "gat_twobuttons"; } elseif ($list==3) { echo "gat_thirddomain"; } ?>">
	    <li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default gat_button">Back to Home</a></li>
	    <li><?php if ($list==$domain_count) : ?><input type="submit" class="btn btn-default gat_button gat_btn_submit" name="gat_results" value="Get Results" /><?php endif; ?></li>
	    <!--<li><input type="submit" class="btn btn-default gat_button" name="gat_videos" value="Get Video Playlist" /></li>-->
	<?php
	    if($list < $domain_count): ?>
	    <li><input type="submit" class="btn btn-default gat_button gat_btn_submit" name="domain_submit" value="Continue to <?php echo $n_domain->post_title; ?>"/></li>
	<?php
	    endif; ?>
	</ul>
    </div>
</form>
<div id="progress-box" class="col-md-3 col-sm-12 col-xs-12">
    <?php progress_indicator_sidebar($post->ID, htmlspecialchars($_COOKIE['GAT_token'])); ?>
</div>