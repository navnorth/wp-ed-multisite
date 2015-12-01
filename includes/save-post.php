<?php
//save metabox for domain
add_action( 'save_post', 'gat_domain_save' );
function gat_domain_save()
{
	global $post, $wpdb;
	$slug = 'domain';
	if($post->post_type != $slug)
	{
		return;
	}
	extract($_POST);
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$videotable = PLUGIN_PREFIX . "videos";
	if(isset($dimension_id) && !empty($dimension_id))
	{
		$sql = $wpdb->prepare("delete from $videotable where domain_id=%d", $post->ID);
		$wpdb->query($sql);
		if(isset($dimension_title) && !empty($dimension_title))
		{
			for($i = 0; $i < count($dimension_title); $i++)
			{
				if(isset($dimension_id[$i]) && !empty($dimension_id[$i]))
				{
					$sql = $wpdb->prepare('update '.$dimensiontable.' SET assessment_id=%d, domain_id=%d, title=%s, description = %s, dimension_order = %d where id=%d', $assessmentid, $post->ID, $dimension_title[$i], $dimension_content[$i], $dimension_id[$i],  $dimension_order[$i]);
					$wpdb->query($sql);
					$lastid = $dimension_id[$i];
				}
				else
				{
					$sql = $wpdb->prepare('insert into '.$dimensiontable.' (assessment_id, domain_id, title, description, dimension_order) VALUES (%d, %d , %s, %s, %d)', $assessmentid, $post->ID, $dimension_title[$i], $dimension_content[$i], $dimension_order[$i]);
					$wpdb->query($sql);
					$lastid = $wpdb->insert_id;
				}
				$var = $i+1;
				if(isset(${'dimension_' . $var .'_videolabel'}) && !empty(${'dimension_' . $var .'_videolabel'}))
				{
					for($j = 0; $j < count(${'dimension_' . $var .'_videolabel'}); $j++)
					{
						if(isset(${'dimension_' . $var .'_ratingscale'. $j}) && !empty(${'dimension_' . $var .'_ratingscale'. $j}))
						{
							$ratingscale = serialize(${'dimension_' . $var .'_ratingscale'. $j});
						}
						else
						{
							$ratingscale = '';
						}
						$sql = $wpdb->prepare("insert into $videotable (domain_id, dimensions_id, label, youtubeid, rating_scale) VALUES (%d, %d , %s, %s, %s)", $post->ID, $lastid, ${'dimension_' . $var .'_videolabel'}[$j], ${'dimension_' . $var .'_videoid'}[$j], $ratingscale);
						$wpdb->query($sql);
					}//video loop end here
				}
			}//dimension loop end here
		}
	}
	else
	{
		if(isset($dimension_title) && !empty($dimension_title))
		{
			for($i = 0; $i < count($dimension_title); $i++)
			{
				$sql = $wpdb->prepare('insert into '.$dimensiontable.' (assessment_id, domain_id, title, description, dimension_order) VALUES (%d, %d ,%s, %s, %d)', $assessmentid, $post->ID, $dimension_title[$i], $dimension_content[$i], $dimension_order[$i]);
				$wpdb->query($sql);
				$lastid = $wpdb->insert_id;
				$var = $i+1;
				if(isset(${'dimension_' . $var .'_videolabel'}) && !empty(${'dimension_' . $var .'_videolabel'}))
				{
					for($j = 0; $j < count(${'dimension_' . $var .'_videolabel'}); $j++)
					{
						if(isset(${'dimension_' . $var .'_ratingscale'. $j}) && !empty(${'dimension_' . $var .'_ratingscale'. $j}))
						{
							$ratingscale = serialize(${'dimension_' . $var .'_ratingscale'. $j});
						}
						else
						{
							$ratingscale = '';
						}
						$sql = $wpdb->prepare("insert into $videotable (domain_id, dimensions_id, label, youtubeid, rating_scale) VALUES (%d, %d, %s, %s, %s)", $post->ID, $lastid, ${'dimension_' . $var .'_videolabel'}[$j], ${'dimension_' . $var .'_videoid'}[$j], $ratingscale);
						$wpdb->query($sql);
					}//video loop end here
				}
			}//dimension loop end here
		}
	}
	echo '<script type="text/javascript">window.location = "'.site_url().'/wp-admin/post.php?post='.$assessmentid.'&action=edit"</script>';
	die;
}
//save metabox for assessment
add_action( 'save_post', 'gat_assessment_save' );
function gat_assessment_save()
{
	global $post;
	$slug = 'assessment';
	if($post->post_type != $slug)
	{
		return;
	}
	extract($_POST);
	foreach($domainid as $key=>$id)
	{
		$result = set_domain_order($id, $domainorder[$key]);
	}
	update_post_meta($post->ID, "assessment_featurevideo", $assessment_featurevideo);
	update_post_meta($post->ID, "result_content", $result_content);
	update_post_meta($post->ID, "playlist_content", $playlist_content);
	update_post_meta($post->ID, "full_library_content", $full_library_content);
	update_post_meta($post->ID, "rating_scale", $rating_scale);
}
//save metabox for rating
add_action( 'save_post', 'gat_rating_save' );
function gat_rating_save()
{
	global $post;
	$slug = 'rating';
		if($post->post_type != $slug)
	{
		return;
	}
	extract($_POST);
	update_post_meta($post->ID, "rating_order", $rating_order);
}
?>