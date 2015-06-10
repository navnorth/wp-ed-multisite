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
		$wpdb->query("delete from $videotable where domain_id=$post->ID");
		if(isset($dimension_title) && !empty($dimension_title))
		{
			for($i = 0; $i < count($dimension_title); $i++)
			{
				if(isset($dimension_id[$i]) && !empty($dimension_id[$i]))
				{
					$wpdb->query('update '.$dimensiontable.' SET assessment_id='.$assessmentid.', domain_id='.$post->ID.', title="'.$dimension_title[$i].'", description = "'.$dimension_content[$i].'" where id='.$dimension_id[$i].'');
					$lastid = $dimension_id[$i];
				}
				else
				{
					$wpdb->query('insert into '.$dimensiontable.' (assessment_id, domain_id, title, description) VALUES ('.$assessmentid.','.$post->ID.' ,"'.$dimension_title[$i].'", "'.$dimension_content[$i].'")');
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
						$wpdb->query("insert into $videotable (domain_id, dimensions_id, label, youtubeid, rating_scale) VALUES ($post->ID, $lastid , '".${'dimension_' . $var .'_videolabel'}[$j]."', '".${'dimension_' . $var .'_videoid'}[$j]."', '".$ratingscale."')");
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
				$wpdb->query('insert into '.$dimensiontable.' (assessment_id, domain_id, title, description) VALUES ('.$assessmentid.','.$post->ID.' ,"'.$dimension_title[$i].'", "'.$dimension_content[$i].'")');
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
						$wpdb->query("insert into $videotable (domain_id, dimensions_id, label, youtubeid, rating_scale) VALUES ($post->ID, $lastid , '".${'dimension_' . $var .'_videolabel'}[$j]."', '".${'dimension_' . $var .'_videoid'}[$j]."', '".$ratingscale."')");
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
	update_post_meta($post->ID, "result_content", $result_content);
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