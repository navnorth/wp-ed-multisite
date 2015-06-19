<?php
global $wpdb;
$table = PLUGIN_PREFIX . "results";
$domainids = get_domainid_by_assementid($post->ID);
$list = $_GET['list'];
$nextdomain = $list+1;
$l =1;
foreach($domainids as $domainid)
{
	if($l == $list)
	{
		$domain = get_post($domainid);
		$title =  $domain->post_title;
		$content =  $domain->post_content;
	}
	if($list == count($domainids))
	{
		$nextdomain = "resume";
	}
	$l++;
}
$dimensions = get_alldimension_domainid($domain->ID);
$rating_scale = get_post_meta($post->ID, "rating_scale", true);
?>
<form method="post" id="assessment_data">
	<input type="hidden" name="assessment_id" value="<?php echo $post->ID; ?>" />
	<input type="hidden" name="domain_id" value="<?php echo $domain->ID; ?>" />
	<input type="hidden" name="token" value="<?php echo $_COOKIE['GAT_token']; ?>" />
	<input type="hidden" name="next_domain" value="<?php echo $nextdomain; ?>" />
	
	<h2><?php echo $post->post_title; ?></h2>
	<div class="col-md-9 col-sm-12 col-xs-12">
		<h4><?php echo $title; ?></h4>
		<div class="gat_content"><?php echo $content; ?></div>
		<hr />
		<?php
		if(isset($dimensions) && !empty($dimensions))
		{
			$i=1;
			foreach($dimensions as $dimension)
			{
				echo '<b>'.$i.': '.$dimension->title.'</b>';
				echo '<p>'.$dimension->description.'</p>';
				$scales = get_rating_scale($rating_scale);
				$sql = $wpdb->prepare("SELECT rating_scale from $table where dimension_id=%d && token=%s", $dimension->id, $_COOKIE['GAT_token']);
				$result = $wpdb->get_row($sql);
				if(!empty($result->rating_scale))
				{
					$scale_slctd = $result->rating_scale;
					$divcls = 'selectedarea';
				}
				?>
					<input type="hidden" name="dimension_id[]" value="<?php echo $dimension->id; ?>" />
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
							}
						?>
						<li tabindex="0" onclick="select_rating(this)" class="rating_scaleli <?php echo $licls;?>" data-rating="<?php echo $j;?>">
							<?php echo $j.' '.$scale->post_title; ?>
							<input type="hidden" name="rating_<?php echo $dimension->id; ?>[]" value="<?php echo $scale_slctd; ?>" />
							<div class="rating_scale_description">
								<?php echo $scale->post_content; ?>
							</div>
						</li>
						<?php
							$j++;
							}
						?>    
					</ul>
					<div class="gat_scaledescription_cntnr <?php echo $divcls; ?>"><?php echo $selected_content; ?></div>
				<?php
				$i++;
			}
		}
		?>
	  <ul class="gat_domainsbmt_btn">
		<li><a href="<?php echo get_permalink($post->ID); ?>?action=resume-analysis" class="btn btn-default">Back to Domains</a></li>
		<li><input type="submit" class="btn btn-default" name="gat_results" value="Get Results Now" /></li>
		<li><input type="submit" class="btn btn-default" name="domain_submit" value="Continue to next Domain"/></li>
	  </ul>  
	</div>
</form>
<div class="col-md-3 col-sm-12 col-xs-12">
	<?php progress_indicator_sidebar($post->ID, $_COOKIE['GAT_token']); ?>
</div>