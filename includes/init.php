<?php

//Register Assessment as Custom Post Type
add_action( 'init' , 'register_assessment_type' );
function register_assessment_type(){
    
    //Labels
    $labels = array(
                    'name' => _x( 'Gap Assessment' , 'post type general name' , PLUGIN_DOMAIN ) ,
                    'singular_name' => _x( 'Assessment' , 'post type singular name'  , PLUGIN_DOMAIN ) ,
                    'name_admin_bar' => _x( 'Assessment' , 'add new on admin bar' , PLUGIN_DOMAIN ) ,
                    'all_items' => __( 'Assessments' , PLUGIN_DOMAIN ) ,
                    'search_items' => __( 'Search Assessments' , PLUGIN_DOMAIN ) ,
                    'not_found' => __( 'No assessments found' , PLUGIN_DOMAIN )
                    );
    
    //Arguments
    $args = array(
                    'labels' => $labels ,
                    'description' => 'Create Assessment' ,
                    'public' => true ,
                    'show_ui' => true ,
                    'menu_icon' => 'dashicons-editor-help' ,
                    'has_archive' => true ,
                    'menu_position' => 25 ,
                    'taxonomies' => array('post_tag') ,
                    'supports' => array( 'title', 'editor' , 'thumbnail' , 'revisions' ) ,
                    'register_meta_box_cb' => 'assessment_metaboxes'
                  );
    register_post_type( 'assessment' , $args );
}

add_action('admin_menu', 'remove_default_assessment_submenus', 999);
function remove_default_assessment_submenus(){
    // remove tags
    remove_submenu_page( 'edit.php?post_type=assessment', 'edit-tags.php?taxonomy=post_tag&amp;post_type=assessment' );
    
    //Remove Default Add New
    remove_submenu_page( 'edit.php?post_type=assessment', 'post-new.php?post_type=assessment' );
}

//Register Domains as taxonomy
//add_action( 'init' , 'register_domain_taxonomy' );
function register_domain_taxonomy(){
    //Labels
    $labels = array(
                    'name' => _x( 'Domain' , 'taxonomy general name' ) ,
                    'singular_name' => _x( 'Domain' , 'taxonomy singular name' ) ,
                    'add_new_item' => __( 'Add New Domain' ) ,
                    'new_item_name' => __( 'New Domain' ) ,
                    'edit_item' => __( 'Edit Domain' ) ,
                    'update_item' => __( 'Update Domain' ) ,
                    'all_items' => __( 'All Domains' ) ,
                    'search_items' => __( 'Search Domains' ) ,
                    'menu_name' => __( 'Domains' )
                    );
    
    //Arguments
    $args = array(
                    'hierarchical'      => true,
                    'labels'            => $labels,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    'rewrite'           => array( 'slug' => 'domain' )
                    //'meta_box_cb'       => 'domain_metaboxes'
                  );
    register_taxonomy( 'domain' , array( 'assessment' ) , $args );
}

//Register Dimension as Custom Post Type
//add_action( 'init' , 'register_dimension_post_type' );
function register_dimension_post_type(){
    //Labels
    $labels = array(
                    'name' => _x( 'Dimension' , 'post type general name' , PLUGIN_DOMAIN ) ,
                    'singular_name' => _x( 'Dimension' , 'post type singular name'  , PLUGIN_DOMAIN ) ,
                    'menu_name' => _x( 'Dimension' , 'admin menu' , PLUGIN_DOMAIN ) ,
                    'name_admin_bar' => _x( 'Dimension' , 'add new on admin bar' , PLUGIN_DOMAIN ) ,
                    'add_new' => _x( 'Add New' , 'dimension' , PLUGIN_DOMAIN ) ,
                    'add_new_item' => __( 'Add New Dimension' , PLUGIN_DOMAIN ) ,
                    'new_item' => __( 'New Dimension' , PLUGIN_DOMAIN ) ,
                    'edit_item' => __( 'Edit Dimension' , PLUGIN_DOMAIN ) ,
                    'view_item' => __( 'View Dimension' , PLUGIN_DOMAIN ) ,
                    'all_items' => __( 'All Dimension' , PLUGIN_DOMAIN ) ,
                    'search_items' => __( 'Search Dimension' , PLUGIN_DOMAIN ) ,
                    'not_found' => __( 'No dimensions found' , PLUGIN_DOMAIN )
                    );
    
    //Arguments
    $args = array(
                    'labels' => $labels ,
                    'description' => 'Create Dimension' ,
                    'public' => true ,
                    'show_ui' => true ,
                    'menu_icon' => 'dashicons-editor-help' ,
                    'has_archive' => true ,
                    'menu_position' => 30 ,
                    'taxonomies' => array('post_tag') ,
                    'supports' => array( 'title', 'editor' , 'thumbnail' , 'author' , 'revisions' ) ,
                    'register_meta_box_cb' => 'dimension_metaboxes'
                  );
    register_post_type( 'dimension' , $args );
}

/**
 * Register Domain as Custom Post Type
 */
add_action("init" , "register_domain_post_type");

function register_domain_post_type(){
    $labels = array(
        "name" => _x("Assessment Domains", "post type general name", PLUGIN_DOMAIN),
        "singular_name" => _x("Assessment Domain", "post type singular name", PLUGIN_DOMAIN),
        "menu_name" => _x("Domains", "admin menu" , PLUGIN_DOMAIN) ,
        "name_admin_bar" => _x("Domains", "add new on admin bar", PLUGIN_DOMAIN),
        "add_new" => _x("Add New", "domain", PLUGIN_DOMAIN),
        "add_new_item" => __("Add New Assessment Domain", PLUGIN_DOMAIN),
        "new_item" => __("New Assessment Domain", PLUGIN_DOMAIN),
        "edit_item" => __("Edit Assesement Domain", PLUGIN_DOMAIN),
        "view_item" => __("View Assessment Domain", PLUGIN_DOMAIN),
        "all_items" => __("All Assessment Domains", PLUGIN_DOMAIN),
        "search_items" => __("Search Assessment Domain", PLUGIN_DOMAIN),
        "not_found" => __("No assessment domains found", PLUGIN_DOMAIN)
    );
    
    $arguments = array(
        "labels" => $labels ,
        "description" => "Create Domain" ,
        "public" => TRUE,
        "show_ui" => TRUE,
        "menu_icon" => "dashicons-editor-help" ,
        "has_archive" => TRUE,
        "menu_position" => 30,
        "taxonomies" => array("post_tag"),
        "supports" => array( "title", "editor" , "thumbnail" , "author" , "revisions" ) ,
        "register_meta_box_cb" => "dimension_metaboxes"
    );
    
    register_post_type("domain", $arguments);
}

//Remove Default Domain Post Type Menu Generated by WordPress
add_action('admin_menu', 'remove_default_domain_menus', 999);
function remove_default_domain_menus(){
    //Remove default domain menu
    remove_menu_page( 'edit.php?post_type=domain' );
    
    // remove tags
    remove_submenu_page( 'edit.php?post_type=domain', 'edit-tags.php?taxonomy=post_tag&amp;post_type=domain' );
    
    //Remove Default Add New
    remove_submenu_page( 'edit.php?post_type=domain', 'post-new.php?post_type=domain' );
}


/**
 * Domain Dimension Box Setup
 */
add_action("load-post.php", "domain_dimension_box_setup");
add_action("load-post-new.php", "domain_dimension_box_setup");

function domain_dimension_box_setup(){
    add_action( "add_meta_boxes", "domain_dimension_box");
}
/**
 * Domain Dimension Post Meta Box
 */
function domain_dimension_box(){
    // add_meta_box(id, title, callback, page, context, priority, callback_args)
    add_meta_box(
        "domain_dimension_box",
        __("Dimensions", PLUGIN_DOMAIN),
        "display_domain_dimension_box",
        "domain",
        "normal",
        "high"
    );
}

add_action("admin_footer", "new_dimension_js");
function new_dimension_js(){ ?>
    <script type="text/javascript" >
	jQuery(document).ready(function($) {
            tinyMCEPreInit.mceInit["editor-2"] = {"theme":"modern","skin":"lightgray","language":"en","formats":{"alignleft":[{"selector":"p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li","styles":{"textAlign":"left"},"deep":false,"remove":"none"},{"selector":"img,table,dl.wp-caption","classes":["alignleft"],"deep":false,"remove":"none"}],"aligncenter":[{"selector":"p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li","styles":{"textAlign":"center"},"deep":false,"remove":"none"},{"selector":"img,table,dl.wp-caption","classes":["aligncenter"],"deep":false,"remove":"none"}],"alignright":[{"selector":"p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li","styles":{"textAlign":"right"},"deep":false,"remove":"none"},{"selector":"img,table,dl.wp-caption","classes":["alignright"],"deep":false,"remove":"none"}],"strikethrough":{"inline":"del","deep":true,"split":true}},"relative_urls":false,"remove_script_host":false,"convert_urls":false,"browser_spellcheck":true,"fix_list_elements":true,"entities":"38,amp,60,lt,62,gt","entity_encoding":"raw","keep_styles":false,"cache_suffix":"wp-mce-4109-20150505","preview_styles":"font-family font-size font-weight font-style text-decoration text-transform","end_container_on_empty_block":true,"wpeditimage_disable_captions":false,"wpeditimage_html5_captions":true,"plugins":"charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wpview","content_css":"<?php echo site_url(); ?>/wp-includes/css/dashicons.min.css?ver=4.2.2,h…ost/gap-analysis/wp-content/themes/twentyfifteen/genericons/genericons.css","selector":"#editor-2","resize":"vertical","menubar":false,"wpautop":true,"indent":false,"toolbar1":"bold,italic,underline,blockquote,strikethrough,bullist,numlist,alignleft,aligncenter,alignright,undo,redo,link,unlink,fullscreen","toolbar2":"","toolbar3":"","toolbar4":"","tabfocus_elements":":prev,:next","body_class":"editor-2 post-type-domain post-status-auto-draft locale-en-us","wp_autoresize_on":true,"add_unload_trigger":false};
            console.log(tinyMCEPreInit.mceInit)
            console.log(JSON.stringify(tinyMCEPreInit.qtInit['editor-1']))
            tinyMCEPreInit.qtInit["editor-2"] = {"id":"editor-2","buttons":"strong,em,link,block,del,ins,img,ul,ol,li,code,more,close"}
            
            jQuery("#new-dimension").click(function() {    
                jQuery.post(ajaxurl, {
                    action: 'new_dimension'
                }, function(response) {
                    $('.dimensions').append(response);
                    tinymce.init(tinyMCEPreInit.mceInit['editor-2']);
                    quicktags({id : 'editor-2'});
                })
            })
	});
    </script>
<?php
}
add_action("wp_ajax_new_dimension", "new_dimension_callback");

function new_dimension_callback(){
    $n = 2;
    include(GAT_PATH . "gat_template/new_dimension.php");
    
    wp_die();
}

/**
 * Display Domain Dimension Box
 */
function display_domain_dimension_box(){
    include(GAT_PATH . "/gat_template/domain_dimension_box.php");
}
/**
 * Add reference to CSS for styling
 */
add_action( 'admin_init' , 'gat_admin_init' );

function gat_admin_init(){
    wp_enqueue_style('gat-admin' , plugins_url(PLUGIN_DOMAIN . "/css/admin.css"), false, 1.0);
    wp_enqueue_style('gat-fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', false, '4.3.0');
}
?>