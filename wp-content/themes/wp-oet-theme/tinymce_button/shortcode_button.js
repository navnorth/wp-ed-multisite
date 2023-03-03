(function() {
    tinymce.PluginManager.add('oet_tinymce_plugin', function( editor, url ) {
		var popup_generator = url+"/popup_generator.php";
        editor.addButton( 'oet_tinymce_button', {
            title: 'Add Theme Shortcodes',
			image : '../wp-includes/images/smilies/icon_question.gif',
			both: true,
            onclick : function() {
				tb_show( 'Add Shortcodes', popup_generator+"?action=show_popup&width=800&height=550" );	
			}
        });
    });
})()