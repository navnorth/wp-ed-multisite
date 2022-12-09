<?php
/*Register post type (assessment, domain, rating)*/
add_action("init", "gap_init_function");
function gap_init_function()
{
	$post_types = array("Assessment"=>"Assessments", "Domain"=>"Domains", 'Rating' => 'ratings');
	
	foreach($post_types as $key => $posttype)
	{
		if($key == 'Rating')
		{
			$support = array( 'title', 'editor' );
		}
		else
		{
			$support = array( 'title', 'editor', 'thumbnail' );
		}
		$labels = array(
			'name'               => _x( $posttype, 'post type general name', PLUGIN_DOMAIN ),
			'singular_name'      => _x( $key, 'post type singular name', PLUGIN_DOMAIN ),
			'menu_name'          => _x( $posttype, 'admin menu', PLUGIN_DOMAIN ),
			'name_admin_bar'     => _x( $key, 'add new on admin bar', PLUGIN_DOMAIN ),
			'add_new'            => _x( 'Add New', strtolower($key), PLUGIN_DOMAIN ),
			'add_new_item'       => __( 'Add New '.$key, PLUGIN_DOMAIN ),
			'new_item'           => __( 'New '.$key, PLUGIN_DOMAIN ),
			'edit_item'          => __( 'Edit '.$key, PLUGIN_DOMAIN ),
			'view_item'          => __( 'View '.$key, PLUGIN_DOMAIN ),
			'all_items'          => __( 'All '.$posttype, PLUGIN_DOMAIN ),
			'search_items'       => __( 'Search '.$posttype, PLUGIN_DOMAIN ),
			'parent_item_colon'  => __( 'Parent '.$posttype.':', PLUGIN_DOMAIN ),
			'not_found'          => __( 'No '.strtolower($posttype).' found.', PLUGIN_DOMAIN ),
			'not_found_in_trash' => __( 'No '.strtolower($posttype).' found in Trash.', PLUGIN_DOMAIN )
		);
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => strtolower($key) ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => $support,
			'register_meta_box_cb' => strtolower($key)."_metabox_func"
		);
		register_post_type( strtolower($key), $args );
	}
	$labels = array(
		'name'                       => _x( 'Tags', 'taxonomy general name' ),
		'singular_name'              => _x( 'Tag', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Tags' ),
		'popular_items'              => __( 'Popular Tags' ),
		'all_items'                  => __( 'All Tags' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Tag' ),
		'update_item'                => __( 'Update Tag' ),
		'add_new_item'               => __( 'Add New Tag' ),
		'new_item_name'              => __( 'New Tag Name' ),
		'separate_items_with_commas' => __( 'Separate tags with commas' ),
		'add_or_remove_items'        => __( 'Add or remove tags' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags' ),
		'not_found'                  => __( 'No tags found.' ),
		'menu_name'                  => __( 'Tags' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'tag' ),
	);

	register_taxonomy( 'tag', array('assessment', 'domain'), $args );
	
	$labels = array(
		'name'                       => _x( 'Scales', 'taxonomy general name' ),
		'singular_name'              => _x( 'Scale', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Scales' ),
		'popular_items'              => __( 'Popular Scales' ),
		'all_items'                  => __( 'All Scales' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Scale' ),
		'update_item'                => __( 'Update Scale' ),
		'add_new_item'               => __( 'Add New Scale' ),
		'new_item_name'              => __( 'New Scale Name' ),
		'separate_items_with_commas' => __( 'Separate scales with commas' ),
		'add_or_remove_items'        => __( 'Add or remove scales' ),
		'choose_from_most_used'      => __( 'Choose from the most used scales' ),
		'not_found'                  => __( 'No scales found.' ),
		'menu_name'                  => __( 'Scales' ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'scale' ),
	);

	register_taxonomy( 'scale', array('rating'), $args );	
}
/*Create Plugin menu*/
add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page()
{
	add_menu_page( 'Gap Assessment', 'Gap Assessment', 'edit_private_pages', 'edit.php?post_type=assessment', '', 'dashicons-editor-help', 4 );
	add_submenu_page( 'edit.php?post_type=assessment' , 'Assessment', 'Assessment', 'edit_private_pages', 'edit.php?post_type=assessment' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'Rating Systems' , 'Rating Systems' , 'edit_private_pages' , 'edit.php?post_type=rating' , '' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'Reporting' , 'Reporting' , 'edit_private_pages' , 'reporting' , 'show_reports' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'Settings' , 'Settings' , 'edit_private_pages' , 'settings' , 'import_organizations' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'Scale', 'Scale', 'edit_private_pages', 'edit-tags.php?taxonomy=scale&post_type=rating' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'GAT Admin Debug Screen', 'Debug', 'edit_private_pages', 'ordering', 'show_debug_screen' );
	
	add_submenu_page( 'edit.php?post_type=assessment' , 'add assessment', 'add assessment', 'edit_private_pages', 'post-new.php?post_type=assessment' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'add domain', 'add domain', 'edit_private_pages', 'post-new.php?post_type=domain' );
	add_submenu_page( 'edit.php?post_type=assessment' , 'add rating', 'add rating', 'edit_private_pages', 'post-new.php?post_type=rating' );
}
//Report function
function show_reports()
{
	include_once( GAT_PATH ."/metabox/show-reports.php" );
}
//Setting function
function import_organizations()
{
  include_once( GAT_PATH ."/metabox/import-organization.php" );  
}

//Show Debug Screen Function
function show_debug_screen(){
  include_once( GAT_PATH ."/metabox/debug-screen.php" );  	
}

include_once( GAT_PATH ."/metabox/assessment-metabox.php" );
include_once( GAT_PATH ."/metabox/domain-metabox.php" );
include_once( GAT_PATH ."/metabox/rating-metabox.php" );
?>