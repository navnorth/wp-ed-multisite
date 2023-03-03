<?php
add_action('admin_head', 'oet_add_tinyme_button');

add_action('media_buttons', 'oet_media_buttons_context');
//fallback if media_buttons fail
add_action('media_buttons_context', 'oet_media_buttons_context');

add_action('admin_print_footer_scripts', 'oet_add_quicktags');
function oet_add_quicktags()
{
	?>
	<script type="text/javascript">
	if ( window.QTags !== undefined ) {
		QTags.addButton( 'shortcodes', 'add shortcodes', function(){ jQuery('#add_shortcode').click() } );
	}
	</script>
<?php
}
function oet_media_buttons_context($context)
{
	global $post_ID, $temp_ID;
	$iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
	$out = '<a id="add_shortcode" style="display:none" href="'.get_stylesheet_directory_uri().'/tinymce_button/popup_generator.php?action=show_popup&width=800&height=550" class="hide-if-no-js thickbox" title="Add shortcode"><img src="'.get_stylesheet_directory_uri().'/tinymce_button/images/icon_shortcodes.png" alt="Add Shortcode" /></a>';
	return $context . $out;
}
function oet_add_tinyme_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
   	return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
	// check if WYSIWYG is enabled
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "oet_add_tinymce_plugin");
		add_filter('mce_buttons', 'oet_register_tinymce_button');
	}
}
function oet_add_tinymce_plugin($plugin_array) {
   	$plugin_array['oet_tinymce_plugin'] = get_stylesheet_directory_uri().'/tinymce_button/shortcode_button.js'; // CHANGE THE BUTTON SCRIPT HERE
   	return $plugin_array;
}
function oet_register_tinymce_button($buttons) {
   array_push($buttons, "oet_tinymce_button");
   return $buttons;
}
?>