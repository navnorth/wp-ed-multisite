<?php
/**
 * Disruptive Content
 * Shortcode Example : [disruptive_content title='' main_text='' button_text='' button_color='' button_url='']
 */
add_shortcode("disruptive_content", "disruptive_content_fun" );
function disruptive_content_fun($attr, $content = null)
{
	extract($attr);

	$return = '';
    $return .= '<div class="row bg_img_of_icns" id="lnk_btn_cntnr_center">';
        $return .= '<div class="col-md-8 col-sm-8 col-xs-8" >';
            $return .= '<h3>'. $title .'</h3>';
            $return .= '<p>';
				//$main_text = apply_filters('the_content', $main_text);
            	$return .= $main_text;
            $return .= '</p>';
        $return .= '</div>';
        $return .= '<div class="col-md-4 col-sm-4 col-xs-4 text-right">';
			$return .= '<div class="link_dwnlds"><div><a href="'. $button_url .'" class="btn_dwnld" style="background-color:'. $button_color.'">'. $button_text .'</a></div></div>';
        $return .= '</div>';
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
	//extract($atts);
	$return = '';
	$return .= '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
			$content = str_replace( "<p>","", $content );
			$content = str_replace( "</p>","", $content );
			$return .= do_shortcode($content);
	$return .= '</div>';
	return $return;
}

add_shortcode('oet_accordion', 'oet_accordion_func');
function oet_accordion_func($atts, $content = null)
{
  extract($atts);
  $return = '';

  if(isset($accordion_series) && !empty($accordion_series))
  {
		$return .= '<div class="panel panel-default">';

		$return .= '<div class="panel-heading" role="tab" id="heading'. $accordion_series .'">';
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

			  $return .= '<a class="'.$class.'" data-toggle="collapse" data-parent="#accordion" href="#collapse'. $accordion_series .'" aria-expanded="false" aria-controls="collapse'. $accordion_series .'">';
			  $return .= $title;
			$return .= '</a>';
		 $return .= ' </h5>';
		$return .= '</div>';

		$return .= '<div id="collapse'. $accordion_series .'" class="panel-collapse collapse '.$uptcls.'" role="tabpanel" aria-labelledby="heading'. $accordion_series .'">';
		  $return .= '<div class="panel-body">';
			//$content = apply_filters('the_content', $content);
			$return .= $content;
		  $return .= '</div>';
		$return .= '</div>';

		$return .= '</div>';

		return $return;
  }
}

/**
 * Pull Quote
 * Shortcode Example : [pull_quote speaker="" additional_info=""]your content goes here[/pull_quote]
 */
add_shortcode('pull_quote', 'pull_quotethemefn');
function pull_quotethemefn($atts, $content = null)
{
	$speaker = $atts['speaker'];
	$additional_info = $atts['additional_info'];

	$return = '';
	$return .= '<div class="col-md-1 col-sm-1 col-xs-1">';
		$return .= '<img src="'. get_stylesheet_directory_uri() .'/images/dbl_cod_img.png" alt="Quote"/>';
	$return .= '</div>';

	$return .= '<div class="col-md-11 col-sm-11 col-xs-11">';
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
 * Shortcode Example : [featured_item heading='' url="" image='' title='' date='' button='' button_text='' sharing='']your content goes here[/featured_item]
 */
add_shortcode("featured_item","featured_item_func");
function featured_item_func($attr, $content = null)
{
	extract($attr);
	$return = '';
	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 rght_sid_mtr">';
	if(isset($heading) && !empty($heading))
	{
    	$return .= '<h4>'. $heading .'</h4>';
	}
	if(isset($image) && !empty($image))
	{
		if(isset($url) && !empty($url))
		{
			$return .= '<a href="'. $url.'"><img class="featured_item_image" src="'. $image .'" alt="Featured Image" /></a>';
		}
		else
		{
    		$return .= '<img class="featured_item_image" src="'. $image .'" alt="Featured Image"/>';
		}
	}
	if(isset($title) && !empty($title))
	{
    	if(isset($url) && !empty($url))
		{
			$return .= '<p class="hdng_mtr"><a href="'. $url.'">'. $title .'</a></p>';
		}
		else
		{
    		$return .= '<p class="hdng_mtr">'. $title .'</p>';
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
		$return .= '<div class="home_dwnld_btn"><a class="btn_dwnld" style="background-color:#e57200" href="'.$url.'">';

		if(isset($button_text) && !empty($button_text))
		{
			$return .= $button_text.'</a></div>';
		}
		else
		{
			$return .= 'Download</a></div>';
		}
	}
	if(strtolower($sharing) == 'show')
	{
		$return .= '<div class="col-md-7 col-sm-7 col-xs-7 rght_sid_socl_icn">';
			$return .= do_shortcode("[ssba]");
		$return .= '</div>';
	}
    $return .= '</div>';

	return $return;
}

/**
 * Featured Video
 * Shortcode Example : [featured_video heading="" src="" description="" height=""]
 */
add_shortcode("featured_video","feature_video_func");
function feature_video_func($attr, $content = null)
{
	extract($attr);

	$return = '';
	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 rght_sid_mtr">';
	if(isset($heading) && !empty($heading))
	{
		$return .= '<h4>'. $heading .'</h4>';
	}

	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 vdo_bg">';

			if(isset($src) && !empty($src))
			{
				if(empty($height))
				{
					$height = 300;
				}

             	$return .= '<iframe width="540" height="'. $height.'" src="'. $src .'" allowfullscreen></iframe>';
			}

			if(isset($description) && !empty($description))
			{
				//$description = apply_filters('the_content', $description);
				$return .= '<p>'. $description .'</p>';
			}
    $return .= '</div>';
	$return .= '</div>';
	return $return;
}

/**
 * Home Right Column
 * Shortcode Example : [home_right_column] your content goes here [/home_right_column]
 */
add_shortcode('home_right_column', 'home_right_column_func');
function home_right_column_func($atts, $content = null)
{
	//extract($atts);
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
	extract($atts);

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
	extract($attr);
	$return = '';
	$return .= '<div class="col-md-12 col-sm-12 col-xs-12 lft_sid_mtr">';
			$return .= '<div class="col-md-12 lft_sid_mtr">';

			if(isset($heading) && !empty($heading))
			{
				$return .= '<h4>'. $heading .'</h4>';
			}
			if(isset($image) && !empty($image))
			{
				$return .= '<img class="featured_area_image" src="'. $image .'"  alt="Featured Image" />';
			}
			if(isset($title) && !empty($title))
			{
				$return .= '<p class="hdng_mtr">'. $title .'</p>';
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
	extract($attr);
	$return = '';
	if(isset($heading) && !empty($heading))
	{
		$return .= '<p class="pblctn_scl_icn_hedng">'. $heading.'</p>';
	}

	if(isset($text1) && !empty($text1) && isset($src1) && !empty($src1) && isset($text2) && !empty($text2) && isset($src2) && !empty($src2) && isset($text3) && !empty($text3) && isset($src3) && !empty($src3))
	{
        $return .= '<div class="col-md-12 col-sm-12 col-xs-12 padding_left padding_right tlkt_stp_vdo_cntnr">';
		if(isset($media_type1) && !empty($media_type1) && strtolower($media_type1) == 'video')
		{
			if(isset($text1) && !empty($text1) && isset($src1) && !empty($src1))
			{
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<iframe width="274" height="160" src="'. $src1 .'" allowfullscreen></iframe>';
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
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<iframe width="274" height="160" src="'. $src2 .'" allowfullscreen></iframe>';
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
				$return .= '<div class="col-md-4 col-sm-4 col-xs-4 pblctn_vdo_bg">';
					$return .= '<iframe width="274" height="160" src="'. $src3 .'" allowfullscreen></iframe>';
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
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<iframe width="274" height="160" src="'. $src1 .'" allowfullscreen></iframe>';
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
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<iframe width="274" height="160" src="'. $src2 .'" allowfullscreen></iframe>';
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
				$return .= '<div class="col-md-6 col-sm-12 col-xs-12 pblctn_vdo_bg_fr_two">';
					$return .= '<iframe width="274" height="160" src="'. $src3 .'" allowfullscreen></iframe>';
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

 function featured_content_box_func($attr, $content = null)
 {
	 extract($attr);
	 $return = '';
		$return .= '<div class="pblctn_right_sid_mtr">';
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
            $return .= '<P class="rght_sid_wdgt_hedng">'. $title .'</P>';
            $return .= '<div class="cntnbx_cntnr" style="text-align:'. $align.'">'.$content.'</div>';
        $return .= '</div>';
		$return .= '</div>';

		return $return;
 }
?>
