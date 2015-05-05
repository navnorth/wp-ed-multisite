<?php
function twentytwelve_child_theme_menu()
{
	add_theme_page('Assign Widgets to Pages', 'Assign Widgets to Pages', 'edit_theme_options', 'theme-options', 'theme_options_settings');
}
add_action('admin_menu', 'twentytwelve_child_theme_menu');
function theme_options_settings()
{
	$temlate_sidebar = array(
						"publication-template" 	=> "page-templates/publication-template.php",
						"toolkit-template" 		=> "page-templates/toolkit-template.php",
						"default-template" 		=> "default",
						"blog-index-template"	=> "page-templates/blog-index-template.php",
						"toolkit-subpage-template" => "page-templates/toolkit-subpage-template.php");

	if(isset($_REQUEST) && !empty($_REQUEST))
	{
		if($_REQUEST["action"] == "widget_assign")
		{
			global $wp_registered_sidebars, $wp_registered_widgets;
			$page_id = $_REQUEST["page_id"];

			if(isset($_POST["save_widget"]))
			{
				if(isset($_POST["widget_id"]))
				{
					$data = serialize($_POST["widget_id"]);
					update_post_meta($page_id, "_oer_assign_widget", $data);
				}
				else
				{
					update_post_meta($page_id, "_oer_assign_widget");
				}
			}

			$temlpate = get_post_meta($page_id,"_wp_page_template",true);
			$oer_assign_widget = unserialize(get_post_meta($page_id,"_oer_assign_widget",true));



			foreach($temlate_sidebar as $key => $value)
			{
				if($value == $temlpate)
				{
					$index = $key;
				}
			}

			$sidebars_widgets = wp_get_sidebars_widgets();
			$return = '';
			$widget_ids = $sidebars_widgets[$index];

			$strphs = array("-","_");
			$return .=  '<div class="wrap">
					<h2>'.get_the_title( $page_id ).'</h2>
					<h4>Assigned Template : '. ucwords(str_replace($strphs," ",$index)) .' </h4>';

			$return .= '<form method="post">

				  <input type="submit" name="save_widget" value="Save Setting" id="cstm_wdgt_btn" />
				  <div class="oer_widget_wrapper">
				  <div class="sub_wrapper">
						<div class="sub_wrapper_fld"><input type="checkbox" name="widget_id[]" value="" /></div>
						<div class="sub_wrapper_txt"><strong>Widget Title</strong></div>
				  </div>';

			if( !empty($widget_ids) )
			{
				foreach( $widget_ids as $id )
				{
					$chekd = '';
					if($oer_assign_widget && !empty($oer_assign_widget) && in_array($id,$oer_assign_widget))
					{
						$chekd = 'checked="checked"';
					}

					$name = $wp_registered_widgets[$id]['callback'][0]->name;
					$option_name = $wp_registered_widgets[$id]['callback'][0]->option_name;
					$key = $wp_registered_widgets[$id]['params'][0]['number'];
					$widget_data = get_option($option_name);
					$output = (object) $widget_data[$key];

					$return .= '<div  class="sub_wrapper">
							<div class="sub_wrapper_fld"><input type="checkbox" name="widget_id[]" value="'.$id.'" '.$chekd.'/></div>
							<div class="sub_wrapper_txt">'. $output->title.' <b>{ '.ucwords(str_replace($strphs," ",$name)).' }</b></div>
						 </div>';
				}
			}
			else
			{
				$return .= '<div  class="sub_wrapper">
							<div class="sub_wrapper_fld">.</div>
							<div class="sub_wrapper_txt">No Widget Assign To This Page</div>
						 </div>';
			}
			$return .= '</div>
				  <input type="submit" name="save_widget" value="Save Setting" id="cstm_wdgt_btn" />
				  </form>
				  </div>';
			echo $return;
		}
		else
		{
			$args = array(
				'sort_order' => 'ASC',
				'sort_column' => 'post_title',
				'hierarchical' => 0,
				'exclude' => '',
				'include' => '',
				'meta_key' => '',
				'meta_value' => '',
				'authors' => '',
				'child_of' => 0,
				'parent' => -1,
				'exclude_tree' => '',
				'number' => '',
				'offset' => 0,
				'post_type' => 'page',
				'post_status' => 'publish');
		$pages = get_pages($args);

		$return .= '<table class="wp-list-table widefat fixed pages">
			  <thead>
				<tr>
					<th id="title" class="manage-column column-title custm" style="" scope="col">Page Title</th>
					<th id="view" class="manage-column column-view" style="" scope="col">View Page</th>
					<th id="author" class="manage-column column-author" style="" scope="col">Author</th>
					<th id="date" class="manage-column column-date" style="" scope="col">Date</th>
				</tr>
			  </thead>
			  <tbody>';

			  foreach($pages as $page)
			  {
				 $user = get_user_by( 'id', $page->post_author);

				 $return .= '<tr>';
				 $return .= '<td>
				 				<a target="_blank" href="'.site_url().'/wp-admin/themes.php?page=theme-options&action=widget_assign&page_id='.$page->ID.'">
									<strong>'.$page->post_title.'</strong>
								</a>
							</td>';
				 $return .= '<td><a href="'.get_permalink($page->ID).'" target="_blank">View Page</a></td>';
				 $return .= '<td>'.$user->user_login.'</td>';
				 $return .= '<td>'.$page->post_modified.'</td>';
				 $return .= '</tr>';
			  }
		$return .= '</tbody>
				</table>';
		echo $return;
	  }
   }
}
?>
