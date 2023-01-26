<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */

/*
function oese_shortcodes_block_admin_enqueue(){
	 wp_enqueue_style(
	 		'oese_shortcodes_block-cgb-style-css',
	 			get_stylesheet_directory().'/modules/shortcodesblock/blocks.style.build.css',
	 		is_admin() ? array( 'wp-editor' ) : null,
	 		null
	 );
	 wp_enqueue_script(
	 		'oese_shortcodes_block-cgb-block-js',
	 		get_stylesheet_directory().'/modules/shortcodesblock/blocks.build.js',
	 		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ),
	 		null,
	 		true
	 );
	 wp_enqueue_style(
	 		'oese_shortcodes_block-cgb-block-editor-css',
	 		get_stylesheet_directory().'/modules/shortcodesblock/blocks.editor.build.css'
	 		array( 'wp-edit-blocks' ),
	 		null
	 );
}
do_action( 'admin_enqueue_scripts', 'oese_shortcodes_block_admin_enqueue' );
*/

function oese_shortcodes_block_cgb_block_assets() { // phpcs:ignore

	// Register block styles for both frontend + backend.
	wp_register_style(
		'oese_shortcodes_block-cgb-style-css', // Handle.
		get_template_directory_uri().'/modules/shortcodesblock/blocks.style.build.css', // Block style CSS.
		is_admin() ? array( 'wp-editor' ) : null, // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'oese_shortcodes_block-cgb-block-js', // Handle.
		get_template_directory_uri().'/modules/shortcodesblock/blocks.build.js', // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);


	
	// Register Mainstyle.
	/*
	wp_enqueue_style(
		'oese_shortcodes_block-cgb-mainstyle-css', 
		'/wp-content/themes/wp-oese-theme/css/mainstyle.css', 
		array(),
		99
	);
	*/

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'oese_shortcodes_block-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	
	register_block_type(
		'cgb/block-oese-shortcodes-block', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'oese_shortcodes_block-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'oese_shortcodes_block-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'oese_shortcodes_block-cgb-block-editor-css',
			'render_callback' => 'render_posts_block'
		)
	);
	

}


function render_posts_block($attributes, $ajx=false){
	 remove_filter( 'the_content', 'wpautop' );
   $shrtcd = $attributes['selectedShortodeValue'];
	 if($attributes['displayflex']){
		 $_ret = '<div class="oese_shortcode_block flx">'.do_shortcode(stripslashes($shrtcd)).'</div>';
	 }else{
		 $_ret = '<div class="oese_shortcode_block">'.do_shortcode(stripslashes($shrtcd)).'</div>';
	 }
	 
	 add_filter( 'the_content', 'wpautop' );
	 return $_ret;
	 
}



// Hook: Block assets.
add_action( 'init', 'oese_shortcodes_block_cgb_block_assets' );




// Register a REST route
add_action( 'rest_api_init', function () {
		register_rest_route( 'oeseshortcodeblock/v2', 'optionsquery', array(
          'methods' => 'GET', 
          'callback' => 'oeseshortcodeblock_options_query',
					'permission_callback' => '__return_true'
    ) );
		
		register_rest_route( 'oeseshortcodeblock/v2', 'shortcodequery', array(
          'methods' => 'GET', 
          'callback' => 'oeseshortcodeblock_shortcode_query',
					'permission_callback' => '__return_true'
    ) );
});

function oeseshortcodeblock_options_query(){
	$_ret = array();
		$_ret[0]['name']  = 'Accordion';
		$_ret[0]['value'] = '[oese_accordion_group id="accordion1"][oese_accordion title="Title Here" accordion_series="one" expanded="" group_id="accordion1"] your content goes here [/oese_accordion][oese_accordion title="Title Here" accordion_series="two" expanded="" group_id="accordion1"] your content goes here [/oese_accordion][oese_accordion title="Title Here" accordion_series="three" expanded="" group_id="accordion"] your content goes here [/oese_accordion][/oese_accordion_group]';
		
		$_ret[1]['name']  = 'Disruptive Content';
		$_ret[1]['value'] = '[disruptive_content title="Title Here" main_text="Description Here" button_text="Button Text" button_color="" button_url=""]';
		
		$_ret[2]['name']  = 'Button';
		$_ret[2]['value'] = '[oet_button text="" button_color="" text_color="" font_face="" font_size="" font_weight="" url="" new_window="yes/no"]';
		
		$_ret[3]['name']  = 'Featured Item';
		$_ret[3]['value'] = '[featured_item heading="Heading Here" url="" image="" title="Title Here" date="" button="" button_text="" sharing=""]your content goes here[/featured_item]';
		
		$_ret[4]['name']  = 'Featured Video';
		$_ret[4]['value'] = '[oese_featured_video heading="title" videoid="GBT4f146h9U" description="description" height="300"]';
		
		/*
		$_ret[5]['name']  = 'Left Column';
		$_ret[5]['value'] = '[home_left_column heading="yes/no"] your content goes here [/home_left_column]';
		*/
		
		$_ret[5]['name']  = 'Pull Quote';
		$_ret[5]['value'] = '[pull_quote speaker="" additional_info=""]your content goes here[/pull_quote]';
		
		/*
		$_ret[7]['name']  = 'Right Column';
		$_ret[7]['value'] = '[home_right_column] your content goes here [/home_right_column]';
		*/
		
		$_ret[6]['name']  = 'Recommended Resources';
		$_ret[6]['value'] = '[recommended_resources media_type1="" src1="" text1="" link1="" media_type2="" src2="" text2="" link2="" media_type3="" src3="" text3=""  link3=""]';
		
		$_ret[7]['name']  = 'Featured Content Box';
		$_ret[7]['value'] = '[featured_content_box title="" top_icon="" align=""]your content goes here[/featured_content_box]';
		
		$_ret[8]['name']  = 'Bootstrap Grid';
		$_ret[8]['value'] = '[row][column md="4"] your 1st column content here[/column][column md="4"] your 2nd column content here[/column][column md="4"] your 3rd column content here[/column][/row]';
		
		$_ret[9]['name']  = 'Spacer';
		$_ret[9]['value'] = '[spacer height="16"]';
		
		$_ret[10]['name']  = 'Callout Box';
		$_ret[10]['value'] = '[oet_callout type="" width="" color="" alignment=""]Your content goes here[/oet_callout]';
		
		$_ret[11]['name']  = 'Publication Intro';
		$_ret[11]['value'] = '[publication_intro title=""]Intro content goes here[/publication_intro]';
		
		$_ret[12]['name']  = 'Audience Link';
		$_ret[12]['value'] = '[audience_link url=""]Audience name goes here[/audience_link]';
		
		$_ret[13]['name']  = 'Publication';
		$_ret[13]['value'] = '[oese_publication src=""]';
		
		$_ret[14]['name']  = 'Subpages';
		$_ret[14]['value'] = '[oese_sub_pages title="" id=""]';
		
		$_ret[15]['name']  = 'Featured Card';
		$_ret[15]['value'] = '[oet_featured_card title="Title Here" button_text="Read More" button_link="" background_image=""]your content goes here[/oet_featured_card]';
		
		$_ret[16]['name']  = 'Disclaimer';
		$_ret[16]['value'] = '[oese_disclaimer title="Disclaimer:"]Content provides insights on education practices from the perspective of schools, parents, students, grantees, community members and other education stakeholders to promote the continuing discussion of educational innovation. Content and articles are not intended to reflect their importance, nor is it intended to be an endorsement by the Department or the Federal government of any views expressed, products or services offered, curriculum or pedagogy.[/oese_disclaimer]';
		
	return $_ret;
}

function oeseshortcodeblock_shortcode_query(){
	
	$shrtcd = $_GET['shrtcd'];
	$cnt = 0;
		
		ob_start( );
		$_ret = do_shortcode(stripslashes($shrtcd));
		//$_ret = do_shortcode('[oese_accordion_group][oese_accordion title="Accordion Title" accordion_series="one" expanded=""] your content goes here [/oese_accordion][/oese_accordion_group]');
    //$_ret = ob_get_clean( );
		

	return $_ret;
}