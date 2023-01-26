<?php
	if(isset($_POST['exportcsv']) && !empty($_POST['exportcsv']))
	{
		global $wpdb;
		extract($_POST);
		$responces = PLUGIN_PREFIX . "response";
		$sql = $wpdb->prepare("select * from $responces where assessment_id=%d", $assessment);
		$results = $wpdb->get_results($sql);

		//header("Content-type: text/csv; charset=UTF-8");
		//header('Content-Disposition: attachment; filename=Export.csv');

		// No point in creating the export file on the file-system. We'll stream it straight to the browser. Much nicer.

  		// Open the output stream
  		$fh = fopen('php://output', 'w');

		// Start output buffering (to capture stream contents)
		ob_start();

		//$fd = fopen(GAT_PATH.'GAT_Report_'.$fileDate.'.csv', "w");

		// CSV Header
		$header = array('Token','Email','State','Organization Id','Organization','Start Date','Last Saved','Progress','Overall Score');
		fputcsv($fh, $header);

		if(!empty($results))
		{
			foreach($results as $result)
			{
				$line = array($result->token, $result->email, $result->state, $result->organization_id, $result->organization,
							$result->start_date, $result->last_saved, $result->progress, $result->overall_score);

				fputcsv($fh, $line);
			}
		}
		//fwrite($fd, $contents);
		//fclose($fd);

		// Get the contents of the output buffer
  		$string = ob_get_clean();

		// Set the filename of the download
		$filename = 'GAT_Report_'.date('Ymd').'.csv';

		// echo '<script type="text/javascript">window.open("'.GAT_URL.'GAT_Report_'.$fileDate.'.csv", "_blank");</script>';

		// Output CSV-specific headers
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="' . $filename . '.csv";');
		header('Content-Transfer-Encoding: binary');

		// Stream the CSV data
		exit($string);
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