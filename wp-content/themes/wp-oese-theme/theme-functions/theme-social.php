<?php
// function theme_admin_menu()
// {
// 	add_theme_page('Social Media Options', 'Social Media Options', 'edit_theme_options', 'socialmedia-options', 'socialmedia_settings');
// }
// add_action('admin_menu', 'theme_admin_menu');

// function socialmedia_settings()
// {
// 	if(isset($_POST["save_social"]))
// 	{
// 		extract($_POST);
// 		update_option("twitter_url", $twitter_url);
// 		update_option("facebook_url", $facebook_url);
// 		update_option("youtube_url", $youtube_url);
// 		update_option("linkedin_url", $linkedin_url);
// 		update_option("subscribe_url", $subscribe_url);
// 	}

// 	$twitter_url = get_option("twitter_url");
// 	$facebook_url = get_option("facebook_url");
// 	$youtube_url = get_option("youtube_url");
// 	$subscribe_url = get_option("subscribe_url");


// 	$return = '';
// 	$return .=  '<div class="wrap">
// 					<h2>Social Media Setting</h2>';

// 	$return .= '<form method="post">';
// 		$return .= '<div class="sclmda_wrpr">
// 					  <div class="sclmda_sub_wrapper">
// 							<div class="sclmda_txt"><strong>Twitter</strong></div>
// 							<div class="sclmda_fld"><input type="text" name="twitter_url" value="'. $twitter_url.'" /></div>
// 					  </div>
// 					  <div class="sclmda_sub_wrapper">
// 							<div class="sclmda_txt"><strong>Facebook</strong></div>
// 							<div class="sclmda_fld"><input type="text" name="facebook_url" value="'. $facebook_url.'" /></div>
// 					  </div>
// 					  <div class="sclmda_sub_wrapper">
// 							<div class="sclmda_txt"><strong>Youtube</strong></div>
// 							<div class="sclmda_fld"><input type="text" name="youtube_url" value="'. $youtube_url.'" /></div>
// 					  </div>
// 					  <div class="sclmda_sub_wrapper">
// 							<div class="sclmda_txt"><strong>Google Plus</strong></div>
// 							<div class="sclmda_fld"><input type="text" name="google_url" value="'. $google_url.'" /></div>
// 					  </div>
// 					  <div class="sclmda_sub_wrapper">
// 							<div class="sclmda_txt"><strong>Link To Newsletter</strong></div>
// 							<div class="sclmda_fld"><input type="text" name="subscribe_url" value="'. $subscribe_url.'" /></div>
// 					  </div>
// 					  <div class="sclmda_sub_wrapper">
// 							<div class="sclmda_txt"></div>
// 							<div class="sclmda_fld"><input type="submit" name="save_social" value="Save Settings" /></div>
// 					  </div>

// 					</div>';
// 	$return .= '</form>';

// 	echo $return;
// }
?>
