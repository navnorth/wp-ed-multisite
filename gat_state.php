<?php
function gat_state($state=NULL)
{
	global $wpdb;
	$organization = PLUGIN_PREFIX . "organizations";
	$states = $wpdb->get_results("select distinct LSTATE from $organization");
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
	$disticts = $wpdb->get_results("SELECT distinct LEAID, LEANM FROM $organization WHERE LSTATE='$state' ORDER BY LEANM ASC");
	if(!empty($disticts))
	{
		$return = '<label for="district">District</label>
                   <select name="district" class="form-control gatfields">';
					foreach($disticts as $distict)
					{
						$return .= '<option value="'.$distict->LEAID.'">'.$distict->LEANM.'</option>';
					}
		$return .= '</select>'; 			
	}
	echo $return;
	die;
}
?>