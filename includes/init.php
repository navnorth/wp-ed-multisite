<?php
//Report function
function show_reports()
{
}
//Setting function
function import_organizations()
{
    if(isset($_POST["html-upload"]) AND isset($_FILES["organizations"]) AND $_FILES["organizations"]["size"])
    {
        include_once(GAT_PATH . "/classes/organization.php");
		 
		ini_set("max_execution_time", 0);
        ini_set("memory_limit", "1200M");
		ini_set('post_max_size', "1200M");
        set_time_limit(0);
        
        $file = fopen($_FILES["organizations"]["tmp_name"], "r") or die("Unable to read the file.");
        $line = 0;
        $organizations = $heading = array();
        
        while( ! feof($file))
        {
            $row = str_replace(array("\r", "\n"), NULL, fgets($file));
            
            if (strlen(trim($row))>0){
                if($line){
                    $organizations[] = array_combine($heading, explode("\t", $row));
                } else
                    $heading = explode("\t", $row);
                
                $line++;
            }
        }
        fclose($file);
        Organization::insert($organizations);
        $success = TRUE;
    }
	
	//Get max upload file size
    $max_upload = (int)(ini_get('upload_max_filesize'));
?>
<div class="wrap">
    <h2>Import Organizations</h2>
    <?php if($success): ?>
        <div id="message" class="updated notice notice-success is-dismissible below-h2">
        	<p>Organizations imported. <a href="?page=get-organizations">View organizations</a></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
    <?php endif; ?>
    <form enctype="multipart/form-data" method="post" class="media-upload-form" id="file-form">
        <p>
        	<input type="file" name="organizations" id="organizations">
            <input type="submit" name="html-upload" id="html-upload" class="button" value="Upload">
        </p>
        <div class="clear"></div>
        <p class="max-upload-size">Maximum upload file size: <?php echo $max_upload; ?> MB.</p>
    </form>
</div>
<?php
}
//Add metaboxs to assessment post type
function assessment_metabox_func()
{
	add_meta_box('assessment_result_contentid','Result Content','result_content_func','assessment','advanced');
	add_meta_box('assessment_rating_scale','Rating Scale','rating_scale_func','assessment','advanced');
	add_meta_box('assessment_domain','Domains','domain_func','assessment','advanced');
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
	echo $html = '<select name="rating_scale">
					<option value="1-4">1-4 Scale</option>
				 </select>';
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