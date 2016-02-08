<?php
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
        <!--<div id="message" class="updated notice notice-success is-dismissible below-h2">
        	<p>Organizations imported. <a href="?page=get-organizations">View organizations</a></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>-->
    <?php endif; ?>
    <form enctype="multipart/form-data" method="post" class="media-upload-form" id="file-form">
        <p>
        	<input type="file" name="organizations" id="organizations">
            <input type="submit" name="html-upload" id="html-upload" class="button" value="Upload">
        </p>
        <div class="clear"></div>
        <p class="max-upload-size">Maximum upload file size: <?php echo $max_upload; ?> MB.</p>
	<p class="district-count">Number of districts: <?php echo gat_district_count(); ?></p>
    </form>
</div>

<div class="plugin-footer">
    <div class="plugin-info"><?php echo GAT_PLUGIN_NAME . " " . GAT_PLUGIN_VERSION .""; ?></div>
    <div class="plugin-link"><a href='<?php echo GAT_PLUGIN_INFO ?>' target='_blank'>More info</a></div>
    <div class="clear"></div>
</div>