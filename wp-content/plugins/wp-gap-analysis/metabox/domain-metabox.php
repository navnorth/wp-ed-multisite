<?php
//Add metaboxs to domain post type
function domain_metabox_func()
{
	add_meta_box('domain_dimensions','Dimensions','domain_dimensions_functions','domain','advanced');
}
function domain_dimensions_functions()
{
	global $post, $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	if(isset($_REQUEST['assessmentid']) && !empty($_REQUEST['assessmentid']))
	{
		$assessmentid = $_REQUEST['assessmentid'];
	}
	else
	{
		$assessmentid = get_assessmentid_by_domainid($post->ID);
	}
	echo '<div class="gat_wrpr">';
			echo '<input type="hidden" name="assessmentid" value="'.$assessmentid.'" />';
			get_dimensions_data($post->ID);
	echo '</div>';
	
	$count = get_dimensioncount($post->ID);
	echo '<p class="gat_btnwrpr">
			<a class="add-new-h2" href="javascript:" onclick="add_dimension(this)" data-editorid="'.$count.'">
				Add New Dimension
			</a>
		  </p>';
	echo '<div class="clear"></div>';	  
}
?>