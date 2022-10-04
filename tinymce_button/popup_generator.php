<?php
/** Load WordPress Bootstrap */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

extract($_REQUEST);

if($action == "show_popup")
{
	$return = '';

	$return .= '<div id="oet-shrtcdv2-form">';
		$return .= '<div class="oet-shrtcdv2-left-column">';
				$return .= '<ul>';
						$return .= '<li><div data="accordian" class="oet-shrtcdv2_tab">Accordion</div></li>';
						$return .= '<li><div data="banner" class="oet-shrtcdv2_tab">Disruptive Content</div></li>';
						$return .= '<li><div data="button" class="oet-shrtcdv2_tab">Button</div></li>';
						$return .= '<li><div data="featured_content" class="oet-shrtcdv2_tab">Featured Content</div></li>';
						$return .= '<li><div data="featured_video" class="oet-shrtcdv2_tab">Featured Video</div></li>';
						$return .= '<li><div data="pull_quotes" class="oet-shrtcdv2_tab">Pull Quotes</div></li>';
						$return .= '<li><div data="left_column" class="oet-shrtcdv2_tab">Left Column</div></li>';
						$return .= '<li><div data="right_column" class="oet-shrtcdv2_tab">Right Column</div></li>';
						$return .= '<li><div data="recommended_resources" class="oet-shrtcdv2_tab">Recommended Resource</div></li>';
						$return .= '<li><div data="featured_content_box" class="oet-shrtcdv2_tab">Featured Content Box</div></li>';
						$return .= '<li><div data="bsgrid" class="oet-shrtcdv2_tab">Bootstrap Grid</div></li>';
						$return .= '<li><div data="spacer" class="oet-shrtcdv2_tab">Spacer</div></li>';
						$return .= '<li><div data="callout_box" class="oet-shrtcdv2_tab">Callout Box</div></li>';
						$return .= '<li><div data="publication_intro" class="oet-shrtcdv2_tab">Publication Intro</div></li>';
						$return .= '<li><div data="oet_story" class="oet-shrtcdv2_tab">Story Embed</div></li>';
						$return .= '<li><div data="oet_medium" class="oet-shrtcdv2_tab">Medium Embed</div></li>';
						$return .= '<li><div data="oet_featured_card" class="oet-shrtcdv2_tab">Featured Card</div></li>';			
						$return .= '<li><div data="oet_social" class="oet-shrtcdv2_tab">Social Share</div></li>';
				$return .= '</ul>';
		$return .= '</div>';
		$return .= '<div class="oet-shrtcdv2-right-column">';
			$return .= '<div class="oet-shrtcdv2-block">';
				$return .= '<h2>SHORTCODE</h2>';
				$return .= '<textarea class="oet-shrtcdv2_shortcode" rows="10" cols="50" disabled></textarea>';
			$return .= '</div>';
			
			$return .= '<div class="oet-shrtcdv2-block">';
				$return .= '<h2>PREVIEW</h2>';
				$return .= '<div class="oet-shrtcdv2_preview"></div>';
			$return .= '</div>';
			
			$return .= '<div class="oet-shrtcdv2-block">';
				$return .= '<input type="button" id="oet-shrtcdv2-submit" onclick="oetInsertShortcode();" class="button-primary" value="Insert Shortcode" name="submit" />';
			$return .= '</div>';
			
		$return .= '</div>';
	$return .= '</div>';

	
	$return .= '<div id="oet-shortcode-form" style="display:none;"><div id="oet-table" class="form-table">
					<div class="oet_sngltinyrow">
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="accordian">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/accordian.png">
							</div>
							<div class="oert_snglttltiny">
								Accordion
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="banner">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/banner.png">
							</div>
							<div class="oert_snglttltiny">
								Disruptive Content
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="button">
							<div class="oert_snglimgtiny" style="height:90px; vertical-align:middle;">
								<button class="btn custom-button" style="margin-top:40px;">button</button>
							</div>
							<div class="oert_snglttltiny">
								Button
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="featured_content">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/featured_content.png">
							</div>
							<div class="oert_snglttltiny">
								Featured Content
							</div>
						</div>
					</div>

					<div class="oet_sngltinyrow">
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="featured_video">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/featured_video.png">
							</div>
							<div class="oert_snglttltiny">
								Featured Video
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="pull_quotes">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/pull_quotes.png">
							</div>
							<div class="oert_snglttltiny">
								Pull Quotes
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="left_column">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/left_column.png">
							</div>
							<div class="oert_snglttltiny">
								Left Column
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="right_column">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/right_column.png">
							</div>
							<div class="oert_snglttltiny">
								Right Column
							</div>
						</div>
					</div>

					<div class="oet_sngltinyrow">
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="recommended_resources">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/featured_video.png">
							</div>
							<div class="oert_snglttltiny">
								Recommended Resource
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="featured_content_box">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/featured_video.png">
							</div>
							<div class="oert_snglttltiny">
								Featured Content Box
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="bsgrid">
							<div class="oert_snglimgtiny">
								<div class="oet_bs_row"></div>
								<div class="oet_bs_row2"><div class="oet_bs_col"></div><div class="oet_bs_col"></div><div class="oet_bs_col"></div></div>
							</div>
							<div class="oert_snglttltiny">
								Bootstrap Grid
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="spacer">
							<div class="oert_snglimgtiny" style="height:60px; vertical-align:middle;">
								<hr style="margin-top:35px;" />
							</div>
							<div class="oert_snglttltiny">
								Spacer
							</div>
						</div>
					</div>
					<div class="oet_sngltinyrow">
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="callout_box">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/callout-box.png">
							</div>
							<div class="oert_snglttltiny">
								Callout Box
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="publication_intro">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/pubintro.png">
							</div>
							<div class="oert_snglttltiny">
								Publication Intro
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="oet_story">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/featured_area.png">
							</div>
							<div class="oert_snglttltiny">
								Story Embed
							</div>
						</div>
						<div class="oet_sngltinyclm" onclick="oet_meclicked(this);" data-shortcode="oet_medium">
							<div class="oert_snglimgtiny">
								<img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/featured_area.png">
							</div>
							<div class="oert_snglttltiny">
								Medium Embed
							</div>
						</div>
					</div>
					<div class="oet_sngltinyrow">
						<div class="submit">
							<input type="button" id="oet-tinymce-submit" onclick="placeoetshortcode();" class="button-primary" value="Insert Shortcode" name="submit" />
						</div>
					</div>
		</div>
		</div>
		<script type="text/javascript">
			function oet_meclicked(ref)
			{
				jQuery(".oet_sngltinyclm").each(function(index, element) {
    				jQuery(this).removeClass("oet_snglslctd");
				});
				jQuery(ref).addClass("oet_snglslctd");
			}
			function placeoetshortcode(){
				var shortcode_type = jQuery(".oet_sngltinyclm.oet_snglslctd").attr("data-shortcode");
				var shortcode = get_myshortcode(shortcode_type);
				if(typeof tinyMCE != "undefined" && ( ed = tinyMCE.activeEditor ) && !ed.isHidden()){
					tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
					tinymce.EditorManager.execCommand("mceRemoveControl",true, "content");
				}
				else
				{
					var cursor = jQuery("#content").prop("selectionStart");
					if(!cursor) cursor = 0;
					var content = jQuery("#content").val();
					var textBefore = content.substring(0,  cursor );
					var textAfter  = content.substring( cursor, content.length );
					jQuery("#content").val( textBefore + shortcode + textAfter );
				}
				tb_remove();
			}
			function get_myshortcode(shortcode_type)
			{
				switch (shortcode_type)
				{
				   case "accordian":
					   var shortcode = "[oet_accordion_group id=\'accordion1\'][oet_accordion title=\'Title Here\' accordion_series=\'one\' expanded=\'\' group_id=\'accordion1\'] your content goes here [/oet_accordion][oet_accordion title=\'Title Here\' accordion_series=\'two\' expanded=\'\' group_id=\'accordion1\'] your content goes here [/oet_accordion][oet_accordion title=\'Title Here\' accordion_series=\'three\' expanded=\'\' group_id=\'accordion1\'] your content goes here [/oet_accordion][/oet_accordion_group]";
					   break;
				   case "banner":
					   var shortcode = "[disruptive_content title=\'Title Here\' main_text=\'Text Here\' button_text=\'Button Text\' button_color=\'\' button_url=\'\']";
					   break;
				   case "button":
					   var shortcode = "[oet_button text=\'Button Text\' button_color=\'\' text_color=\'\' font_face=\'\' font_size=\'\' font_weight=\'\' url=\'\' new_window=\'yes/no\']";
					   break;
				   case "featured_content":
					   var shortcode = "[featured_item heading=\'\' image=\'\' image_alt=\'\' title=\'\' date=\'\' button=\'\' button_text=\'\' url=\'\' sharing=\'\']your content goes here[/featured_item]";
					   break;
				   case "featured_video":
					   var shortcode = "[featured_video heading=\'Mindful Minutes: Technology For Learning\' videoid=\'6xmh0OO330Q\' description=\'\' height=\'\']";
					   break;
				   case "left_column":
					   var shortcode = "[home_left_column heading=\'yes/no\'] your content goes here [/home_left_column]";
					   break;
				   case "pull_quotes":
					   var shortcode = "[pull_quote speaker=\'\' additional_info=\'\']your content goes here[/pull_quote]";
					   break;
				   case "right_column":
					   var shortcode = "[home_right_column] your content goes here [/home_right_column]";
					   break;
				   case "recommended_resources":
					   var shortcode = "[recommended_resources media_type1=\'\' src1=\'\' text1=\'\' link1=\'\' media_type2=\'\' src2=\'\' text2=\'\' link2=\'\' media_type3=\'\' src3=\'\' text3=\'\'  link3=\'\']";
					   break;
				   case "featured_content_box":
					   var shortcode = "[featured_content_box title=\'\' top_icon=\'\' align=\'\']your content goes here[/featured_content_box]";
					   break;
				   case "bsgrid":
					   var shortcode = "[row][column md=\'4\'] your 1st column content here[/column][column md=\'4\'] your 2nd column content here[/column][column md=\'4\'] your 3rd column content here[/column][/row]";
					   break;
				   case "spacer":
					   var shortcode = "[spacer height=\'16\']";
					   break;
				   case "callout_box":
					   var shortcode = "[oet_callout type=\'\' width=\'\' color=\'\' alignment=\'\']Your content goes here[/oet_callout]";
					   break;
				   case "publication_intro":
					   var shortcode = "[publication_intro title=\'\']Intro content goes here[/publication_intro]";
					   break;
				   case "oet_story":
					   var shortcode = "[oet_story id=\'\' width=\'6\' alignment=\'\' callout_color=\'\' callout_type=\'\' title=\'\'][/oet_story]";
					   break;
				   case "oet_medium":
					   var shortcode = "[oet_medium url=\'\' align=\'center\' title=\'\' description=\'\' image=\'\' bgcolor=\'\']";
						 break;
					 case "oet_featured_card":
	 						var shortcode = "[oet_featured_card title=\'Title Here\' button_text=\'Read More\' button_link=\'\' background_image=\'\']your content goes here[/oet_featured_card]";
					   break;
					case "oet_social":
	 					var shortcode = "[oet_social]";
					   break;
				   default:
				   	   var shortcode = "";
				   	   break
				}
				return shortcode;
			}
			</script>';
	echo $return;
}
?>
