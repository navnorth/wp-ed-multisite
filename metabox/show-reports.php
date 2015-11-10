<?php
	if(isset($_POST['exportcsv']) && !empty($_POST['exportcsv']))
	{
		global $wpdb;
		extract($_POST);
		$responces = PLUGIN_PREFIX . "response";
		$sql = $wpdb->prepare("select * from $responces where assessment_id=%d", $assessment);
		$results = $wpdb->get_results($sql);
		
		header("Content-type: text/csv; charset=UTF-8");
		header('Content-Disposition: attachment; filename=Export.csv');
		
		// date the file is created in YYYYMMDD format
		$fileDate = strftime( '%G%m%d' ,time());
		
		$fd = fopen(GAT_PATH.'GAT_Report_'.$fileDate.'.csv', "w");
		$contents = "Token,Email,State,Organization Id,Organization,Start Date,Last saved,Progress,Overall Score\n";
		if(!empty($results))
		{
			foreach($results as $result)
			{
				$contents .= $result->token.",";
				$contents .= $result->email.",";
				$contents .= $result->state.",";
				$contents .= $result->organization_id.",";
				$contents .= $result->organization.",";
				$contents .= $result->start_date.",";
				$contents .= $result->last_saved.",";
				$contents .= $result->progress.",";
				$contents .= $result->overall_score."\n";
			}
		}
		fwrite($fd, $contents);
		fclose($fd);
		echo '<script type="text/javascript">window.open("'.GAT_URL.'GAT_Report_'.$fileDate.'.csv", "_blank");</script>';
	}
	
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'assessment',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$posts = get_posts( $args );
?>
<div class="wrap">
    <h2>Export Responses</h2>
    <form enctype="multipart/form-data" method="post">
        <p>
        	<select name="assessment">
            	<option value="">-- Select Assessment --</option>
                <?php
					if(isset($posts) && !empty($posts))
					{
						foreach($posts as $post)
						{
							echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>';
						}
					}
				?>
            </select>
            <input type="submit" name="exportcsv" class="button" value="Export">
        </p>
        <div class="clear"></div>
    </form>
</div>