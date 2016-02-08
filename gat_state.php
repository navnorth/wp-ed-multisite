<?php
function gat_state($state=NULL)
{
	global $wpdb;
	$organization = PLUGIN_PREFIX . "organizations";
	$states = $wpdb->get_results("select distinct LSTATE from $organization ORDER BY LSTATE");
	if(!empty($states))
	{
		foreach($states as $state)
		{
			if(!empty($state) && $state == $state->LSTATE){ $slct = 'selected="selected"'; }else{ $slct = ''; }
			echo '<option value="'.$state->LSTATE.'" '.$slct.' >'.$state->LSTATE.'</option>';
		}
	}
}
add_action('wp_ajax_gat_districtcode','gat_districtcode_function');
add_action('wp_ajax_nopriv_gat_districtcode','gat_districtcode_function');
function gat_districtcode_function()
{
	global $wpdb;
	$organization = PLUGIN_PREFIX . "organizations";
	extract($_POST);
	$sql = $wpdb->prepare("SELECT distinct LEAID, LEANM FROM $organization WHERE LSTATE=%s ORDER BY LEANM ASC", $state);
	$disticts = $wpdb->get_results($sql);
	if(!empty($disticts))
	{
		$return = '<label for="district">District</label>
                   <select name="district" class="form-control">';
					foreach($disticts as $distict)
					{
						$return .= '<option value="'.$distict->LEAID.'">'.$distict->LEANM.'</option>';
					}
		$return .= '</select>'; 			
	}
	echo $return;
	die;
}

function gat_district_count($state = null){
	global $wpdb;
	$organization = PLUGIN_PREFIX . "organizations";
	if ($state)
		$sql = $wpdb->prepare("SELECT COUNT(distinct LEANM) FROM $organization WHERE LSTATE=%s ORDER BY LEANM ASC", $state);
	else
		$sql = "SELECT COUNT(distinct LEANM) FROM $organization";
	$distict_count = $wpdb->get_results($sql);
	return $district_count;
}

function gat_school_count() {
	
}
?>