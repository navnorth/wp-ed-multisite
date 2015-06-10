<?php
//add metabox for rating post type
function rating_metabox_func()
{
	add_meta_box('rating_scale_order','Order','rating_scale_orderfunctions','rating','side', 'high');
}
function rating_scale_orderfunctions()
{
	global $post;
	$scales = wp_get_post_terms( $post->ID, 'scale' );
	foreach($scales as $scale)
	{
		if(isset($scale) && !empty($scale))
		{
			$oredercount = $scale->count;
			break;
		}
	}
	if(!isset($oredercount) || empty($oredercount))
	{
		$oredercount = 0;
	}
	$rating_order = get_post_meta($post->ID, "rating_order", true);
	$return .= '<select name="rating_order">';
		$return .= '<option value="">--Select order--</option>';
		for($i = 1; $i <= $oredercount; $i++)
		{
			$check = ($i == $rating_order)? 'selected="selected"': '';
			$return .= '<option '.$check.' value="'.$i.'">'.$i.'</option>';
		}
	$return .= '</select>';
	echo $return;
}
add_filter( 'manage_edit-rating_columns', 'rating_columns_filter',10, 1 );
function rating_columns_filter($columns)
{
	$columns['order'] = 'Order';
	return $columns;
}

//adding values to custom columns
add_action( 'manage_rating_posts_custom_column', 'manage_rating_columns');
function manage_rating_columns( $column )
{
	global $post;
	switch( $column ) {
		case 'order':
			echo get_post_meta($post->ID, "rating_order", true);
		break;
	}
}
?>