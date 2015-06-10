<?php
//Add metaboxs to assessment post type
function assessment_metabox_func()
{
	add_meta_box('assessment_result_contentid','Result Content','result_content_func','assessment','advanced');
	add_meta_box('assessment_rating_scale','Rating Scale','rating_scale_func','assessment','advanced');
	add_meta_box('assessment_domain','Domains','domain_func','assessment','advanced');
	add_meta_box('assessment_featurevideo','Feature Video','video_func','assessment','side');
}
function video_func()
{
	global $post;
	$video = get_post_meta($post->ID, "assessment_featurevideo", true);
	echo '<input type="text" name="assessment_featurevideo" value="'.$video.'" placeholder="Youtub video Id"/>';
}
function result_content_func()
{
	global $post;
	$content = get_post_meta($post->ID, "result_content", true);
	$editor_id = "result_content";
	wp_editor( $content, $editor_id, $settings = array('textarea_name'=> 'result_content', 'textarea_rows'=> 5));
}
function rating_scale_func()
{
	global $post;
	
	if($post->post_status != 'publish')
	{
		$post->post_status = 'publish';
		wp_insert_post( $post );
	}
	$rating_scale = get_post_meta($post->ID, "rating_scale", true);
	$args = array(
		'hide_empty'        => false, 
		'fields'            => 'all', 
		'pad_counts'        => false, 
		'cache_domain'      => 'core'
	); 
	$terms = get_terms("scale", $args);
	$html = '<select name="rating_scale">';
		foreach($terms as $term)
		{
			if($rating_scale == $term->name){ $check = 'selected="selected"';}else{ $check = ''; }
			$html .= '<option '.$check.' value="'.$term->name.'">'.$term->name.'</option>';
		}
	$html .= '</select>';
	echo $html;
}
function domain_func()
{
	global $post;
	$domainids = get_domainid_by_assementid($post->ID);
	$html = '';
	$html .= '<div class="gat_wrpr">';
	$html .= '<table class="wp-list-table widefat fixed">';
		$html .= '<thead>';
			$html .= '<tr>';
				$html .= '<th></th>';
				$html .= '<th></th>';
				$html .= '<th>Domain Title</th>';
				$html .= '<th>Dimension</th>';
				$html .= '<th>Videos</th>';
				$html .= '<th></th>';
				$html .= '<th></th>';
			$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
			$i = 1;
			foreach($domainids as $domainid)
			{
				$domain = get_post($domainid);
				$html .= '<tr>';
					if($i == 1)
					{
						$html .= '<td><a href="javascript:" onclick="domain_order(this)" data-order="up" class=""></a></td>';
						$html .= '<td><a href="javascript:" onclick="domain_order(this)" data-order="down" class="dmnordr_dwn"></a></td>';
					}
					elseif($i == count($domainids))
					{
						$html .= '<td><a href="javascript:" onclick="domain_order(this)" data-order="up" class="dmnordr_up"></a></td>';
						$html .= '<td><a href="javascript:" onclick="domain_order(this)" data-order="down" class=""></a></td>';
					}
					else
					{
						$html .= '<td><a href="javascript:" onclick="domain_order(this)" data-order="up" class="dmnordr_up"></a></td>';
						$html .= '<td><a href="javascript:" onclick="domain_order(this)" data-order="down" class="dmnordr_dwn"></a></td>';
					}
					$html .= '<td>'.$domain->post_title.'</td>';
					$html .= '<td>'.get_dimensioncount($domainid).'</td>';
					$html .= '<td>'.get_videocount($domainid).'</td>';
					$html .= '<td><a href="'.site_url().'/wp-admin/post.php?post='.$domainid.'&action=edit" class="button button-primary">Edit</a></td>';
					$html .= '<td><a href="javascript:" class="button button-primary" onclick="delete_domain(this)" data-id="'.$domainid.'">Delete</a></td>';
				$html .= '</tr>';
				$i++;
			}
		$html .= '</tbody>';
	$html .= '</table>';
	
	$html .= '</div>';
	$html .= '<p class="gat_btnwrpr"><a class="add-new-h2" href="post-new.php?post_type=domain&assessmentid='.$post->ID.'">Add New Domain</a></p>';
	$html .= '<div class="clear"></div>';
	echo $html;
}
?>