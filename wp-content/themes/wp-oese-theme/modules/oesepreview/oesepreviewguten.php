<?php

namespace OESE_Preview;

define('OESEPREVIEW_I18N_DOMAIN', 'oesepreview');
define('OESEPREVIEW_ROOT', dirname(__FILE__));
define('OESEPREVIEW_BASE', plugin_basename(__FILE__));
define('OESEPREVIEW_KEEP_ORIGNAL',false);
define('OESEPREVIEW_PRESERVE_DATE',true);
define('OESEPREVIEW_PRESERVE_AUTHOR',true);

add_action('init', __NAMESPACE__.'\\init');
global $post;
function init() {
  
  //Filters and actions for admins who can edit the post
  if (is_admin() && user_can_oesepreview() && is_post_type_enabled()) {
    add_filter('display_post_states', __NAMESPACE__.'\\post_status_label', 10, 2);
    add_filter('post_row_actions', __NAMESPACE__.'\\admin_actions', 10, 2);
    add_filter('page_row_actions', __NAMESPACE__.'\\admin_actions', 10, 2);

    add_action('post_submitbox_start', __NAMESPACE__.'\\post_button');
    add_action('admin_action_oesepreview_create', __NAMESPACE__.'\\create');
    add_action('admin_notices', __NAMESPACE__.'\\notice');

    add_action('before_delete_post', __NAMESPACE__.'\\on_delete_post');
  }

  // For users who can publish.
  if (is_admin() && show_dashboard_widget() && user_can_publish_oesepreview()) {
    add_action('wp_dashboard_setup', __NAMESPACE__.'\\add_dashboard_widget');
  }

  // For Cron and users who can publish
  if (is_admin() && user_can_publish_oesepreview() || is_cron()) {
    if (!is_cron()) {
      add_action('acf/save_post', __NAMESPACE__.'\\acf_on_publish_post', 130, 1);
    }
    //add_action('transition_post_status', __NAMESPACE__.'\\on_publish_post', 10, 3);
  }
  /* add_action('admin_bar_menu', __NAMESPACE__.'\\admin_bar_item', 100); */
}

function wp_oese_preview_draft_enqueue(){
	wp_enqueue_style('wp-oese-preview-draft.css', get_template_directory_uri() . '/modules/oesepreview/admin.css', array() , null, 'all');
  wp_enqueue_script('wp-oese-preview-draft.js', get_template_directory_uri() . '/modules/oesepreview/admin.js' , array('jquery') , null, true);
  //wp_localize_script('wp-oese-preview-draft.js', 'wp_nn_preview_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  wp_localize_script('wp-oese-preview-draft.js', 'wp_nn_preview_ajax_object', array( 'ajaxurl' => get_template_directory_uri().'/modules/oesepreview/oesepreview_ajax.php'));
  wp_localize_script('wp-oese-preview-draft.js','wpoesePreviewGlobal', ['oeseIsGutenbergActive' => $GLOBALS['oese_is_gutenberg_active']]);
}
add_action('admin_enqueue_scripts', __NAMESPACE__.'\\wp_oese_preview_draft_enqueue');


// Action for ACF users. Will publish the oesepreview only if user_can_publish_oesepreview.
function acf_on_publish_post($post_id) {
  $post = get_post($post_id);
  $new_status = get_post_status($post_id);
  on_publish_post($new_status, '', $post, "ACF");
}

// Action for transition_post_status. Will publish the oesepreview only if user_can_publish_oesepreview.
function on_publish_post($new_status, $old_status, $post, $from="TPS") {

  // fix issue where oesepreviews were not published when ACF 5 was installed, but this post type didn't have any custom fields.
  if ($from=="TPS" && !is_cron() && is_acf_post()) {
    return;
  }


  if ($post && $new_status == 'publish') {
    $id = get_oesepreview_of($post);
    if ($id) {
      $original = get_post($id);
      if ($original) {
        publish($post, $original);
      }

    }
  }
}

function create() {
  $id = intval($_REQUEST['post']);

  // make sure the clicked link is a valid nonce. Make sure the user can oesepreview.
  if (user_can_oesepreview() && check_admin_referer('oesepreview-create-'.$id)) {
    if ($id) {
      $post = get_post($id);

      if ($post && is_create_enabled($post)) {
        $new_id = create_oesepreview($post, !get_oesepreview_of($post) || is_original_post($post));
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_id));
        exit;
      }
    }
  }

  // we fail if we don't redirect out.
  wp_die(__('Invalid Post ID', 'oesepreview'));
}


function transition_post_status_handler( $new_status, $old_status, $post ) {
  //echo '<script>console.log('.$new_status.');</script>';
  if($old_status !== $new_status){
    if($new_status == 'draft' || $new_status == 'pending'){
      //regenerate password if metadata does not exist or existing but empty.
      if(!metadata_exists('post', $post->ID, '_post_oesepreview_pwd') ||
         empty( get_post_meta( $post->ID, '_post_oesepreview_pwd', true ))){
           update_post_meta($post->ID, '_post_oesepreview_pwd', uniqid());      // generate password
      }
    }elseif($new_status == 'publish'){
      on_publish_post($new_status, $old_status, $post);
      //$new_id = copy_post($post, null, $post->ID);
      //delete_post_meta($new_id, '_post_oesepreview_pwd'); 
    }
  }
}
//add_action( 'transition_post_status', __NAMESPACE__.'\\transition_post_status_handler', 10, 3);



function create_oesepreview($post, $is_original=false) {
  $new_id = copy_post($post, null, $post->ID);
  update_post_meta($new_id, '_post_oesepreview_of', $post->ID);      // mark the new post as a variation of the old post.
  update_post_meta($new_id, '_post_oesepreview_pwd', uniqid());      // generate password
  update_post_meta($post->ID, '_post_oesepreview_id', $new_id);      // save the post ID of the new draft
  
  if ($is_original) {
    update_post_meta($post->ID, '_post_original', true);             // 
    delete_post_meta($new_id, '_post_original');                     // a oesepreview is never an original
    // only call action if new oesepreview created (not a backup)
    do_action('oesepreview_after_create_oesepreview', $post->ID, $new_id);
  } else {
    delete_post_meta($post->ID, '_post_original');
  }

  // new action has bad name in order to maintain backwards compatibility of action above.
  do_action('oesepreview_after_oesepreview_created', $new_id);

  return $new_id;
}

function publish($post, $original) {
  if (user_can_publish_oesepreview() || is_cron()) {

    if (keep_original_on_publish()) {
      create_oesepreview($original);    // keep a backup copy of the live post.
    }

    do_action('oesepreview_before_publish', $original->ID, $post->ID);

    delete_post_meta($post->ID, '_post_oesepreview_of');                       // remove the variation tag so the meta isn't copied
    delete_post_meta($post->ID, '_post_oesepreview_pwd');                      // remove the password so the meta isn't copied
    
    copy_post($post, $original, $original->post_parent);                    // copy the variation into the live post

    delete_post_meta($post->ID, '_post_original');                          // original tag is copied, but remove from source.

    wp_delete_post($post->ID, true);                                        // delete the variation

    do_action('oesepreview_after_publish', $original->ID);
    
    if (!is_ajax() && !is_cron()) {
      wp_redirect(admin_url('post.php?action=edit&post=' . $original->ID));   // take us back to the live post
      exit;
    }

    if (is_ajax()) {
      //echo "<script type='text/javascript'>location.reload();</script>";
    }

  }
}

// if we delete the original post, make its parent the new original.
function on_delete_post($post_id) {
  $post = get_post($post_id);
  $parent_id = get_oesepreview_of($post);
  if ($parent_id && is_original_post($post)) {
    update_post_meta($parent_id, '_post_original', true);
  }
}

function copy_post($post, $to=null, $parent_id=null, $status='draft') {
  if ($post->post_type == 'oesepreview') {
    return;
  }

  $author_id = $post->post_author;
  $post_status = $post->post_status;

  if (!$to) {
    $post_status = $status;
  }

  if ($to && is_original_author_preserved($to->ID)) {
    $author_id = $to->post_author;  // maintain original author.
  } else {
    $author = wp_get_current_user();
    
    // If we're creating a backup copy of the original and a cron task
    // is running at this point, the current author ID will be empty,
    // so don't overwrite the $author_id of the given $post.
    if (!empty($author->ID)) {
      $author_id = $author->ID;
    }
  }
  
  $_ctnt = $post->post_content;
  preg_match_all('/<!-- wp:cgb\/block-oese-shortcodes-block(.*?)-->/', $_ctnt, $blocks);  
  foreach($blocks[1] as $shrtcd_block) {
      $_str_original = trim($shrtcd_block," ");
      $_a = array('\u0022','\u003c','\u003e');
      $_b = array('\\\\u0022','\\\\u003c','\\\\u003e');
      $_str_replacement = str_replace($_a,$_b,trim($_str_original," "));     
      $_ctnt = str_replace($_str_original,$_str_replacement,$_ctnt);
  }
  
  $data = array(
    'menu_order' => $post->menu_order,
    'comment_status' => $post->comment_status,
    'ping_status' => $post->ping_status,
    'post_author' => $author_id,
    'post_content' => $_ctnt,
    'post_excerpt' => $post->post_excerpt,
    'post_mime_type' => $post->post_mime_type,
    'post_parent' => !$parent_id ? $post->post_parent : $parent_id,
    'post_password' => $post->post_password,
    //'post_status' => $post_status,
    'post_title' => $post->post_title,
    'post_type' => $post->post_type,
    'post_date' => $post->post_date,
    'post_date_gmt' => get_gmt_from_date($post->post_date)
  );


  if ($to) {
    $data['ID'] = $to->ID;
    $new_id = $to->ID;

    // maintain original date. Fixes scheduled oesepreviews overwriting the date.
    if (is_post_date_preserved($to->ID)) {
      $data['post_date'] = $to->post_date;
      $data['post_date_gmt'] = get_gmt_from_date($to->post_date);
    }

    // fixes PR #4
    if (is_cron()) {
      kses_remove_filters();
    }

    if (is_acf_post() && is_acf_fields_different($to, $post)) {
      // this will force WP to create a new oesepreview. 
      add_filter('wp_save_post_oesepreview_post_has_changed', '__return_true');
    }

    $oesepreview_before = get_latest_wp_oesepreview($new_id);

    wp_update_post($data);

    $oesepreview_after = get_latest_wp_oesepreview($new_id);

    if (is_wp_oesepreview_different($oesepreview_before, $oesepreview_after) && $oesepreview_after) {
      copy_post_meta_info($oesepreview_after->ID, $post);  
    }

    if (is_cron()) {
      kses_init_filters();
    }
  } else {
    $new_id = wp_insert_post($data);
  }

  copy_post_taxonomies($new_id, $post);
  // apply oesepreviewed post_meta to the original post.
  copy_post_meta_info($new_id, $post);

  // Let others know a copy has been made
  do_action('oesepreview_after_copy_post', $new_id, $post);
 
  return $new_id;
}

function copy_post_taxonomies($new_id, $post) {
  global $wpdb;

  if (isset($wpdb->terms)) {
    // Clear default category (added by wp_insert_post)
    wp_set_object_terms($new_id, NULL, 'category');

    $taxonomies = get_object_taxonomies($post->post_type);

    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post->ID, $taxonomy, array('orderby' => 'term_order'));
      $terms = array();

      for ($i=0; $i<count($post_terms); $i++) {
        $terms[] = $post_terms[$i]->slug;
      }

      wp_set_object_terms($new_id, $terms, $taxonomy);
    }
  }
}

function clear_post_meta($id) {
  $meta_keys = get_post_custom_keys($id);
  if (!empty($meta_keys)) {
    foreach ($meta_keys as $meta_key) {
      delete_metadata('post', $id, $meta_key);
    }
  }
}

function copy_post_meta_info($new_id, $post) {
  clear_post_meta($new_id);

  $meta_keys = get_post_custom_keys($post->ID);

  if (!empty($meta_keys)) {
    foreach ($meta_keys as $meta_key) {
      $meta_values = get_post_custom_values($meta_key, $post->ID);
      foreach ($meta_values as $meta_value) {
        $meta_value = maybe_unserialize($meta_value);
        add_metadata('post', $new_id, $meta_key, $meta_value);
      }
    }
  }
}

function is_acf_fields_different($a, $b) {
  $afields = get_field_objects($a->ID, array('format_value' => false));
  $bfields = get_field_objects($b->ID, array('format_value' => false));
  return $afields != $bfields;
}

// -- Admin UI (buttons, links, etc)

// Action for post_submitbox_start which is only added if user_can_oesepreview
function post_button() {
  global $post;
  $parent = get_parent_post($post);
  if(get_post_type() == 'page'){
    $_getparam = "page_id";
  }elseif(get_post_type() == 'post'){
    $_getparam = "p";
  }
  
  if (!$parent): ?>
    <?php //echo get_post_status($post->ID); ?>
    <?php if(get_post_status($post->ID) == 'publish'){ ?>
      <?php if($post->post_type == 'post' || $post->post_type == 'page'){ ?>
        <div style="text-align: right; margin-bottom: 10px;">
          <a class="button"
            href="<?php echo get_create_link($post) ?>"><?php echo get_create_button_text(); ?>
          </a>
        </div>
      <?php } ?>
    <?php }elseif(get_post_status($post->ID) == 'draft' || get_post_status($post->ID) == 'pending'){ ?>
      <div class="oese-preview-url-wrapper">
        <strong><em>Preview URL:</em></strong>
        <input id="oese-preview-url-input" type="text" value="<?php echo get_bloginfo('url').'?'.$_getparam.'='.$post->ID.'&preview=true&key='.get_post_meta($post->ID, '_post_oesepreview_pwd', true) ?>" />
        <div class="oese-preview-url-copy button" onclick="oesePreviewDraftCopyToClipboard()">Copy URL</div>
      </div>
    <?php } ?>
  <?php else: ?>
    <div class="oese-preview-url-wrapper">
      
      <strong><em>Preview URL:</em></strong>
      <input id="oese-preview-url-input" type="text" value="<?php echo get_bloginfo('url').'?'.$_getparam.'='.$post->ID.'&preview=true&key='.get_post_meta($post->ID, '_post_oesepreview_pwd', true) ?>" />
      <div class="oese-preview-url-copy button" onclick="oesePreviewDraftCopyToClipboard()">Copy URL</div>
    </div>
    <div id="oese-preview-draft-publish-warning"><em><?php echo sprintf(__('<strong style="font-size:14px;color:red;">WARNING</strong>: Publishing this preview will overwrite %s.', 'oesepreview'), get_parent_editlink($parent, __('its original.', 'oesepreview')). '<br>Please use "Save Draft" if you only wish to save this preview for review')?></em></div>
  <?php endif;
}

// Filter for post_row_actions/page_row_actions which is only added if user_can_oesepreview
function admin_actions($actions, $post) {
  if (is_create_enabled($post)) {
    
    if(metadata_exists('post', $post->ID, '_post_oesepreview_id')){
      $_oesepreview_id = get_post_meta($post->ID, '_post_oesepreview_id', true);
      
      if( is_null(get_post($_oesepreview_id))){
        $lnk_txt = get_create_button_text($post);
      }else{
        $lnk_txt = 'Edit Preview';
      }
    }else{
      $lnk_txt = get_create_button_text($post);
    } 
    
    $actions['create_oesepreview'] = '<a href="'.get_create_link($post).'" title="'
      . esc_attr(__("Create a Revision", 'oesepreview'))
      . '">' . $lnk_txt . '</a>';
  }
  return $actions;
}

// Filter for display_post_states which is only added if user_can_oesepreview
function post_status_label($states, $post) {
  if (!empty($post) && get_oesepreview_of($post)) {
    $label = is_original_post($post) ? __('Preview Backup', 'oesepreview') : __('Preview', 'oesepreview');
    $label = apply_filters('oesepreview_post_status_label', $label);
    array_unshift($states, $label);
  }
  return $states;
}

function notice() {
  global $post;
  $parent = get_parent_post($post);
  $screen = get_current_screen();
  if ($screen->base == 'post' && $parent):
  ?>
  <div class="notice notice-warning">
      <p><?php echo sprintf(__('Currently editing a preview of %s. Publishing this post will overwrite it.', 'oesepreview'), get_parent_permalink($parent)); ?></p>
  </div>
  <?php
  endif;
}

// Add a dashboard widget showing posts needing review
function add_dashboard_widget() {
  wp_add_dashboard_widget(
    'oesepreview-posts-needing-review',    // ID of the widget.
    __('Revisionized Posts Needing Review', 'oesepreview'),                // Title of the widget.
    __NAMESPACE__.'\\do_dashboard_widget'  // Callback.
  );
}

// Echo the content of the dashboard widget.
function do_dashboard_widget() {
  $posts = get_posts(array(
    'post_type'   => 'any',
    'post_status' => 'pending',
    'meta_query'  => array(
      array(
        'key'     => '_post_oesepreview_of',
        'compare' => 'EXISTS',
        )
      )
    ));

  if (empty($posts)) {
    _e('No posts need reviewed at this time!', 'oesepreview');
  }

  echo '<ul>';

  foreach ($posts as $post) {
    printf('<li><a href="%s">%s</a> - %s</li>',
      get_edit_post_link($post->ID),
      get_the_title($post->ID),
      get_the_author_meta('nicename', $post->post_author)
    );
  }

  echo '</ul>';
}

function admin_bar_item($admin_bar) {
  global $post;
  if (!empty($post) && is_post_type_enabled() && is_create_enabled($post)) {
    $admin_bar->add_menu(array(
      'id' => 'oesepreview',
      'title' => get_create_button_text(),
      'href' => get_create_link($post),
      'meta' => array(
        'title' => esc_attr(__("Create a Revision", 'oesepreview')),
      ),
    ));
  }
}

// -- Helpers

function user_can_oesepreview() {
  return apply_filters('oesepreview_user_can_oesepreview', current_user_can('edit_posts') || current_user_can('edit_pages'));
}

function user_can_publish_oesepreview() {
  return apply_filters('oesepreview_user_can_publish_oesepreview', current_user_can('publish_posts') || current_user_can('publish_pages'));
}

function keep_original_on_publish() {
  //return apply_filters('oesepreview_keep_original_on_publish', true);
  return OESEPREVIEW_KEEP_ORIGNAL;
}

function is_cron() {
  return defined('DOING_CRON') && DOING_CRON;
}

function is_ajax() {
  return defined('DOING_AJAX') && DOING_AJAX;
}

function is_post_type_enabled() {
  $type = get_current_post_type();
  $excluded = apply_filters('oesepreview_exclude_post_types', array('acf', 'attachment'));
  return empty($type) || !in_array($type, $excluded);
}

function is_create_enabled($post) {
  $is_enabled = !get_oesepreview_of($post) && current_user_can('edit_post', $post->ID);
  return apply_filters('oesepreview_is_create_enabled', $is_enabled, $post);
}

function is_original_post($post) {
  return get_post_meta($post->ID, '_post_original', true);
}

function is_acf_post() {
  return has_action('acf/save_post') && (!empty($_POST['acf']) || !empty($_POST['fields']));
}

function is_post_date_preserved($id) {
  //return apply_filters('oesepreview_preserve_post_date', true, $id) === true;
  return OESEPREVIEW_PRESERVE_DATE;
}

function is_original_author_preserved($id) {
  //return apply_filters('oesepreview_preserve_author', true, $id) === true; 
  return OESEPREVIEW_PRESERVE_AUTHOR  ; 
}

function show_dashboard_widget() {
  return apply_filters('oesepreview_show_dashboard_widget', false);
}

function get_oesepreview_of($post) {
  return get_post_meta($post->ID, '_post_oesepreview_of', true);
}

function get_create_link($post) {
  if(metadata_exists('post', $post->ID, '_post_oesepreview_id')){
    $_oesepreview_id = get_post_meta($post->ID, '_post_oesepreview_id', true);
    if( is_null(get_post($_oesepreview_id))){
      $_url = wp_nonce_url(admin_url("admin.php?action=oesepreview_create&post=".$post->ID), 'oesepreview-create-'.$post->ID);
    }else{
      $_url = wp_nonce_url(admin_url("post.php?action=edit&post=".get_post_meta($post->ID, "_post_oesepreview_id", true)), 'oesepreview-create-'.$post->ID);
    }
  }else{
    $_url = wp_nonce_url(admin_url("admin.php?action=oesepreview_create&post=".$post->ID), 'oesepreview-create-'.$post->ID);
  }
    return $_url;
}

function get_create_button_text($post) {
  //global $post;
  $_btn='';
  if(metadata_exists('post', $post->ID, '_post_oesepreview_id')){
    $_oesepreview_id = get_post_meta($post->ID, '_post_oesepreview_id', true);
    if( is_null(get_post($_oesepreview_id))){
      if($post->post_type == 'page' || $post->post_type == 'post'){
        $_btn = apply_filters('oesepreview_create_oesepreview_button_text', __('Create Preview', 'oesepreview'));
      }
    }else{
      $_btn = apply_filters('oesepreview_create_oesepreview_button_text', __('Edit Preview', 'oesepreview'));
    }
  }else{
    if($post->post_type == 'page' || $post->post_type == 'post'){
      $_btn = apply_filters('oesepreview_create_oesepreview_button_text', __('Create Preview', 'oesepreview'));
    }
  }
  
  //return apply_filters('oesepreview_create_oesepreview_button_text', __('Revise', 'oesepreview'));
  return $_btn;
}

function get_parent_editlink($parent, $s=null) {
  return sprintf('<a href="%s">%s</a>', get_edit_post_link($parent->ID), $s ? $s : $parent->post_title);
}

function get_parent_permalink($parent) {
  return sprintf('<a href="%s" target="_blank">%s</a>', get_permalink($parent->ID), $parent->post_title);
}

function get_parent_post($post) {
  $id = $post ? get_oesepreview_of($post) : false;
  return $id ? get_post($id) : false;
}

function get_current_post_type() {
  global $post, $typenow, $current_screen, $pagenow;
  $type = null;

  if ($post && $post->post_type) {
    $type = $post->post_type;
  } else if ($typenow) {
    $type = $typenow;
  } else if ($current_screen && $current_screen->post_type) {
    $type = $current_screen->post_type;
  } else if (isset($_REQUEST['post_type'])) {
    $type = sanitize_key($_REQUEST['post_type']);
  } else if (isset($_REQUEST['post'])) {
    $type = get_post_type($_REQUEST['post']);
  } else if ($pagenow == 'edit.php') {
    $type = 'post';
  }

  return $type;
}

function get_latest_wp_oesepreview($id) {
  $oesepreviews = wp_get_post_revisions($id);
  return !empty($oesepreviews) ? current($oesepreviews) : null;
}

function is_wp_oesepreview_different($a, $b) {
  return $a && !$b || !$a && $b || $a && $b && $a->ID != $b->ID;
}


add_filter( 'posts_results', __NAMESPACE__.'\\set_query_to_draft', null, 2 );
function set_query_to_draft( $posts, $query ) {
    $_pwd = '';

    if(isset($_GET['page_id'])){ //page
      $_pwd = get_post_meta($_GET['page_id'], '_post_oesepreview_pwd', true);
    }elseif(isset($_GET['p'])){
      $_pwd = get_post_meta($_GET['p'], '_post_oesepreview_pwd', true);
    }
    if ( sizeof( $posts ) != 1 )
        return $posts;

    $post_status_obj = get_post_status_object(get_post_status( $posts[0]));

    if ( !$post_status_obj->name == 'draft' )
        return $posts;
    
    if(isset($_GET['key'])){
      if ( $_GET['key'] != $_pwd )
        return $posts;
    }else{
        return $posts;
    }
    
    $query->_draft_post = $posts;

    add_filter( 'the_posts', __NAMESPACE__.'\\show_draft_post', null, 2 );
}

function show_draft_post( $posts, $query ) {
    remove_filter( 'the_posts', 'show_draft_post', null, 2 );
    return $query->_draft_post;
}

/*
add_action('wp_trash_post', __NAMESPACE__.'\\on_oesepreview_trash_post');
function on_oesepreview_trash_post(){
  $_postid = $_GET['post'];
  $_revi_post_id = get_post($_postid);
  $_orig_post_id = get_oesepreview_of($_revi_post_id);
  $_oesepreview_id = get_post_meta($_orig_post_id, '_post_oesepreview_id', true);
  delete_post_meta($_orig_post_id, '_post_oesepreview_id');
  //die($_orig_post_id);
}
*/




add_action('rest_api_init', function () {
  register_rest_route( 'wpnnpreview/v2', 'elementquery', 
    array(
    'methods' => 'GET', 
    'callback' => __NAMESPACE__ .'\\wpnnpreview_element_query',
    'permission_callback' => '__return_true'
    )
  );
});

function wpnnpreview_element_query(){
  $post = get_post($_GET['pid']);
  $nstt = $_GET['new'];
  $parent = get_parent_post($post);
  if($post->post_type == 'page'){
    $_getparam = "page_id";
  }elseif($post->post_type == 'post'){
    $_getparam = "p";
  }
  $_isparent = (get_oesepreview_of($post))?'false':'true';
  $_status = get_post_status($post->ID);
  $_ret = array();
  $_htm = '';
  if (!$parent){ // Parent type of Post
    if($nstt == 'publish'){
      if($post->post_type == 'post' || $post->post_type == 'page'){
          
        $_htm .= '<div class="oese-preview-url-wrapper gutenberg components-button" isparent="'.$_isparent.'" >';
          $_htm .= '<a class="button" href="'.get_create_link($post).'">'.get_create_button_text($post).'</a>';
        $_htm .= '</div>';
        
      }
    }elseif($nstt == 'draft' || $nstt == 'pending'){
        //Set password if not yet set
        if(!metadata_exists('post', $post->ID, '_post_oesepreview_pwd') ||
           empty( get_post_meta( $post->ID, '_post_oesepreview_pwd', true ))){
             update_post_meta($post->ID, '_post_oesepreview_pwd', uniqid());      // generate password
        }
      
        $_htm .= '<div class="oese-preview-url-wrapper gutenberg '.$post->ID.'" isparent="'.$_isparent.'">';
          $_htm .= '<strong><em>Preview URL:</em></strong>';
          $_htm .= '<input id="oese-preview-url-input" type="text" value="'.get_bloginfo('url').'?'.$_getparam.'='.$post->ID.'&preview=true&key='.get_post_meta( $post->ID, '_post_oesepreview_pwd', true ).'" />';
          $_htm .= '<div class="oese-preview-url-copy button" onclick="oesePreviewDraftCopyToClipboard()">Copy URL</div>';
        $_htm .= '</div>';
    
    }
  }else{ //Preview Type Of Post
    
    $_htm .= '<div class="components-panel__row oese-preview-url-wrapper gutenberg" isparent="'.$_isparent.'">';
      $_htm .= '<strong><em>Preview URL:</em></strong>';
      $_htm .= '<input id="oese-preview-url-input" type="text" value="'.get_bloginfo('url').'?'.$_getparam.'='.$post->ID.'&preview=true&key='.get_post_meta($post->ID, '_post_oesepreview_pwd', true).'" />';
      $_htm .= '<div class="oese-preview-url-copy button" onclick="oesePreviewDraftCopyToClipboard()">Copy URL</div>';
      $_htm .= '<div id="oese-preview-draft-publish-warning">';
      $_htm .= '<em>';
        $_htm .= '<strong style="font-size:14px;color:red;">WARNING</strong>';
        $_htm .= ': Publishing this preview will overwrite '.get_parent_editlink($parent, "its original.").'<br>Please use "Save Draft" if you only wish to save this preview for review)';
      $_htm .= '</em>';
      $_htm .= '</div>';
    $_htm .= '</div>';
    
  }
  $output = ob_get_clean( );
  
  $_ret['themedir'] = get_template_directory_uri();
  $_ret['isparent'] = $_isparent;
  $_ret['status'] = $nstt;
  $_ret['html'] = $_htm;
  return $_ret;
}









/* GUTENBERG STARTS */
function wpnnPostButtonGuten() {
  $post = get_post($_POST['pid']);
  $parent = get_parent_post($post);
  if($post->post_type == 'page'){
    $_getparam = "page_id";
  }elseif($post->post_type == 'post'){
    $_getparam = "p";
  }
  $_isparent = (get_oesepreview_of($post))?'false':'true';
  $_ret = array();
  ob_start( );
  if (!$parent){
    if(get_post_status($post->ID) == 'publish'){
      if($post->post_type == 'post' || $post->post_type == 'page'){
        ?>
        <div class="oese-preview-url-wrapper gutenberg" isparent="<?php echo $_isparent ?>" style="text-align: right; margin-bottom: 10px;">
          <a class="button" href="<?php echo get_create_link($post) ?>"><?php echo get_create_button_text($post); ?></a>
        </div>
        <?php
      }
    }elseif(get_post_status($post->ID) == 'draft' || get_post_status($post->ID) == 'pending'){
      ?>
        <div class="oese-preview-url-wrapper gutenberg" isparent="<?php echo $_isparent ?>">
          <strong><em>Preview URL:</em></strong>
          <input id="oese-preview-url-input" type="text" value="<?php echo get_bloginfo('url').'?'.$_getparam.'='.$post->ID.'&preview=true&key='.get_post_meta($post->ID, '_post_oesepreview_pwd', true) ?>" />
          <div class="oese-preview-url-copy button" onclick="oesePreviewDraftCopyToClipboard()">Copy URL</div>
        </div>
      <?php
    }
  }else{ 
    ?>
    <div class="oese-preview-url-wrapper gutenberg" isparent="<?php echo $_isparent ?>">
      <strong><em>Preview URL:</em></strong>
      <input id="oese-preview-url-input" type="text" value="<?php echo get_bloginfo('url').'?'.$_getparam.'='.$post->ID.'&preview=true&key='.get_post_meta($post->ID, '_post_oesepreview_pwd', true) ?>" />
      <div class="oese-preview-url-copy button" onclick="oesePreviewDraftCopyToClipboard()">Copy URL</div>
    </div>
    <div id="oese-preview-draft-publish-warning"><em><?php echo sprintf(__('<strong style="font-size:14px;color:red;">WARNING</strong>: Publishing this preview will overwrite %s.', 'oesepreview'), get_parent_editlink($parent, __('its original.', 'oesepreview')). '<br>Please use "Save Draft" if you only wish to save this preview for review')?></em></div>
    <?php
  }
  $output = ob_get_clean( );
  
  $_ret['isparent'] = $_isparent;
  $_ret['data'] = $output;
  echo json_encode($_ret);
  die();
}

add_action('wp_ajax_wpnnPostButtonGuten', 'OESE_Preview\wpnnPostButtonGuten');
add_action('wp_ajax_nopriv_wpnnPostButtonGuten', 'OESE_Preview\wpnnPostButtonGuten');
//$_parent_post_id = get_oesepreview_of($post);


function wpnnTransitionHandlerGuten() {
    $old_status = $_GET['old'];
    $new_status = $_GET['new'];
    $post = get_post($_GET['pid']);
    $_parent_post_id = get_oesepreview_of($post);
  if($old_status !== $new_status){
    if($new_status == 'draft' || $new_status == 'pending'){
      //regenerate password if metadata does not exist or existing but empty.
      if(!metadata_exists('post', $post->ID, '_post_oesepreview_pwd') ||
         empty( get_post_meta( $post->ID, '_post_oesepreview_pwd', true ))){
           update_post_meta($post->ID, '_post_oesepreview_pwd', uniqid());      // generate password
      }
    }elseif($new_status == 'publish'){
      on_publish_post($new_status, $old_status, $post);
      //header("Location: ".get_site_url()."/wp-admin/post.php?action=edit&post=".$_parent_post_id);
      wp_redirect(get_site_url()."/wp-admin/post.php?action=edit&post=".$_parent_post_id);
      die();
      //$new_id = copy_post($post, null, $post->ID);
      //delete_post_meta($new_id, '_post_oesepreview_pwd'); 
    }
  }
  
  echo $_parent_post_id;
  die();
  
}
//add_action( 'transition_post_status', __NAMESPACE__.'\\transition_post_status_handler', 10, 3);
add_action('wp_ajax_wpnnTransitionHandlerGuten', 'OESE_Preview\wpnnTransitionHandlerGuten',0);
add_action('wp_ajax_nopriv_wpnnTransitionHandlerGuten', 'OESE_Preview\wpnnTransitionHandlerGuten',0);



/*GUTEN ENDS*/