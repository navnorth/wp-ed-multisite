<?php
function twentytwelve_menu()
{
	add_theme_page('Theme Settings', 'Theme Settings', 'edit_theme_options', 'oet-theme-options', 'socialmedia_settings');
}
add_action('admin_menu', 'twentytwelve_menu');

function oet_add_theme_settings_script(){
	wp_enqueue_script( 'theme-settings-script', get_stylesheet_directory_uri() . '/js/theme-settings-script.js' );
}
add_action('admin_enqueue_scripts','oet_add_theme_settings_script');

function socialmedia_settings()
{
	$notice = null;
	if(isset($_POST["save_social"]))
	{
		extract($_POST);
		if (isset($google_analytics_id))
			update_option("google_analytics_id", $google_analytics_id);
		if (isset($twitter_url))
			update_option("twitter_url", $twitter_url);
		if (isset($facebook_url))
			update_option("facebook_url", $facebook_url);
		if (isset($yotube_url))
			update_option("yotube_url", $yotube_url);
		if (isset($medium_url))
			update_option("medium_url", $medium_url);
		if (isset($linktonwltr))
			update_option("linktonwltr", $linktonwltr);
		if (isset($enablecontactslider))
			update_option("enablecontactslider", $enablecontactslider);
		if (isset($contactsliderpage))
			update_option("contactsliderpage", $contactsliderpage);
		if (isset($enablecrazyegg))
			update_option("enablecrazyegg", $enablecrazyegg);
		else {
			if (get_option('enablecrazyegg'))
				delete_option('enablecrazyegg');
		}

		if (isset($crazyeggaddress))
			update_option("crazyeggaddress", $crazyeggaddress);
		else {
			if (get_option('crazyeggaddress'))
				delete_option('crazyeggaddress');	
		}
	}

	$google_analytics_id = get_option("google_analytics_id");
	$twitter_url = get_option("twitter_url");
	$facebook_url = get_option("facebook_url");
	$yotube_url = get_option("yotube_url");
	$medium_url = get_option("medium_url");
	$linktonwltr = get_option("linktonwltr");
	$enablecontactslider = get_option("enablecontactslider");
	$contactsliderpage = get_option("contactsliderpage");
	$enablecrazyegg = get_option("enablecrazyegg");
	$crazyeggaddress = get_option("crazyeggaddress");
	$cdisabled = "";

	if (!$enablecrazyegg)
		$cdisabled = "disabled";

	//get all pages with contact slider template
	$contact_pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-templates/contact-slider.php'
	));

	$options = "";

	foreach($contact_pages as $page){
		$selected="";
		if ($contactsliderpage==$page->ID) {
			$selected = " selected";
		}
		$options .= "<option value='".$page->ID."'".$selected.">".$page->post_title."</option>";
	}


	$return = '';
	$return .=  '<div class="wrap">
					<h2>Theme Settings</h2>';

	if ($notice){
		$return .= '<div class="notice notice-warning is-dismissible"><p>'.$notice.'</p></div>';
	}

	$return .= '<form id="oet_theme_settings_form" method="post">';
		$return .= '<div class="oer_sclmda_wrpr">
						<div class="oer_sclmda_sub_wrapper">
				      		<div class="oer_sclmda_txt"><strong>Google Analytics ID</strong></div>
				      		<div class="oer_sclmda_fld"><input type="text" name="google_analytics_id" value="'. $google_analytics_id.'" /></div>
					</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt"><strong>Twitter</strong></div>
						      <div class="oer_sclmda_fld"><input type="text" name="twitter_url" value="'. $twitter_url.'" /></div>
					</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt"><strong>Facebook</strong></div>
						      <div class="oer_sclmda_fld"><input type="text" name="facebook_url" value="'. $facebook_url.'" /></div>
					</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt"><strong>Youtube</strong></div>
						      <div class="oer_sclmda_fld"><input type="text" name="yotube_url" value="'. $yotube_url.'" /></div>
					</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt"><strong>Medium URL</strong></div>
						      <div class="oer_sclmda_fld"><input type="text" name="medium_url" value="'. $medium_url.'" /></div>
					</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt"><strong>Link To Newsletter</strong></div>
						      <div class="oer_sclmda_fld"><input type="text" name="linktonwltr" value="'. $linktonwltr.'" /></div>
					</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt"><strong>Enable Contact Slider?</strong></div>
						      <div class="oer_sclmda_fld"><input type="checkbox" id="enablecontactslider" name="enablecontactslider" value="'.(($enablecontactslider)?$enablecontactslider:true).'" '.(($enablecontactslider==1)?"checked='checked'":"").' /><select name="contactsliderpage" id="contactsliderpage" disabled="disabled">'.$options.'</select></div>
					</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt"><strong>Enable Crazy Egg tracking script</strong></div>
						      <div class="oer_sclmda_fld checkinput"><input type="checkbox" id="enablecrazyegg" name="enablecrazyegg" value="1" '.checked("1",$enablecrazyegg,false).' /><input type="text" name="crazyeggaddress" id="crazyeggaddress" value="'. $crazyeggaddress.'" '.$cdisabled.'/></div>
					</div>
					<div class="settings-error oet-settings-error hidden">Crazy Egg Script Address cannot be empty!</div>
					<div class="oer_sclmda_sub_wrapper">
						      <div class="oer_sclmda_txt">(v'.OET_THEME_VERSION.')</div>
						      <div class="oer_sclmda_fld"><input type="submit" name="save_social" value="Save Settings" /></div>
					</div>
					<div id="oer_verbose_block"></div>
		      </div>';
	$return .= '</form>';
	$return .= '</div>';

	echo $return;
}
?>
