<?php
/*Add Dimensions*/
add_action('wp_ajax_addfield_call','get_dimensions');
function get_dimensions()
{
	if(isset($_POST['editorid']) && !empty($_POST['editorid']))
	{
		//$editor_id = generateRandomString();
		//$editor_id = $editor_id.'_'.$_POST['editorid'];
		$order = '<a href="javascript:" class="order_anch up" data-order="up" onclick="orderchange(this)"></a>
        		  <a href="javascript:" class="order_anch" data-order="down" onclick="orderchange(this)"></a>';
		$count = $_POST['count'];
	}
	else
	{
		//$editor_id = generateRandomString();
		$order = '<a href="javascript:" class="order_anch" data-order="up" onclick="orderchange(this)"></a>
        		  <a href="javascript:" class="order_anch" data-order="down" onclick="orderchange(this)"></a>';
		$count = 1;
	}
	?>
    	<div class="gat_dimention_wrpr">
        	<div class="gat_cntrlr_wrpr">
            	<span class="count"><?php echo $count; ?>.</span>
                <div class="action">
                	<a href="javascript:" onclick="delete_dimension(this)" class="button button-primary">Delete</a>
                </div>
                <div class="order">
                	<?php echo $order; ?>
                </div>
            </div>
            <div class="gat_inside_wrpr">
            	<div class="gat_fldwrpr">
                	<input type="text" name="dimension_title[]" autocomplete="off" spellcheck="true" value="" class="wp_title" />
                </div>
                <div class="gat_fldwrpr">
                 	<textarea rows="5" name="dimension_content[]" class="gat_editabletextarea"></textarea>
                    <!--<div class="gat_editablediv" onclick="initareaodoo();"></div>-->
                </div>
                <div class="gat_fldwrpr">
                	<div class="gat_fldtopwrpr">
                    	<label>Associated Videos : </label>
                        <p><a href="javascript:" onclick="add_video(this)" class="button button-primary" data-count="<?php echo $count; ?>" >Add +</a></p>
                    </div>
                    <div class="gat_fldinsidewrpr">
                    	<table class="wp-list-table widefat fixed gat_table">
                        	<thead>
                            	<tr>
                                	<th>Label</th>
                                    <th>YouTube Id</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
	die;
}

/*Delete Dimensions*/
add_action('wp_ajax_delete_dimensions','gat_delete_dimensions_func');
function gat_delete_dimensions_func()
{
	global $wpdb;
	extract($_POST);
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$videotable = PLUGIN_PREFIX . "videos";
	$sql = $wpdb->prepare("delete from $dimensiontable where id=%d", $dimensionid);
	$wpdb->query($sql);
	$sql = $wpdb->prepare("delete from $videotable where dimensions_id=%d",$dimensionid);
	$wpdb->query($sql);
	die;
}

/*Delete Domain*/
add_action('wp_ajax_delete_domain','delete_domain_function');
function delete_domain_function()
{
	global $wpdb;
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$videotable = PLUGIN_PREFIX . "videos";
	extract($_POST);
	wp_delete_post($domainid);
	$sql = $wpdb->prepare("DELETE FROM $dimensiontable WHERE domain_id=%d", $domainid);
	$wpdb->query($sql);
	$sql = $wpdb->prepare("DELETE FROM $videotable WHERE domain_id=%d", $domainid);
	$wpdb->query($sql);
	die;
}

/*Dynamic update of progress bar when user answer for the questions*/
add_action('wp_ajax_save_assessment','save_assessment_function');
add_action('wp_ajax_nopriv_save_assessment','save_assessment_function');
function save_assessment_function()
{
	global $wpdb;
	extract($_POST);
	$dimensiontable = PLUGIN_PREFIX . "dimensions";
	$results_table = PLUGIN_PREFIX . "results";

	$sql = $wpdb->prepare("SELECT COUNT(*) FROM $dimensiontable where assessment_id=%d", $assessment_id);
	$data = $wpdb->get_results( $sql, OBJECT_K );
	$data = array_keys($data);
	$total_dimension = $data[0];

	$ratingcount = 0;
	for($i=0; $i < count($dimension_id); $i++)
	{
		$dimensionid = $dimension_id[$i];
		$rating = ${'rating_' . $dimensionid};
        $filtered = is_array($rating) ? array_filter($rating, 'filter_callback') : '';
		if(!empty($filtered))
		{
			$ratingcount++;
		}
	}
	$dimension_id = implode(",", $dimension_id);

	$sql = $wpdb->prepare("SELECT count(*) AS cnt FROM $results_table WHERE assessment_id =%d && token=%s &&( rating_scale != NULL
OR rating_scale != '' ) && dimension_id NOT IN ($dimension_id) ", $assessment_id, $token);
	$data = $wpdb->get_results($sql, OBJECT_K );
	$data = array_keys($data);
	$total_rated = $data[0];

	$progress = (($total_rated+$ratingcount)/$total_dimension)*100;
	echo ceil($progress);
	die;
}

/*Track record of play video*/
add_action('wp_ajax_gat_trackrecord','gat_trackrecord_func');
add_action('wp_ajax_nopriv_gat_trackrecord','gat_trackrecord_func');
function gat_trackrecord_func()
{
	global $wpdb;
	$resulted_video = PLUGIN_PREFIX . "resulted_video";
	extract($_POST);
	if(isset($resultedid) && !empty($resultedid))
	{
		$sql = $wpdb->prepare("update $resulted_video set start='0', end=%s, seek=%s where id = %d", $videottltime, $videocrrnttime, $resultedid);
		$wpdb->query($sql);
		$seek = ceil($videocrrnttime);
		$end = ceil($videottltime);
		$complete = 0;
		if(!empty($seek) && !empty($end))
		{
			$complete = ($seek/$end)*100;
			$complete = ceil($complete);
		}
	}
	die(json_encode(array('complete'=> $complete, 'seek'=> $videocrrnttime)));
}
?>