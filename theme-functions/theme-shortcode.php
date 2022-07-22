<?php
//include_once wp_normalize_path( get_stylesheet_directory() . '/classes/oet_medium.php' );
/**
 * Disruptive Content
 * Shortcode Example : [disruptive_content title='' main_text='' button_text='' button_color='' button_url='']
 */
add_shortcode("disruptive_content", "disruptive_content_fun" );
function disruptive_content_fun($attr, $content = null)
{
	if (is_array($attr)) {
 		if ( is_admin() ) {
 			$_arr = getShortcodeAttr($attr);
	 		foreach($_arr as $key => $value) $$key = $value;
	 	}
 		extract($attr);
 	}
	/**--if ( is_admin() ) {
		$_arr = getShortcodeAttr($attr);
		foreach($_arr as $key => $value) $$key = $value;
	}else{
		extract($attr);
	}--**/

	$title=(!isset($title))?'':$title;
	$button_color=(!isset($button_color))?'':$button_color;
	$button_url=(!isset($button_url))?'':$button_url;
	$button_text=(!isset($button_text))?'':$button_text;
	$main_text=(!isset($main_text))?'':$main_text;
	
	
	if (strpos($button_color,"#")===false)
		$button_color = "#".$button_color;

	$return = '';
    $return .= '<div class="disruptive_content row bg_img_of_icns" id="lnk_btn_cntnr_center">';
        $return .= '<div class="col-md-8 col-sm-8 col-xs-8" >';
            $return .= '<h3>'. $title .'</h3>';
            $return .= '<p>';
				//$main_text = apply_filters('the_content', $main_text);
            	$return .= $main_text;
            $return .= '</p>';
        $return .= '</div>';

				$return .= '<div class="link_dwnlds_wrapper" >';
				$return .= '<div class="link_dwnlds"><div><a href="'. $button_url .'" class="btn_dwnld" style="background-color:'. $button_color.'" onclick="ga(\'send\', \'event\', \'download\', \''.$button_url.'\');" target="_blank">'. $button_text .'</a></div></div>';
        $return .= '</div>';

				//$return .= '<div class="col-md-4 col-sm-4 col-xs-4 text-right">';
				//$return .= '<div class="link_dwnlds"><div><a href="'. $button_url .'" class="btn_dwnld" style="background-color:'. $button_color.'" onclick="ga(\'send\', \'event\', \'download\', \''.$button_url.'\');" target="_blank">'. $button_text .'</a></div></div>';
        //$return .= '</div>';
    $return .= '</div>';

	return $return;
}

/**
 * Accordion Group & Accordion
 * Shortcode Example : [oet_accordion_group][oet_accordion title="" accordion_series="one" expanded=""] your content goes here [/oet_accordion][/oet_accordion_group]
 */
add_shortcode('oet_accordion_group', 'oet_accordion_group_func');
function oet_accordion_group_func($atts, $content = null)
{
	$accordion_id = "accordion";

	if (!empty($atts)) {
		extract($atts);
		if ($id)
			$accordion_id = $id;
	}

	$return = '';
	$return .= '<div class="panel-group" id="'.$accordion_id.'" role="tablist" aria-multiselectable="true">';
			$content = str_replace( "<p>","", $content );
			$content = str_replace( "</p>","", $content );
			$return .= do_shortcode($content);
	$return .= '</div>';
	return $return;
}

add_shortcode('oet_accordion', 'oet_accordion_func');
function oet_accordion_func($atts, $content = null)
{
$group_id = "accordion";

	if ( is_admin() ) {
		$_arr = getShortcodeAttr($atts);
		foreach($_arr as $key => $value) $$key = $value;
	}else{
		extract($atts);
	}
  $return = '';

  if(isset($accordion_series) && !empty($accordion_series))
  {
		$return .= '<div '.$accordion_series.' class="panel panel-default">';

		$return .= '<div class="panel-heading" role="tab" id="heading'. $group_id. $accordion_series .'">';
		  $return .= '<h5 class="panel-title">';

			  if(isset($expanded) && !empty($expanded) && strtolower($expanded) == "true")
			  {
				  $class = "";
				  $uptcls = "in";
			  }
			  else
			  {
				  $class = "collapsed";
				  $uptcls = '';
			  }

			  $return .= '<a class="'.$class.'" role="button" data-toggle="collapse" data-parent="#'.$group_id.'" data-target="#collapse'. $group_id. $accordion_series .'" aria-expanded="false" aria-controls="collapse'. $group_id. $accordion_series .'">';
			  $return .= $title;
			$return .= '</a>';
		 $return .= ' </h5>';
		$return .= '</div>';

		$return .= '<div id="collapse'. $group_id. $accordion_series .'" class="panel-collapse collapse '.$uptcls.'" role="tabpanel" aria-labelledby="heading'. $accordion_series .'">';
		  $return .= '<div class="panel-body">';
			//$content = apply_filters('the_content', $content);
			$return .= $content;
		  $return .= '</div>';
		$return .= '</div>';

		$return .= '</div>';

		return $return;
  }
}

function getShortcodeAttr($atts){
	$_cnt = -1;
	$_arr = array(); $_key = ''; $_val = '';
	$_total = count($atts)-1;
	foreach ($atts as $att){
		if (strpos($att, '=') !== false) {
			if($_key != ''){ $_arr[$_key]=$_val;}
			$_key = str_replace(array('\'', '"'), '', explode('=',$att)[0]);
    	$_val = str_replace(array('\'', '"'), '', explode('=',$att)[1]);
		}else{
			$_val .= ' '.str_replace(array('\'', '"'), '', $att);
		}
		$_cnt++;
		if($_cnt == $_total){$_arr[$_key]=$_val;}
	}
	return $_arr;
}
/**
 * Pull Quote
 * Shortcode Example : [pull_quote speaker="" additional_info=""]your content goes here[/pull_quote]
 */
add_shortcode('pull_quote', 'pull_quotethemefn');
function pull_quotethemefn($atts, $content = null)
{
	if (is_array($atts)) {
 		if ( is_admin() ) {
 			$_arr = getShortcodeAttr($atts);
	 		foreach($_arr as $key => $value) $$key = $value;
	 	}
 		extract($atts);
 	}
	/**--if ( is_admin() ) {
		$_arr = getShortcodeAttr($atts);
		foreach($_arr as $key => $value) $$key = $value;
	}else{
		$speaker = $atts['speaker'];
		$additional_info = $atts['additional_info'];
		extract($atts);
	}--**/


	$return = '';
	$return .= '<div class="col-md-1 col-sm-1 col-xs-1 oet_pull_quote_icon">';
		$return .= '<img src="'. get_stylesheet_directory_uri() .'/images/dbl_cod_img.png" alt="Quote"/>';
	$return .= '</div>';

	$return .= '<div class="col-md-11 col-sm-11 col-xs-11 oet_pull_quote_text">';
	if(isset($content) && !empty($content))
	{
		$return .= '<blockquote class="blog_mtr"><span></span>';
			//$content = apply_filters('the_content', $content);
			$return .= $content;
		$return .= '</blockquote>';
	}
	if(isset($speaker) && !empty($speaker))
	{
		$return .= '<blockquote class="blog_athr">';
			$return .= $speaker;
		$return .= '</blockquote>';
	}
	if(isset($additional_info) && !empty($additional_info))
	{
		$return .= ' <p class="blog_date">';
			$return .= $additional_info;
		$return .= '</p>';
	}
	$return .= '</div>';
	return $return;
}

/**
 * Featured Item
 * Shortcode Example : [featured_item heading='' image='' image_alt='' title='' date='' button='' button_text='' url="" sharing='']your content goes here[/featured_item]
 */
add_shortcode("featured_item","featured_item_func");
function featured_item_func($attr, $content = null)
{
	if ( is_admin() ) {
		$_arr = getShortcodeAttr($attr);
		foreach($_arr as $key => $value) $$key = $value;
	}else{
		extract($attr);
	}
	$return = '';
	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 rght_sid_mtr oese_featured_item">';
	if(isset($heading) && !empty($heading))
	{
    	$return .= '<h3>'. $heading .'</h3>';
	}
	$image_alt = (isset($image_alt) && !empty($image_alt))? $image_alt: '';
	if(isset($image) && !empty($image))
	{
		if(isset($url) && !empty($url))
		{
			$return .= '<a href="'. $url.'" title="'. $title.'"><img class="featured_item_image" src="'. $image .'" alt="'.$image_alt.'" /></a>';
		}
		else
		{
    		$return .= '<img class="featured_item_image" src="'. $image .'" alt="'.$image_alt.'"/>';
		}
	}
	if(isset($title) && !empty($title))
	{
    	if(isset($url) && !empty($url))
		{
			$return .= '<h4 class="hdng_mtr"><a href="'. $url.'">'. $title .'</a></h4>';
		}
		else
		{
    		$return .= '<h4 class="hdng_mtr">'. $title .'</h4>';
		}
	}
	if(isset($date) && !empty($date))
	{
    	$return .= '<p class="date"><b>'. $date .'</b></p>';
	}
	if(isset($content) && !empty($content))
	{
		//$description = apply_filters('the_content', $description);
    	$return .= '<p class="rght_mtr">'. $content .'</p>';
	}
	if(isset($url) && !empty($url) && strtolower($button) == 'show')
	{
		$return .= '<div class="home_dwnld_btn"><a class="btn_dwnld" style="background-color:#E57200;padding:5px 10px;width:auto;margin:0;" href="'.$url.'">';

		if(isset($button_text) && !empty($button_text))
		{
			$return .= $button_text.'</a></div>';
		}
		else
		{
			$return .= 'Download</a></div>';
		}
	}
	if(isset($sharing) && strtolower($sharing) == 'show')
	{
		$return .= '<div class="col-md-7 col-sm-7 col-xs-7 rght_sid_socl_icn">';
			$return .= do_shortcode("[ssba]");
		$return .= '</div>';
	}
    $return .= '</div>';

    $return = trim($return);

	return $return;
}

/**
 * Featured Video
 * Shortcode Example : [featured_video heading='title' videoid='GBT4f146h9U' description='description' height='300']
 */
add_shortcode("featured_video","feature_video_func");
function feature_video_func($attr, $content = null){
	static $count = 0;
	$count++;

	//if ($count==1){
	//	add_action( 'wp_enqueue_scripts', 'insert_ytapiurl_script' );
	//}
	if (is_array($attr)){
		if ( is_admin() ) {
			$_arr = getShortcodeAttr($attr);
			foreach($_arr as $key => $value) $$key = $value;
		}	
		extract($attr);
	}
	
	if(empty($height)){$height = 405;}
	$apiurl = get_stylesheet_directory_uri()."/js/ytplayerapi.js";
	$origin = get_site_url();
	$id = "ytvideo".$count;
	$videoid = (isset($videoid) && !empty($videoid))? $videoid: '';
	$return = ''; $iframe_title = '';
	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 rght_sid_mtr lft_sid_mtr">';
		if(isset($heading) && !empty($heading)){
			$iframe_title .= ": ".$heading;
			$return .= '<h3>'. $heading .'</h3>';
		}
		$return .= '<div class="col-md-12 col-sm-12 col-xs-12 vdo_bg">';	
			$return .= oet_generate_modal_video($videoid, $id, $iframe_title, $origin, $count, $height, $apiurl);
			if(isset($description) && !empty($description)){
				$return .= '<p>'. $description .'</p>';
			}
		$return .= '</div>';
	$return .= '</div>';
	
	$return = trim($return);

	return $return;
}

function oet_generate_modal_video($vidid, $Id, $iframe_title, $origin, $count, $height, $apiurl){
    $ret = ''; $imagesrc = '';
    $imagesrc = 'https://img.youtube.com/vi/'.$vidid.'/mqdefault.jpg';  
  
    $ret .= '<a href="#" class="oet-video-link" data-toggle="modal" data-tgt="#oet-featured-video-shrtcd-overlay-'.$count.'" cnt="'.$count.'">';
			$ret .= '<img src="'.$imagesrc.'" alt="Story Video"/>';
			$ret .= '<div class="stry-video-avatar-table">';
	    	$ret .= '<div class="stry-video-avatar-cell">';
					$ret .= '<span class="stry-youtube-play"></span>';
	    	$ret .= '</div>';
			$ret .= '</div>';
    $ret .= '</a>';
  
    $ret .= '<div class="modal fade oet-featured-video-shrtcd-overlay" id="oet-featured-video-shrtcd-overlay-'.$count.'" apiurl="'.$apiurl.'" cnt="'.$count.'" role="dialog" tabindex="-1">';
			$ret .= '<div class="stry-video-modal modal-dialog modal-lg">';
	    	$ret .= '<div class="stry-video-table">';
					$ret .= '<div class="stry-video-cell">';
		    		$ret .= '<div class="stry-video-content">';
		    		$ret .= '<div class="video-container">';
							$ret .= '<div class="oet-featured-video-shrtcd-ytvideo" id="'.$Id.'" cnt="'.$count.'" frametitle="'.$iframe_title.'" vidid="'.$vidid.'" hght="'.$height.'" orgn="'.$origin.'"></div>';						
					$ret .= '</div>';
		    		$ret .= '</div>';
					$ret .= '</div>';
	      $ret .= '</div>';
		  $ret .= '</div>';
			$ret .= '<a href="javascript:void(0);" class="stry-video-close" hst="1"><span class="dashicons dashicons-no-alt"></span></a>';
    $ret .= '</div>';
    
    return $ret;
}


/**
 * Featured Video (Old Outdated)
 * Shortcode Example : [featured_video heading="" src="" description="" height=""]
 */
function feature_video_func_old($attr, $content = null)
{
	static $count = 0;
	$count++;
	
	global $post;
	$show_modal = true;

	if ( is_admin() ) {
		$_arr = getShortcodeAttr($attr);
		foreach($_arr as $key => $value) $$key = $value;
	}else{
		extract($attr);
	}

	$return = '';
	
	if (isset($modal) && $modal=="false")
		$show_modal = false;
		
	if(!isset($id) || empty($id))
		$id = "ytvideo".$count;

	$origin = get_site_url();
	if(isset($videoid) && !empty($videoid))
		$src = "https://www.youtube.com/embed/".$videoid."?enablejsapi=1&#038;origin=".$origin;
	
	$yt_host = '//www.youtube.com';
	$iframe_src = get_stylesheet_directory_uri()."/js/iframe_api.js";
	$tracking_script = "<script type='text/javascript'>\n".
	$tracking_script .= " 	// This code loads the IFrame Player API code asynchronously \n".
				"var tag = document.createElement('script'); \n".
				"tag.src = \"$iframe_src\"; \n ".
				"var player; \n".
				"var firstScriptTag = document.getElementsByTagName('script')[0]; \n".
				"firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); \n".
				"window.YTConfig = { host: 'https://www.youtube.com' } \n".
				"	// This code is called by the YouTube API to create the player object \n".
				"function onYouTubeIframeAPIReady(event) { \n".
				"	setTimeout(function(){  \n".
				"		console.log('YT loading'); \n".
				"	}, 1000);  \n".
				"	loadPlayer(); \n".
				"}\n".
				"	var pauseFlag = false; \n".
				"	var gaSent = false; \n".
				"function onPlayerError(event) { \n".
				"	if (event.data) { \n".
				"		if (gaSent === false) { \n".
				"			ga('send',  'event', 'Featured Video: " . esc_sql($post->post_title) . "', 'Failed', '". $video_id."'  ); \n".
				"			gaSent = true; \n".
				"		} \n".
				" 	} \n".
				"} \n".
				"function loadPlayer() { \n".
				"	player = new YT.Player('".$id."', { \n".
				"	videoId: '".$videoid."', \n".
				"	playerVars: { \n".
				"		'autoplay': 0, \n".
				"		'controls': 1, \n".
				"		'enablejsapi': 1, \n".
				"		'rel' : 0, \n".
				"		'origin' : '".$origin."', \n".
				"		'host' : '".$yt_host."' \n".
				"	}, \n".
				"	events: { \n".
				"		'onError': onPlayerError, \n".
				"		'onReady': onPlayerReady, \n".
				"		'onStateChange': onPlayerStateChange \n".
				"		} \n".
				"	}); \n".
				"} \n".
				"function onPlayerReady(event) { \n".
				"	// do nothing, no tracking needed \n".
				"} \n".
				"function onPlayerStateChange(event) { \n".
				"	var url = event.target.getVideoUrl(); \n".
				"	var match = url.match(/[?&]v=([^&]+)/); \n".
				"	if( match != null) \n".
				"	{ \n ".
				"		var videoId = match[1]; \n".
				"	} \n".
				"	videoId = String(videoId); \n".
				"	// track when user clicks to Play \n".
				"	if (event.data == YT.PlayerState.PLAYING) { \n".
				"		console.log('playing'); \n".
				"		ga('send','event','Featured Video: ".esc_sql($post->post_title)."','Play', videoId);\n".
				"		pauseFlag = true; \n".
				"	}\n".
				"	// track when user clicks to Pause \n".
				"	if (event.data == YT.PlayerState.PAUSED && pauseFlag) { \n".
				"		ga('send','event','Featured Video: ".esc_sql($post->post_title)."', 'Pause', videoId); \n".
				"		pauseFlag = false; \n ".
				"	} \n".
				"	// track when video ends \n".
				"	if (event.data == YT.PlayerState.ENDED) { \n".
				"		ga('send', 'event','Featured Video: ".esc_sql($post->post_title)."', 'Finished', videoId); \n".
				"	}\n".
				"} \n";
	
	$tracking_script .= "</script>";

	$iframe_title = "Video Embed";

	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 rght_sid_mtr lft_sid_mtr">';
	if(isset($heading) && !empty($heading))
	{
		$iframe_title .= ": ".$heading;
		$return .= '<h4>'. $heading .'</h4>';
	}

	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 vdo_bg">';
		
		if ($show_modal){
			$return .= oet_modal_video_link($videoid, $id);	
		} else {
			if(isset($src) && !empty($src))
			{
				if(empty($height))
				{
					$height = 300;
				}
	
				$return .= '<iframe id="'.$id.'" title="'.$iframe_title.'" width="540" height="'. $height.'" src="'. $src .'" allowfullscreen></iframe>';
			}
		}
		if(isset($description) && !empty($description))
		{
			//$description = apply_filters('the_content', $description);
			$return .= '<p>'. $description .'</p>';
		}
		$return .= '</div>';
	$return .= '</div>';
	add_action("wp_footer", function() use( $tracking_script ){
		echo $tracking_script;
	}, 20);
	return $return;
}

/**
 * Home Right Column
 * Shortcode Example : [home_right_column] your content goes here [/home_right_column]
 */
add_shortcode('home_right_column', 'home_right_column_func');
function home_right_column_func($atts, $content = null)
{
	if (is_array($atts)){
		if ( is_admin() ) {
			$_arr = getShortcodeAttr($atts);
			foreach($_arr as $key => $value) $$key = $value;
		}else{
			extract($atts);
		}
	}

	$return = '';
	$return .= '<div class="col-md-6 col-sm-12 col-xs-12 rght_sid_mtr">';
			$return .= do_shortcode($content);
	$return .= '</div>';
	return $return;
}

/**
 * Home Left Column
 * Shortcode Example : [home_left_column divider="yes/no"] your content goes here [/home_left_column]
 */
add_shortcode('home_left_column', 'home_left_column_func');
function home_left_column_func($atts, $content = null)
{
	if (is_array($atts)){
		if ( is_admin() ) {
			$_arr = getShortcodeAttr($atts);
			foreach($_arr as $key => $value) $$key = $value;
		}else{
			extract($atts);
		}
	}

	$return = '';
	$return .= '<div class="col-md-6 col-sm-12 col-xs-12 lft_sid_mtr">';
			$return .= do_shortcode($content);
	if( (isset($divider) && ($divider == 'yes')) || !(isset($divider)) )
	{
		$return .= '<div class="sprtn_brdr"></div>';
	}
	$return .= '</div>';
	return $return;
}

/**
 * Featured Area
 * Shortcode Example : [oet_featured_area heading="" image="" title=""]your content goes here[/oet_featured_area]
 */
add_shortcode('oet_featured_area', 'oet_featured_area_descrptn');
function oet_featured_area_descrptn($attr, $content = null)
{
	if (is_array($attr)){
		if ( is_admin() ) {
			$_arr = getShortcodeAttr($attr);
			foreach($_arr as $key => $value) $$key = $value;
		}
		extract($attr);
	}

	$return = '';
	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 lft_sid_mtr">';
			$return .= '<div class="col-md-12 lft_sid_mtr">';

			if(isset($heading) && !empty($heading))
			{
				$return .= '<h3>'. $heading .'</h3>';
			}
			if(isset($image) && !empty($image))
			{
				$return .= '<img class="featured_area_image" src="'. $image .'"  alt="Featured Image" />';
			}
			if(isset($title) && !empty($title))
			{
				$return .= '<h4 class="hdng_mtr">'. $title .'</h4>';
			}
			if(isset($content) && !empty($content))
			{
				//$description = apply_filters('the_content', $content);
				$return .= '<p>'. $content .'</p>';
			}

			$return .= '</div>';
	$return .= '</div>';
	return $return;
}

/**
 * Share Icon
 * Shortcode Example : [share_the_toolkit]
 */
add_shortcode("share_the_toolkit","share_the_toolkit_func");
function share_the_toolkit_func($atts, $content = null)
{
	$return = '';
	$return .= '<div class="pblctn_right_sid_mtr">';
	$return .= '<p class="pblctn_scl_icn_hedng"> Share the Toolkit </p>';
        $return .= '<p class="pblctn_scl_icns">';
            $return .= '<a href="'. facebook_url.'"><span class="socl_icns fa-stack"><i class="fa fa-facebook fa-stack-2x"></i></span></a>';
            $return .= '<a href="'. google_url.'"><span class="socl_icns fa-stack"><i class="fa fa-google-plus fa-stack-2x"></i></span></a>';
            $return .= '<a href="'. twitter_url.'"><span class="socl_icns fa-stack"><i class="fa fa-twitter fa-stack-2x"></i></span></a>';
            $return .= '<a href="'. linktonwltr.'"><span class="socl_icns fa-stack"><i class="fa fa-envelope fa-stack-2x"></i></span></a>';
       $return .= ' </p>';
	$return .= '</div>';
	return $return;
}
/**
 * Recommended Resource
 * Shortcode Example : [recommended_resources media_type1='' src1='' text1='' link1='' media_type2='' src2='' text2='' link2='' media_type3='' src3='' text3=''  link3='']
 */
add_shortcode("recommended_resources","recommended_resources_func");
function recommended_resources_func($attr, $content = null)
{
	if (is_array($attr)){
		if ( is_admin() ) {
			$_arr = getShortcodeAttr($attr);
			foreach($_arr as $key => $value) $$key = $value;
		}
		extract($attr);	
	}
	
	$return = '';
	$regex = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/";
	if(isset($heading) && !empty($heading))
	{
		$return .= '<h3 class="pblctn_scl_icn_hedng">'. $heading.'</h3>';
	}

	if(isset($text1) && !empty($text1) && isset($src1) && !empty($src1) && isset($text2) && !empty($text2) && isset($src2) && !empty($src2) && isset($text3) && !empty($text3) && isset($src3) && !empty($src3))
	{
        $return .= '<div class="col-md-12 col-sm-12 col-xs-12 padding_left padding_right tlkt_stp_vdo_cntnr">';
		if(isset($media_type1) && !empty($media_type1) && strtolower($media_type1) == 'video')
		{
			if(isset($text1) && !empty($text1) && isset($src1) && !empty($src1))
			{
				preg_match($regex, $src1, $matches);
				$src = "//www.youtube.com/embed/".$matches[1];
				$video_title = "Video Embed: ".$heading;
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<iframe title="'.$video_title.'" width="274" height="160" src="'. $src .'" allowfullscreen></iframe>';
					$return .= '<p>'. $text1 .'</p>';
				$return .= '</div>';
			}
		}
		else
		{
			if(isset($text1) && !empty($text1) && isset($src1) && !empty($src1))
			{
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<a href="'.$link1.'" target="_blank"><img width="274" height="160" src="'. $src1 .'" alt="Resource" /></a>';
					$return .= '<p>'. $text1 .'</p>';
				$return .= '</div>';
			}
		}

		if(isset($media_type2) && !empty($media_type2) && strtolower($media_type2) == 'video')
		{
			if(isset($text2) && !empty($text2) && isset($src2) && !empty($src2))
			{
				preg_match($regex, $src2, $matches);
				$src = "//www.youtube.com/embed/".$matches[1];
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<iframe title="Video Embed" width="274" height="160" src="'. $src .'" allowfullscreen></iframe>';
					$return .= '<p>'. $text2 .'</p>';
				$return .= '</div>';
			}
		}
		else
		{
			if(isset($text2) && !empty($text2) && isset($src2) && !empty($src2))
			{
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<a href="'.$link2.'" target="_blank"><img width="274" height="160" src="'. $src2 .'" alt="Resource"/></a>';
					$return .= '<p>'. $text2 .'</p>';
				$return .= '</div>';
			}
		}

		if(isset($media_type3) && !empty($media_type3) && strtolower($media_type3) == 'video')
		{
			if(isset($text3) && !empty($text3) && isset($src3) && !empty($src3))
			{
				preg_match($regex, $src3, $matches);
				$src = "//www.youtube.com/embed/".$matches[1];
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<iframe title="Video Embed" width="274" height="160" src="'. $src .'" allowfullscreen></iframe>';
					$return .= '<p>'. $text3 .'</p>';
				$return .= '</div>';
			}
		}
		else
		{
			if(isset($text3) && !empty($text3) && isset($src3) && !empty($src3))
			{
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<a href="'.$link3.'" target="_blank"><img width="274" height="160" src="'. $src3 .'" alt="Resource"/></a>';
					$return .= '<p>'. $text3 .'</p>';
				$return .= '</div>';
			}

		}
		$return .= '</div>';
	}
	else
	{
		$return .= '<div class="col-md-12 col-sm-12 col-xs-12 padding_left padding_right tlkt_stp_vdo_cntnr">';

		if(isset($media_type1) && !empty($media_type1) && strtolower($media_type1) == 'video')
		{
			if(isset($text1) && !empty($text1) && isset($src1) && !empty($src1))
			{
				preg_match($regex, $src1, $matches);
				$src = "//www.youtube.com/embed/".$matches[1];
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<iframe title="Video Embed" width="274" height="160" src="'. $src .'" allowfullscreen></iframe>';
					$return .= '<p>'. $text1 .'</p>';
				$return .= '</div>';
			}
		}
		else
		{
			if(isset($text1) && !empty($text1) && isset($src1) && !empty($src1))
			{
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<a href="'.$link1.'" target="_blank"><img width="274" height="160" src="'. $src1 .'"  alt="Resource"/></a>';
					$return .= '<p>'. $text1 .'</p>';
				$return .= '</div>';
			}
		}

		if(isset($media_type2) && !empty($media_type2) && strtolower($media_type2) == 'video')
		{
			if(isset($text2) && !empty($text2) && isset($src2) && !empty($src2))
			{
				preg_match($regex, $src2, $matches);
				$src = "//www.youtube.com/embed/".$matches[1];
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<iframe title="Video Embed" width="274" height="160" src="'. $src .'" allowfullscreen></iframe>';
					$return .= '<p>'. $text2 .'</p>';
				$return .= '</div>';
			}
		}
		else
		{
			if(isset($text2) && !empty($text2) && isset($src2) && !empty($src2))
			{
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<a href="'.$link2.'" target="_blank"><img width="274" height="160" src="'. $src2 .'" alt="Resource"/></a>';
					$return .= '<p>'. $text2 .'</p>';
				$return .= '</div>';
			}
		}

		if(isset($media_type3) && !empty($media_type3) && strtolower($media_type3) == 'video')
		{
			if(isset($text3) && !empty($text3) && isset($src3) && !empty($src3))
			{
				preg_match($regex, $src3, $matches);
				$src = "//www.youtube.com/embed/".$matches[1];
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<iframe title="Video Embed" width="274" height="160" src="'. $src .'" allowfullscreen></iframe>';
					$return .= '<p>'. $text3 .'</p>';
				$return .= '</div>';
			}
		}
		else
		{
			if(isset($text3) && !empty($text3) && isset($src3) && !empty($src3))
			{
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<a href="'.$link3.'" target="_blank"><img width="274" height="160" src="'. $src3 .'" alt="Resource"/></a>';
					$return .= '<p>'. $text3 .'</p>';
				$return .= '</div>';
			}

		}
        $return .= '</div>';
	}

	return $return;
}

/**
 * Featured Content Box
 * Shortcode Example : [featured_content_box title='' top_icon='' align='']your content goes here[/featured_content_box]
 */
 add_shortcode("featured_content_box", "featured_content_box_func");

 function featured_content_box_func($attr, $content = null){
 	if (is_array($attr)) {
 		if ( is_admin() ) {
 			$_arr = getShortcodeAttr($attr);
	 		foreach($_arr as $key => $value) $$key = $value;
	 	}
 		extract($attr);
 	}
	 $title=(!isset($title))?'':$title;
	 $align=(!isset($align))?'':$align;
	 $return = '';
		$return .= '<div class="featured_content_box pblctn_right_sid_mtr">';
		$return .= '<div class="col-md-12 col-sm-6 col-xs-6">';
        $return .= '<div class="pblctn_box">';

		if(isset($top_icon) && !empty($top_icon))
		{
			$return .= '<span class="socl_icns fa-stack"><i class="fa fa-'.$top_icon.' "></i></span>';
		}
		else
		{
			$return .= '<span class="socl_icns fa-stack"><i class="fa fa-star "></i></span>';
		}

		$return .= '</div>';
						$return .= '<div class="cntnbx_cntnr" style="text-align:'. $align.'">';
							$return .= '<p class="rght_sid_wdgt_hedng">'. $title .'</p>'.$content;
						$return .= '</div>';
						
        $return .= '</div>';
		$return .= '</div>';

		return $return;
 }

 /**
 * Button
 * Shortcode Example : [btn button_color ='' text='' text_color='#ffffff']
 */
 add_shortcode("oet_button", "button_func");
 function button_func($attr, $content = null) {
 	// Default Hover BG and Text Color
 	$hColor = "";
 	$hTextColor = "";
 	
 	if (is_array($attr)) {
 		if ( is_admin() ) {
 			$_arr = getShortcodeAttr($attr);
	 		foreach($_arr as $key => $value) $$key = $value;
	 	}
 		extract($attr);
 	}
 	
	//Checks if content is provided otherwise display the text attribute as button text
	$buttonText = (isset($text) && !empty($text)) ? $text : "Button";
	if (!empty($content)) {
		$buttonText = $content;
	}

	$btnStyle = '';

	//Button Color
	if (isset($button_color) && !empty($button_color)) {
		if (strpos($button_color,"#")===false)
			$button_color = "#".$button_color;
		$btnStyle .= "background-color:".$button_color.";";
	}

	//Button Text color
	if (isset($text_color) && !empty($text_color)) {
		if (strpos($text_color,"#")===false)
			$text_color = "#".$text_color;
		$btnStyle .= "color:".$text_color.";";
	}

	//Button Font Face
	if (isset($font_face) && !empty($font_face)) {
		$btnStyle .= "font-family:".$font_face.";";
	}

	//Button Font Size
	if (isset($font_size) && !empty($font_size)) {
		$btnStyle .= "font-size:".$font_size."px;";
	}

	//Button Font Weight
	if (isset($font_weight) && !empty($font_weight)) {
		$btnStyle .= "font-weight:".$font_weight.";";
	}

	if (isset($hovercolor) && !empty($hovercolor)){
		$hColor = $hovercolor;
	}

	if (isset($hovertextcolor) && !empty($hovertextcolor)){
		$hTextColor = $hovertextcolor;
	}

	//Button Code
	$buttonStart = "<span class='btn custom-button' style='".$btnStyle."' onmouseover='this.style.setProperty(\"color\",\"".$hTextColor."\",\"important\");this.style.setProperty(\"background-color\",\"".$hColor."\",\"important\");' onmouseout='this.style.color=\"".$text_color."\";this.style.backgroundColor=\"".$button_color."\"'>";
	$buttonEnd = "</span>";

	$return = $buttonStart.$buttonText.$buttonEnd;

	if (isset($url) && !empty($url)) {
		$urlStart = "<a href='".$url."' onfocus='this.querySelector(\".custom-button\").style.setProperty(\"color\",\"".$hTextColor."\",\"important\");this.querySelector(\".custom-button\").style.setProperty(\"background-color\",\"".$hColor."\",\"important\");' onblur='this.querySelector(\".custom-button\").style.color=\"".$text_color."\";this.querySelector(\".custom-button\").style.backgroundColor=\"".$button_color."\"'";
		if (isset($new_window) && ($new_window=="yes")) {
			$urlStart .= " onmousedown='ga(\"send\", \"event\",\"Outbound\",window.location.pathname,\"".$url."\",0);' target='_blank'";
		}
		$urlStart .= ">";
		$urlEnd = "</a>";
		$return = $urlStart.$return.$urlEnd;
	}

	return $return;
 }

 /**
 * Spacer
 * Shortcode Example : [spacer height='20']
 */
 add_shortcode("spacer", "spacer_func");
 function spacer_func($attribute) {

	if (is_array($attribute)){
		if ( is_admin() ) {
			$_arr = getShortcodeAttr($attribute);
			foreach($_arr as $key => $value) $$key = $value;
		}else{
			extract($attribute);
		}

	}

	if (isset($height) && !empty($height)) {
		$height = " height:".((strpos($height,"px")>0)?$height:$height."px");
	} else {
		$height = " height:12px;";
	}

	$return = '<div class="clearfix" style="clear:both;'. $height .'"></div>';

	return $return;

 }

 /**
 * Bootstrap Row
 * Shortcode Example : [row]
 */
 add_shortcode("row", "bootstrap_row_func");
 function bootstrap_row_func( $atts, $content = null ) {

    $atts = shortcode_atts( array(
      "xclass" => false,
      "data"   => false
	), $atts );

    $class  = 'row';
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

    $data_props = parse_data_attributes( $atts['data'] );

    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( $class ),
      ( $data_props ) ? ' ' . $data_props : '',
      do_shortcode( $content )
    );
  }

/**
* Bootstrap Column
* Shortcode Example : [column lg='12']
*/
add_shortcode("column", "bootstrap_column_func");
function bootstrap_column_func( $atts, $content = null ) {

$atts = shortcode_atts( array(
      "lg"          => false,
      "md"          => false,
      "sm"          => false,
      "xs"          => false,
      "offset_lg"   => false,
      "offset_md"   => false,
      "offset_sm"   => false,
      "offset_xs"   => false,
      "pull_lg"     => false,
      "pull_md"     => false,
      "pull_sm"     => false,
      "pull_xs"     => false,
      "push_lg"     => false,
      "push_md"     => false,
      "push_sm"     => false,
      "push_xs"     => false,
      "xclass"      => false,
      "data"        => false
	), $atts );

    $class  = '';
    $class .= ( $atts['lg'] )			                                ? ' col-lg-' . $atts['lg'] : '';
    $class .= ( $atts['md'] )                                           ? ' col-md-' . $atts['md'] : '';
    $class .= ( $atts['sm'] )                                           ? ' col-sm-' . $atts['sm'] : '';
    $class .= ( $atts['xs'] )                                           ? ' col-xs-' . $atts['xs'] : '';
    $class .= ( $atts['offset_lg'] || $atts['offset_lg'] === "0" )      ? ' col-lg-offset-' . $atts['offset_lg'] : '';
    $class .= ( $atts['offset_md'] || $atts['offset_md'] === "0" )      ? ' col-md-offset-' . $atts['offset_md'] : '';
    $class .= ( $atts['offset_sm'] || $atts['offset_sm'] === "0" )      ? ' col-sm-offset-' . $atts['offset_sm'] : '';
    $class .= ( $atts['offset_xs'] || $atts['offset_xs'] === "0" )      ? ' col-xs-offset-' . $atts['offset_xs'] : '';
    $class .= ( $atts['pull_lg']   || $atts['pull_lg'] === "0" )        ? ' col-lg-pull-' . $atts['pull_lg'] : '';
    $class .= ( $atts['pull_md']   || $atts['pull_md'] === "0" )        ? ' col-md-pull-' . $atts['pull_md'] : '';
    $class .= ( $atts['pull_sm']   || $atts['pull_sm'] === "0" )        ? ' col-sm-pull-' . $atts['pull_sm'] : '';
    $class .= ( $atts['pull_xs']   || $atts['pull_xs'] === "0" )        ? ' col-xs-pull-' . $atts['pull_xs'] : '';
    $class .= ( $atts['push_lg']   || $atts['push_lg'] === "0" )        ? ' col-lg-push-' . $atts['push_lg'] : '';
    $class .= ( $atts['push_md']   || $atts['push_md'] === "0" )        ? ' col-md-push-' . $atts['push_md'] : '';
    $class .= ( $atts['push_sm']   || $atts['push_sm'] === "0" )        ? ' col-sm-push-' . $atts['push_sm'] : '';
    $class .= ( $atts['push_xs']   || $atts['push_xs'] === "0" )        ? ' col-xs-push-' . $atts['push_xs'] : '';
    $class .= ( $atts['xclass'] )                                       ? ' ' . $atts['xclass'] : '';

    $data_props = parse_data_attributes( $atts['data'] );

    return sprintf(
      '<div class="%s"%s>%s</div>',
      esc_attr( $class ),
      ( $data_props ) ? ' ' . $data_props : '',
      do_shortcode( $content )
    );
}

/*--------------------------------------------------------------------------------------
*
* Parse data-attributes for shortcodes
*
*-------------------------------------------------------------------------------------*/
function parse_data_attributes( $data ) {

	$data_props = '';

	if( $data ) {
	  $data = explode( '|', $data );

	  foreach( $data as $d ) {
	    $d = explode( ',', $d );
	    $data_props .= sprintf( 'data-%s="%s" ', esc_html( $d[0] ), esc_attr( trim( $d[1] ) ) );
	  }
	}
	else {
	  $data_props = false;
	}
	return $data_props;
}

/**
 * Callout Box
 * Shortcode Example : [oet_callout type='check' width='12' color='00529f' alignment='left']
 */
 add_shortcode("oet_callout", "oet_callout_func");
 function oet_callout_func($attribute, $content = null) {
	if (is_array($attribute)){
		if ( is_admin() ) {
	 		$_arr = getShortcodeAttr($attribute);
	 		foreach($_arr as $key => $value) $$key = $value;
	 	}
	 	extract($attribute);;
	}
	$class_attrs = array("pull-out-box");
	$style =  "";

	//Set Type
	$attr_type = "checkmark";
	$type=(!isset($type))?'':$type;
	if ($type)
		$attr_type = $type;

	$class_attrs[] = $attr_type;

	//Set Color
	$color=(!isset($color))?false:$color;
	if ($color){

		$color_class = $color;

		if (strpos($color,"#")>=0){
			$color_class = substr($color,1,strlen($color)-1);
		}

		$class_attrs[] = "color-".$color_class;

		$style = '<style>';
		//Set Line Color
		$style .= '.color-'.$color_class.'{
				border-color:'.$color.' !important;
			  }';
		//Set Icon Background Color
		$style .= '.color-'.$color_class.':before {
				background-color:'.$color.' !important;
			}';
		$style .= '</style>';
	}

	//Set Width
	$attr_width = 12;
	$class_attrs[] = "col-xs-".$attr_width;
	$width=(!isset($width))?false:$width;
	if ($width) {
		$attr_width = "col-md-".$width;
		$class_attrs[] = $attr_width;
		$class_attrs[] = "col-sm-".$width;
	}

	//Set Alignment
	$alignment=(!isset($alignment))?false:$alignment;
	if ($alignment)
		$class_attrs[] = "pull-".$alignment;

	$attrs = implode(" ", $class_attrs);

	$return = '<div class="'.$attrs.'">'.$content.'</div>'.$style;

	return $return;

 }

 /**
 * Publication Intro
 * Shortcode Example : [publication_intro title='This is the title']Text goes here[/publication_intro]
 */
 add_shortcode("publication_intro", "publication_intro_func");
 function publication_intro_func($attribute, $content = null) {
	 if (is_array($attribute)){
 		if ( is_admin() ) {
 	 		$_arr = getShortcodeAttr($attribute);
 	 		foreach($_arr as $key => $value) $$key = $value;
 	 	}
 	 	extract($attribute);;
 	}
 	
	$title=(!isset($title))?'':$title;
	$return = '<div class="intro">
			<div class="intro-goal">
				<div class="title">'.$title.'</div>
				'.$content.'
		        </div>
		</div>';

	return $return;
 }

 /**
  * Single Post Medium Embed
  * Shortcode Example : [oet_medium url=""]
  **/
add_shortcode("oet_medium", "oet_medium_func");
function oet_medium_func($attribute, $content = null){
	$return = "";
	if (is_array($attribute)){
		 if ( is_admin() ) {
			 $_arr = getShortcodeAttr($attribute);
			 foreach($_arr as $key => $value) $$key = $value;
		}
		extract($attribute);
	}
	
	$description=(!isset($description))?'':$description;
	$title=(!isset($title))?'':$title;
	
	$background = "";
	$footer = "";
	$publication = "";
	$bg_color = "#000000";
	$textalignment = "";
	$heading = (!isset($heading)?"h3":$heading);
	
	if (isset($bgcolor) && !empty($bgcolor))
		$bg_color = "#".$bgcolor;
	
	if (isset($image) && $image!=="")
		$background = "background:".$bg_color." url(". $image .") no-repeat top left;";
	else
		$background = "background:".$bg_color." no-repeat top left;";

	if (isset($textalign))
		$textalignment = ' style="text-align:'.$textalign.';"';
	
	if ($url){
		if (isset($align) && $align =='center')
		    $align = 'margin:0 auto';
		else
		    $align = 'float:'.$align;

		if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
			$return = oet_medium_display_invalid_text($background);
		}

		/**--$footer = '<a href="%authorurl%" title="Go to the Office of Ed Tech Medium Blog" target="_blank" class="imglink" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \'%authorurl%\');"><img src="%authorlogo%" alt="%authorname%" width="30" height="30" /></a> <a href="%authorurl%" title="Go to the Office of Ed Tech Medium Blog" target="_blank" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \'%authorurl%\');">@%authorname%</a> '; --**/
		$footer = '<a href="%authorurl%" title="Go to the Office of Ed Tech Medium Blog" target="_blank" class="imglink" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \'%authorurl%\');"><img src="%authorlogo%" alt="" width="30" height="30" />@%authorname%</a> ';

		$default_author_url = "https://medium.com/@OfficeofEdTech";
		$default_author_name = "OfficeofEdTech";
		$default_author_logo = get_stylesheet_directory_uri()."/images/OET_logo_400px_square.png";
		
		if (isset($authorurl))
			$footer = str_replace("%authorurl%", $authorurl, $footer);
		else
			$footer = str_replace("%authorurl%", $default_author_url, $footer);

		if (isset($authorname))
			$footer = str_replace("%authorname%", $authorname, $footer);
		else
			$footer = str_replace("%authorname%", $default_author_name, $footer);

		if (isset($authorlogo))
			$footer = str_replace("%authorlogo%", $authorlogo, $footer);
		else
			$footer = str_replace("%authorlogo%", $default_author_logo, $footer);

		if (strlen($description)>175){
                    $description = substr($description,0,175);
                    $description = substr($description,0,strrpos($description," "))."...";
                }

		if (strlen($title)>80){
                    $title = substr($title,0,80);
                    $title = substr($title,0,strrpos($title," "))."...";
                }

		$return = '
		<div class="single-medium">
		    <div class="medium" style="'.$background.''.$align.'">
			<div class="medium-background">
			    <div class="medium-wrapper"'.$textalignment.'>';
		
		switch($heading){
			case "h1":
				$return .=	'<h1><a href="'.$url.'" target="_blank" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \''.$url.'\');">'.$title.'</a></h1>';
				break;
			case "h2":
				$return .=	'<h2><a href="'.$url.'" target="_blank" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \''.$url.'\');">'.$title.'</a></h2>';
				break;
			case "h3":
				$return .=	'<h3><a href="'.$url.'" target="_blank" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \''.$url.'\');">'.$title.'</a></h3>';
				break;
			case "h4":
				$return .=	'<h4><a href="'.$url.'" target="_blank" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \''.$url.'\');">'.$title.'</a></h4>';
				break;
			case "h5":
				$return .=	'<h5><a href="'.$url.'" target="_blank" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \''.$url.'\');">'.$title.'</a></h5>';
				break;
			case "h6":
				$return .=	'<h6><a href="'.$url.'" target="_blank" onclick="ga(\'send\', \'event\', \'Medium Blog Click\', \''.$url.'\');">'.$title.'</a></h6>';
				break;
		}

		$return .=	'<p>'.$description.'</p>
				<p class="mfooter">';
		$return .= $footer;
		$return .= '    </p>
			    </div>
			</div>
		    </div>
		</div>
		';
	} else {
		$return = oet_medium_display_invalid_text($background, "No Url specified");
	}

	return $return;
}



/**
 * OET Featured Card
 * Shortcode Example : [oet_featured_card title=\'\' button_text=\'Read More\' background_image=\'\' url=\'\']your content goes here[/oet_featured_card]
 **/
add_shortcode("oet_featured_card", "oet_featured_card_func");
function oet_featured_card_func($attribute, $content = null){
	$return = "";

	if (is_array($attribute)){
		if ( is_admin() ) {
			$_arr = getShortcodeAttr($attribute);
			foreach($_arr as $key => $value) $$key = $value;
		}
		extract($attribute);
	}

	$default_bg = get_stylesheet_directory_uri().'/images/oet_featured_card_bg.png';
	$bg = (!empty($background_image))? $background_image: $default_bg;
	$_cont_lg = (strlen($content)>260)? substr($content,0,260).' ...': $content;
	$_cont_md = (strlen($content)>180)? substr($content,0,180).' ...': $content;
	$_cont_sm = (strlen($content)>110)? substr($content,0,110).' ...': $content;
	$_cont_xs = (strlen($content)>50)? substr($content,0,50).' ...': $content;
	$_button_link = (!empty($button_link))? $button_link: '#';
	$return = '<div class="adminoverridewidth col-md-4 col-sm-6 col-xs-12">
							<div class="oet-featured-card" style="background-image: linear-gradient(rgba(44, 67, 116, 0.85), rgba(44, 67, 116, 0.85)), url('.$bg.');">
								<div class="oet-featured-card-content-wrapper">
		 						<h3 class="oet-featured-card-title">'.$title.'</h3>
								<div class="oet-featured-card-desc">'.$content.'</div>
			 					<a href="'.$_button_link.'" class="oet-featured-card-btn">'.$button_text.'&nbsp;→</a>
							</div>
	 					</div>
					</div>';


	return $return;
}

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );


/**
 * OET SOCIAL
 * Shortcode Example : [oet_social]
 **/
add_shortcode("oet_social", "oet_social_func");
function oet_social_func($attribute, $content = null){
	global $post;
	$url = rawurlencode(get_permalink($post->ID));
	$title = rawurlencode($post->post_title);
	$return = "";
	$return .= '<div class="ssba ssba-wrap">';
	 $return .= '<div>';
		 $return .= '<a class="ssba_facebook_share" href="https://www.facebook.com/sharer/sharer.php?u='.$url.'" onclick="openWindow(this.href,\'Share via Facebook\',450,250); return false;">';
			 $return .= '<img src="'.get_stylesheet_directory_uri().'/images/share_fb.png" title="Facebook" class="ssba ssba-img oet-social-img" alt="Share on Facebook">';
		 $return .= '</a>';
		 $return .= '<a class="ssba_twitter_share" href="https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url.'&amp;via=officeofedtech" onclick="openWindow(this.href,\'Share via Twitter\',450,250); return false;">';
			 $return .= '<img src="'.get_stylesheet_directory_uri().'/images/share_twr.png" title="Twitter" class="ssba ssba-img oet-social-img" alt="Tweet about this on Twitter">';
		 $return .= '</a>';
		 $return .= '<a class="ssba_email_share" href="mailto:?subject='.$title.'&amp;body='.$url.'" onclick="openWindow(this.href,\'Share via Email\',450,250); return false;">';
			 $return .= '<img src="'.get_stylesheet_directory_uri().'/images/share_mailto.png" title="Email" class="ssba ssba-img oet-social-img" alt="Email to someone">';
		 $return .= '</a>';
	 $return .= '</div>';
	$return .= '</div>';
	return $return;
}

?>