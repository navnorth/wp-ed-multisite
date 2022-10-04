<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

function oet_dynamic_sidebar_enqueue_scripts()
{
    global $post;
    if (is_object($post) && $post->post_type == "page") {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js' );
        wp_enqueue_style( 'bootstrap-css',get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
        wp_enqueue_style( 'fontawesome-css',get_stylesheet_directory_uri() . '/css/font-awesome.min.css' );
        wp_enqueue_style( 'sidebar-css',get_stylesheet_directory_uri() . '/css/dynamic-sidebar.css' );
        wp_enqueue_script( 'sidebar-js', get_stylesheet_directory_uri() . '/js/dynamic-sidebar.js', array('jquery', 'wp-color-picker') );
        wp_localize_script( 'sidebar-js', 'oet_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }
}
add_action( 'admin_enqueue_scripts', 'oet_dynamic_sidebar_enqueue_scripts' );

function add_dynamic_sidebar_preview_modal(){
    if (get_field('oet_sidebar')){
        include_once( get_stylesheet_directory(). '/inner-templates/popups/dynamic_sidebar_preview.php');
    }
}
add_action( 'admin_footer', 'add_dynamic_sidebar_preview_modal' );

/**
 * Add Sidebar Section
 */
add_action('wp_ajax_oet_add_sidebar_section_callback', 'oet_add_sidebar_section_callback');
add_action('wp_ajax_nopriv_oet_add_sidebar_section_callback', 'oet_add_sidebar_section_callback');

function oet_add_sidebar_section_callback() {
    $totalSections = isset($_REQUEST['row_id']) ? $_REQUEST['row_id'] : '25';
    
    $content = '<div class="panel panel-default oet-sidebar-section-wrapper" id="oet_sidebar_section_'.$totalSections.'">
                    <div class="panel-heading">
                        <h3 class="panel-title">Section '.$totalSections.'</h3>
                        <span class="oet-sortable-handle">
                            <i class="fa fa-arrow-down sidebar-section-reorder-down" aria-hidden="true"></i>
                            <i class="fa fa-arrow-up sidebar-section-reorder-up" aria-hidden="true"></i>
                        </span>
                        <span class="btn btn-danger btn-sm oet-remove-sidebar-section" title="Delete"><i class="fa fa-trash-o"></i> </span>
                        <span class="oet-preview-section btn btn-sm btn-info" title="Preview"><i class="fa fa-eye" aria-hidden="true"></i></span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="oet_sidebar_section_title">Title:</label>
                            <input type="text" class="form-control oet-sidebar-section-title" name="oet_sidebar_section[title][]" placeholder = "Section Title">
                        </div>
                        <div class="form-group">
                            <label for="oet_sidebar_section_icon">Icon:</label>
                            <select name="oet_sidebar_section[icon][]" class="form-control oet-sidebar-section-icon">
                                <option value="fa-star">Star</option>
                                <option value="fa-compress">Compress</option>
                                <option value="fa-cogs">Cogs</option>
                                <option value="fa-cog">Cog</option>
                                <option value="fa-globe">Globe</option>
                                <option value="fa-power-off">Power Off</option>
                                <option value="fa-file-o">File</option>
                                <option value="fa-wifi">WiFi</option>
                                <option value="fa-check">Check</option>
                                <option value="fa-comment-o">Comment</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="oet_sidebar_section_type">Content Type:</label>
                            <select name="oet_sidebar_section[type][]" class="form-control oet-sidebar-section-type">
                                <option value="html">Free-form HTML</option>
                                <option value="link">Page Link</option>
                                <option value="image">Image</option>
                                <option value="related">Related Content</option>
                                <option value="youtube">YouTube Video</option>
                                <option value="story">Story</option>
                                <option value="medium">Medium Post</option>
                            </select>
                        </div>
                        <div class="form-group oet-related-content-helper hidden">
                            <em>Automatic listing of related content based on matching categories and tags from this page.</em>
                        </div>
                        <div class="form-group oet-content-sections">
                            <label for="oet_sidebar_section_html">HTML Content:</label>';
                            ob_start(); // Start Output buffer
                            wp_editor( '',
                                'oet-sidebar-section-'.($totalSections),
                                $settings = array(
                                    'textarea_name' => 'oet_sidebar_section[content][html]['.$totalSections.'][]',
                                    'media_buttons' => true,
                                    'textarea_rows' => 6,
                                    'drag_drop_upload' => true,
                                    'teeny' => true,
                                    'tinymce' => true,
                                    'quicktags' => true,
                                    'editor_class' => 'oet-wp-editor',
                                    'default_editor' => 'html',
                                    'editor_class' => 'oet-sidebar-section-html-content-editor'
                                )
                            );
                $content .= ob_get_clean();
                $content .=  '</div>
                    </div>
                </div>';      
    
    echo $content;
    exit();
}


/**
 * Add Content Section By Type
 */
add_action('wp_ajax_oet_sidebar_content_type_callback', 'oet_sidebar_content_type_callback');
add_action('wp_ajax_nopriv_oet_sidebar_content_type_callback', 'oet_sidebar_content_type_callback');

function oet_sidebar_content_type_callback() {
    $totalSections = isset($_REQUEST['row_id']) ? $_REQUEST['row_id'] : '25';
    $type = isset($_REQUEST['type']) ? $_REQUEST['type']: "";
    $content = get_fields_from_content_type($type, $totalSections);
    echo $content;
    exit();
}

/** Get Fields From Selected Content Type **/
function get_fields_from_content_type($type, $rowid, $value=""){
    $fields_section = '';
    switch ($type){
        case "html":
            // Free Form HTML
            $html = $value[0];
            $fields_section = '<div class="form-group oet-content-sections">
                        <label for="oet_sidebar_section_html">HTML Content:</label>';
                        ob_start(); // Start Output buffer
                        wp_editor( $html,
                            'oet-sidebar-section-'.($rowid),
                            $settings = array(
                                'textarea_name' => 'oet_sidebar_section[content][html]['.$rowid.'][]',
                                'media_buttons' => true,
                                'textarea_rows' => 6,
                                'drag_drop_upload' => true,
                                'teeny' => true,
                                'tinymce' => true,
                                'quicktags' => true,
                                'editor_class' => 'oet-wp-editor',
                                'default_editor' => 'html',
                                'editor_class' => 'oet-sidebar-section-html-content-editor'
                            )
                        );
            $fields_section .= ob_get_clean();
            $fields_section .=  '</div>';
            break;
        case "link":
        case "image":
        case "youtube":
        case "story":
            $contents = "";
            $wType = ucwords($type);
            if ($type=="youtube")
                $wType = "YouTube";
            if (!empty($value)){
                $contents = $value;
                $count = count($contents['title']);
                $disabled = "";
                if ($count==1)
                    $disabled = ' disabled="disabled"';
                $val = ""; $mod = "";
                for($index=0;$index<$count;$index++){
                    $title = $contents['title'][$index];
                    $description = $contents['description'][$index];
                    if ($type=="link" || $type=="image" || $type=="medium"){
                        $val = $contents['url'][$index];
                    }elseif ($type=="youtube"){
                        $val = array('pid'=>$contents['pid'][$index], 'id'=>$contents['id'][$index]);
                        $mod = (isset($contents['modal'][$index]) && $contents['modal'][$index] == 1 )? 1: 0;
                    }elseif ($type=="story"){
                        $val = $contents['story'][$index];
                    }
                    $rowid = $index + 1;
                    $fields_section .= '<div class="panel panel-default oet-sidebar-section-type-wrapper" id="oet_sidebar_section_type_'.$rowid.'">
                        <div class="panel-heading">
                            <h3 class="panel-title">'.$wType.' '.$rowid.'</h3>
                            <span class="oet-sortable-handle">
                                <i class="fa fa-arrow-down sidebar-section-'.$type.'-reorder-down" aria-hidden="true"></i>
                                <i class="fa fa-arrow-up sidebar-section-'.$type.'-reorder-up" aria-hidden="true"></i>
                            </span>
                            <span class="btn btn-danger btn-sm oet-remove-sidebar-section-content" title="Delete"'.$disabled.'><i class="fa fa-trash-o"></i> </span>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="oet_sidebar_section_content_title">Title:</label>
                                <input type="text" class="form-control oet-sidebar-section-'.$type.'-title" name="oet_sidebar_section[content]['.$type.'][title][]" placeholder = "Content Title" value="'.$title.'">
                            </div>
                            <div class="form-group">
                                <label for="oet_sidebar_section_content_html">Short Description:</label>';
                                ob_start(); // Start Output buffer
                                wp_editor( $description,
                                    'oet-sidebar-section-'.$type.'-'.$rowid,
                                    $settings = array(
                                        'textarea_name' => 'oet_sidebar_section[content]['.$type.'][description][]',
                                        'media_buttons' => true,
                                        'textarea_rows' => 6,
                                        'drag_drop_upload' => true,
                                        'teeny' => true,
                                        'tinymce' => true,
                                        'quicktags' => true,
                                        'editor_class' => 'oet-wp-editor',
                                        'default_editor' => 'html',
                                        'editor_class' => 'oet-sidebar-section-'.$type.'-description'
                                    )
                                );
                                $fields_section .= ob_get_clean();
                    $fields_section .= '</div>
                            <div class="form-group oet-content-sections">';
                    $fields_section .= generatecontentfieldtype($type, $val, $mod);
                    $fields_section .= '</div>
                        </div>
                    </div>';
                }
                if ($count>0){
                    $fields_section .= '<div class="form-group button-row-content">
                        <button type="button" class="btn btn-default oet-add-sidebar-section-content"><i class="fa fa-plus"></i> Add More '.ucwords($type).'</button>
                    </div>';
                }
            } else {
                $fields_section = '<div class="panel panel-default oet-sidebar-section-type-wrapper" id="oet_sidebar_section_type_'.$rowid.'">
                    <div class="panel-heading">
                        <h3 class="panel-title">'.$wType.' '.$rowid.'</h3>
                        <span class="oet-sortable-handle">
                            <i class="fa fa-arrow-down sidebar-section-'.$type.'-reorder-down" aria-hidden="true"></i>
                            <i class="fa fa-arrow-up sidebar-section-'.$type.'-reorder-up" aria-hidden="true"></i>
                        </span>
                        <span class="btn btn-danger btn-sm oet-remove-sidebar-section-content" title="Delete"><i class="fa fa-trash-o"></i> </span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="oet_sidebar_section_content_title">Title:</label>
                            <input type="text" class="form-control  oet-sidebar-section-'.$type.'-title" name="oet_sidebar_section[content]['.$type.'][title][]" placeholder = "Content Title">
                        </div>
                        <div class="form-group">
                            <label for="oet_sidebar_section_content_html">Short Description:</label>';
                            ob_start(); // Start Output buffer
                            wp_editor( '',
                                'oet-sidebar-section-type-'.$rowid,
                                $settings = array(
                                    'textarea_name' => 'oet_sidebar_section[content]['.$type.'][description][]',
                                    'media_buttons' => true,
                                    'textarea_rows' => 6,
                                    'drag_drop_upload' => true,
                                    'teeny' => true,
                                    'tinymce' => true,
                                    'quicktags' => true,
                                    'editor_class' => 'oet-wp-editor',
                                    'default_editor' => 'html',
                                    'editor_class' => 'oet-sidebar-section-'.$type.'-description'
                                )
                            );
                            $fields_section .= ob_get_clean();
                $fields_section .= '</div>
                        <div class="form-group oet-content-sections">';
                $fields_section .= generatecontentfieldtype($type);
                $fields_section .= '</div>
                    </div>
                </div>';
                if ($rowid==1) {
                $fields_section .= '<div class="form-group button-row-content">
                        <button type="button" class="btn btn-default oet-add-sidebar-section-content"><i class="fa fa-plus"></i> Add More '.$wType.'</button>
                    </div>';
                }
            }
            break;
        case "medium":
            $contents = "";
            if (!empty($value)){
                $contents = $value;
                $count = count($contents['title']);
                $disabled = "";
                if ($count==1)
                    $disabled = ' disabled="disabled"';
                $val = ""; $mod = "";
                for($index=0;$index<$count;$index++){
                    $title = $contents['title'][$index];
                    $description = $contents['description'][$index];
                    $val = $contents['url'][$index];
                    $align = $contents['align'][$index];
                    $bgimage = $contents['image'][$index];
                    $color = $contents['color'][$index];
                    $values = array('url' => $val, 'align' => $align, 'image' => $bgimage, 'color' => $color);
                    $rowid = $index + 1;
                    $fields_section .= '<div class="panel panel-default oet-sidebar-section-type-wrapper" id="oet_sidebar_section_type_'.$rowid.'">
                        <div class="panel-heading">
                            <h3 class="panel-title">'.ucwords($type).' '.$rowid.'</h3>
                            <span class="oet-sortable-handle">
                                <i class="fa fa-arrow-down sidebar-section-'.$type.'-reorder-down" aria-hidden="true"></i>
                                <i class="fa fa-arrow-up sidebar-section-'.$type.'-reorder-up" aria-hidden="true"></i>
                            </span>
                            <span class="btn btn-danger btn-sm oet-remove-sidebar-section-content" title="Delete"'.$disabled.'><i class="fa fa-trash-o"></i> </span>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="oet_sidebar_section_content_title">Title:</label>
                                <input type="text" class="form-control oet-sidebar-section-'.$type.'-title" name="oet_sidebar_section[content]['.$type.'][title][]" placeholder = "Content Title" value="'.$title.'">
                            </div>
                            <div class="form-group">
                                <label for="oet_sidebar_section_content_html">Short Description:</label>';
                                ob_start(); // Start Output buffer
                                wp_editor( $description,
                                    'oet-sidebar-section-'.$type.'-'.$rowid,
                                    $settings = array(
                                        'textarea_name' => 'oet_sidebar_section[content]['.$type.'][description][]',
                                        'media_buttons' => true,
                                        'textarea_rows' => 6,
                                        'drag_drop_upload' => true,
                                        'teeny' => true,
                                        'tinymce' => true,
                                        'quicktags' => true,
                                        'editor_class' => 'oet-wp-editor',
                                        'default_editor' => 'html',
                                        'editor_class' => 'oet-sidebar-section-'.$type.'-description'
                                    )
                                );
                                $fields_section .= ob_get_clean();
                    $fields_section .= '</div>
                            <div class="form-group oet-content-sections">';
                    $fields_section .= generatecontentfieldtype($type, $values, $mod);
                    $fields_section .= '</div>
                        </div>
                    </div>';
                }
                if ($count>0){
                    $fields_section .= '<div class="form-group button-row-content">
                        <button type="button" class="btn btn-default oet-add-sidebar-section-content"><i class="fa fa-plus"></i> Add More '.ucwords($type).'</button>
                    </div>';
                }
            } else {
                $fields_section = '<div class="panel panel-default oet-sidebar-section-type-wrapper" id="oet_sidebar_section_type_'.$rowid.'">
                    <div class="panel-heading">
                        <h3 class="panel-title">'.ucwords($type).' '.$rowid.'</h3>
                        <span class="oet-sortable-handle">
                            <i class="fa fa-arrow-down sidebar-section-'.$type.'-reorder-down" aria-hidden="true"></i>
                            <i class="fa fa-arrow-up sidebar-section-'.$type.'-reorder-up" aria-hidden="true"></i>
                        </span>
                        <span class="btn btn-danger btn-sm oet-remove-sidebar-section-content" title="Delete"><i class="fa fa-trash-o"></i> </span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="oet_sidebar_section_content_title">Title:</label>
                            <input type="text" class="form-control oet-sidebar-section-'.$type.'-title" name="oet_sidebar_section[content]['.$type.'][title][]" placeholder = "Content Title">
                        </div>
                        <div class="form-group">
                            <label for="oet_sidebar_section_content_html">Short Description:</label>';
                            ob_start(); // Start Output buffer
                            wp_editor( '',
                                'oet-sidebar-section-type-'.$rowid,
                                $settings = array(
                                    'textarea_name' => 'oet_sidebar_section[content]['.$type.'][description][]',
                                    'media_buttons' => true,
                                    'textarea_rows' => 6,
                                    'drag_drop_upload' => true,
                                    'teeny' => true,
                                    'tinymce' => true,
                                    'quicktags' => true,
                                    'editor_class' => 'oet-wp-editor',
                                    'default_editor' => 'html',
                                    'editor_class' => 'oet-sidebar-section-'.$type.'-description'
                                )
                            );
                            $fields_section .= ob_get_clean();
                $fields_section .= '</div>
                        <div class="form-group oet-content-sections">';
                $fields_section .= generatecontentfieldtype($type);
                $fields_section .= '</div>
                    </div>
                </div>';
                if ($rowid==1) {
                $fields_section .= '<div class="form-group button-row-content">
                        <button type="button" class="btn btn-default oet-add-sidebar-section-content"><i class="fa fa-plus"></i> Add More '.ucwords($type).'</button>
                    </div>';
                }
            }
            break;
        case "related":
            $contents = $value;
            if (empty($contents))
                $value = 4;
            else {
                $value = $contents['count'][0];
            }
            $fields_section .= '<div class="form-group">
                                    <label for="oet_sidebar_section_title">Display Count:</label>
                                    <input type="number" class="form-control" name="oet_sidebar_section[content]['.$type.'][count][]" value="'.$value.'">
                            </div>';
            break;
    }
    return $fields_section;
}

/** Generate Field Types **/
function generatecontentfieldtype($type, $value="", $modal=1){
    $content = "";
    switch ($type){
        case "link":
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_content_link_url">Url:</label>
                            <input type="text" class="form-control oet-sidebar-section-'.$type.'-url" name="oet_sidebar_section[content]['.$type.'][url][]" placeholder = "Enter Url" value="'.$value.'">
                        </div>';
            break;
        case "image":
            $img = "";
            $buttonText = "Select Image";
            if (!empty($value)){
                $img = '<img src="' . $value . '" class="oet-section-image-thumbnail" width="200"><span class="btn btn-danger btn-sm oet-remove-section-image" title="Remove Image"><i class="fa fa-minus-circle"></i></span>';
                $buttonText = "Change Image";
            }
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_image_url">Image:</label>
                            <div class="oet_section_image_thumbnail_holder">'.$img.'</div>
                            <button name="oet_sidebar_section_image_button" class="oet_sidebar_section_image_button" class="ui-button" alt="'.$buttonText.'">'.$buttonText.'</button>
                            <input type="hidden" name="oet_sidebar_section[content]['.$type.'][url][]" class="oet_sidebar_section_image_url" value="'.$value.'" />
                        </div>';
            break;
        case "youtube":
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_content_link_url">Playlist ID:</label>
                            <input type="text" class="form-control oet-sidebar-section-'.$type.'-playlist-id" name="oet_sidebar_section[content]['.$type.'][pid][]" placeholder = "Enter Playlist ID" value="'.$value['pid'].'">
                            <em>Leave this empty if only embedding a YouTube video and not a playlist</em>
                        </div>
                        <div class="form-group">
                            <label for="oet_sidebar_section_content_link_url">Video ID:</label>
                            <input type="text" class="form-control oet-sidebar-section-'.$type.'-video-id" name="oet_sidebar_section[content]['.$type.'][id][]" placeholder = "Enter Video ID" value="'.$value['id'].'">
                        </div>
                        <div class="form-group">
                            <label for="oet_sidebar_section_content_option_modal">Playback in modal:</label>';
               $_mdl = ($modal != 0)? 'checked': '';
               $content .= '<input type="hidden" class="oet_sidebar_section_youtube_modal_opt" name="oet_sidebar_section[content]['.$type.'][modal][]" value="'. $modal .'" >';
               $content .= '<input type="checkbox" class="oet_sidebar_section_youtube_modal_trg" '. $_mdl .' >';
            $content .= '</div>';
            break;
        case "story":
            $disabled = "";
            $story_url = "";
            if (empty($value)){
                $disabled = ' disabled="disabled"';
            } else {
                $story_url = get_permalink($value);
            }
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_content_story">Story:</label>
                            <div class="row-inline">
                            <select name="oet_sidebar_section[content]['.$type.'][story][]" class="form-control oet-sidebar-section-story">';
            $stories = oet_get_stories();
            foreach($stories as $story){
                $content .= '<option value="'.$story->ID.'" '.selected($value,$story->ID, false).'>'.$story->post_title.'</option>';
            }
            $content .= '   </select><span class="preview-story"'.$disabled.'><a href="'.$story_url.'" class="oet-sidebar-story-url" target="_blank"><i class="fa fa-2x fa-external-link" aria-hidden="true"></i></a></span>
                            </div>
                        </div>';
            break;
        case "medium":
            // Medium URL
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_content_link_url">Medium Post URL:</label>
                            <input type="text" class="form-control oet-sidebar-section-'.$type.'-post-url" name="oet_sidebar_section[content]['.$type.'][url][]" placeholder = "Enter Medium Url" value="'.$value['url'].'">
                        </div>';
            // Alignment
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_content_link_url">Alignment:</label>
                            <select class="form-control oet-sidebar-section-'.$type.'-alignment" name="oet_sidebar_section[content]['.$type.'][align][]">
                                <option value="left" '.selected( $value['align'], "left", false ).'>Left</option>
                                <option value="center" '.selected( $value['align'], "center", false ).'>Center</option>
                                <option value="right" '.selected( $value['align'], "right", false ).'>Right</option>
                            </select>
                        </div>';
            // Background image
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_content_link_url">Background Image:</label>
                            <div class="row-inline">
                                <input type="text" class="form-control oet_medium_background_image_url" name="oet_sidebar_section[content]['.$type.'][image][]" placeholder = "Enter Background Image Url" value="'.$value['image'].'">
                                <button name="oet_select_medium_background_image" class="oet_select_medium_background_image" alt="Set Background Image">Set Image</button>
                            </div>
                        </div>';
            // Background Color if background image is not set
            $content .= '<div class="form-group">
                            <label for="oet_sidebar_section_content_link_url">Background Color:</label>
                            <input type="text" class="form-control oet_medium_color_picker" name="oet_sidebar_section[content]['.$type.'][color][]" placeholder = "Enter Background Color" value="'.$value['color'].'">
                        </div>';
            break;
    }
    return $content;
}

/**
 * Save sidebar sections fields
 */
add_action('save_post', 'oet_save_page_custom_fields');
function oet_save_page_custom_fields() {
    global $post;
    
    //Check first if $post is not empty
    if ($post) {
        if ($post->post_type == 'page') {
            //Save Sidebar Section
            if (isset($_POST['oet_sidebar_section'])) {
                update_post_meta($post->ID, 'oet_sidebar_section', $_POST['oet_sidebar_section']);
            } else {
                if (get_post_meta($post->ID, 'oet_sidebar_section'))
                    delete_post_meta($post->ID, 'oet_sidebar_section');
            }
        }
    }
}

/**
 * Display Dynamic Sidebar
 **/
function oet_display_dynamic_sidebar($page_id){
    $sidebar_content = "";

    // Get Page Meta by Id
    $sidebar_sections = get_post_meta( $page_id, 'oet_sidebar_section' );
    if (!empty($sidebar_sections)) {
        // Display dynamic sidebar sections
        $sidebar_section = $sidebar_sections[0];
        $sidebar_count = count($sidebar_section['title']);
        for($index=0;$index<$sidebar_count;$index++){
            $title = $sidebar_section['title'][$index];
            $icon = $sidebar_section['icon'][$index];
            $type = (isset($sidebar_section['type'][$index])?$sidebar_section['type'][$index]:"");
            $content_type = (isset($sidebar_section['content'][$type])?$sidebar_section['content'][$type]:"");
            $sidebar_content .= '<div class="col-md-12 col-xs-12">';
            $sidebar_content .= '   <div class="pblctn_box">';
            $sidebar_content .= '       <span class="socl_icns fa-stack"><i class="fa '.$icon.'"></i></span>';
            $sidebar_content .= '   </div>';
            $sidebar_content .= '   <p class="rght_sid_wdgt_hedng">'. $title .'</p>';
            // Related content only
            if ($type=="related")
                $sidebar_content .=     display_sidebar_content_type($type, $index, $sidebar_section);
            else
                $sidebar_content .=     display_sidebar_content_type($type, $index, $content_type);
            $sidebar_content .= '</div>';
        }
    } else {
        // Default featured content sidebar
        $sidebar_content = oet_display_default_sidebar($page_id);
    }
    return $sidebar_content;
}

/**
 * Display Default Sidebar if no dynamic sidebar specified
 *
 * Returns 4 related contents based on tags/categories
 **/
function oet_display_default_sidebar($page_id, $related_count=4, $display_header=true){
    $html = "";
    // Get tags/categories of page
    $terms = wp_get_post_terms($page_id, array('category','post_tag'), array('fields'=> 'all'));
    if (empty($terms)) $terms = array();
    $term_list = wp_list_pluck($terms, 'slug');
    
    $related_args = array(
        'post_type'         => array('page', 'post'),
        'posts_per_page'    => $related_count,
        'post_status'       => 'publish',
        'post__not_in'      => array($page_id),
        'orderby'           => 'rand',
        'tax_query'         => array(
            'relation'      => 'OR',
            array(
                'taxonomy'  => 'category',
                'field'     => 'slug',
                'terms'     => $term_list
            ),
            array(
                'taxonomy'  => 'post_tag',
                'field'     => 'slug',
                'terms'     => $term_list
            )
        )
    );
    
    $related_posts = new WP_Query($related_args);
    $heading_title = "Related Content";
    
    if (!empty($title))
        $heading_title = $title;
        
    if ($related_posts->have_posts()){
        if ($display_header){
            $html .= '<div class="col-md-12 col-sm-6 col-xs-6">';
            $html .= '   <div class="pblctn_box">';
            $html .= '       <span class="socl_icns fa-stack"><i class="fa '.$icon.'"></i></span>';
            $html .= '   </div>';
            $html .= '   <h4 class="rght_sid_wdgt_hedng">'.$heading_title.'</h4>';
        }
        $index = 0;
        while($related_posts->have_posts()): $related_posts->the_post();
            $excerpt = '';
            if ($index==0)
                $html .= '<p class="hdng_mtr brdr_mrgn_none"><a href="'.get_the_permalink().'">'.get_the_title().'</a></p>';
            else
                $html .= '<p class="hdng_mtr"><a href="'.get_the_permalink().'">'.get_the_title().'</a></p>';
                
            $related_id = get_the_ID();
            
            if (function_exists('display_story_excerpt')){
                $excerpt = display_story_excerpt($related_id, 100);
            }
            
            if (strlen($excerpt)<=0) {
                $excerpt = get_excerpt_by_id($related_id, 15);
            }
            
            $html .= '<p>'.$excerpt.'</p>';
            $index++;
        endwhile;
        if ($display_header){
            $html .= '</div>';
        }
    }
    wp_reset_postdata();
    
    return $html;
}

/** Display Content Types on front-end **/
function display_sidebar_content_type($type, $sectionid, $sidebar_content){
    global $post;
    
    $content = "";
    switch ($type){
        case "html":
            $html = $sidebar_content[$sectionid+1][0];
            $content = $html;
            break;
        case "link":
            $count = count($sidebar_content['title']);
            for($index=0;$index<$count;$index++){
                $title = (isset($sidebar_content['title'][$index])?$sidebar_content['title'][$index]:"");
                $description = (isset($sidebar_content['description'][$index])?$sidebar_content['description'][$index]:"");
                $link_url =  (isset($sidebar_content['url'][$index])?$sidebar_content['url'][$index]:"");
                if ($index==0)
                    $content .= '<p class="hdng_mtr brdr_mrgn_none"><a href="'.$link_url.'">'.$title.'</a></p>';
                else
                    $content .= '<p class="hdng_mtr"><a href="'.$link_url.'">'.$title.'</a></p>';
                $content .= '<p>'.$description.'</p>';
            }
            break;
        case "image":
            $count = count($sidebar_content['title']);
            for($index=0;$index<$count;$index++){
                $title = (isset($sidebar_content['title'][$index])?$sidebar_content['title'][$index]:"");
                $description = (isset($sidebar_content['description'][$index])?$sidebar_content['description'][$index]:"");
                $image_url =  (isset($sidebar_content['url'][$index])?$sidebar_content['url'][$index]:"");
                
                $class = "hdng_mtr brdr_mrgn_none";
                $hclass = "sdbr_img_cntnt";
                if ($index==0)
                    $hclass .= " brdr_mrgn_none";
                $content = '<div class="'.$hclass.'">';
                if (!empty($image_url))
                    $content .= '<div class="hdng_img_mtr"><a href="'.$image_url.'" target="_blank"><img src="'.$image_url.'"></a></div>';
                $content .= '<p class="'.$class.'">'.$title.'</p>';
                $content .= '<p>'.$description.'</p>';
                $content .= '</div>';
            }
            break;
        case "related":
            $count = 4;
            if (isset($sidebar_content['content']['related']['count']))
                $count = $sidebar_content['content']['related']['count'][0];
            $content = oet_display_default_sidebar($post->ID,$count,false);
            break;
        case "youtube":
            $count = count($sidebar_content['title']);
            $instance = 0;
            for($index=0;$index<$count;$index++){
                $title = (isset($sidebar_content['title'][$index])?$sidebar_content['title'][$index]:"");
                $description = (isset($sidebar_content['description'][$index])?$sidebar_content['description'][$index]:"");
                //$youtube_url =  (isset($sidebar_content['url'][$index])?$sidebar_content['url'][$index]:"");
                $youtube_type = (isset($sidebar_content['pid'][$index])?"playlist":"video");
                $youtube_pid = (isset($sidebar_content['pid'][$index])?$sidebar_content['pid'][$index]:"");
                $youtube_id = (isset($sidebar_content['id'][$index])?$sidebar_content['id'][$index]:"");
                $youtube_modal =  (isset($sidebar_content['modal'][$index])?$sidebar_content['modal'][$index]:"0");
                
                $class = "hdng_mtr brdr_mrgn_none";
                $hclass = "sidebar-youtube-video";
                if ($index==0)
                    $hclass .= " brdr_mrgn_none";
                
                if($youtube_modal){ //modal
                  //$content .= $instance;
                  $content .= '<div class="'.$hclass.'">';
                  $content .= '<a href="#" data-toggle="modal" data-target="#oet-youtube-modal-'.$youtube_id.'">';
                  $content .= '<img src="http://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg" alt="'.$title.'"/>';
                  $content .= '<div class="oet-youtube-play-overlay"><img src="'.get_stylesheet_directory_uri().'/images/ytplay.png" alt=""></div>';
                  $content .= '</a>';      
                  $content .= '<p class="'.$class.'">'.$title.'</p>';
                  $content .= '<p>'.$description.'</p>';
                  $content .= '</div>';
    
                  $content .= '<div class="oet-youtube-modal-wrapper">';
                    $content .= '<div class="modal fade" tabindex="-1" id="oet-youtube-modal-'.$youtube_id.'" role="dialog" aria-labelledby="'.$title.'" aria-hidden="true">';
                      $content .= '<div class="modal-dialog modal-dialog-centered" role="document">';                  
                        $content .= '<div class="modal-content">';
                          $content .= '<div id="player'.$youtube_id.'" class="oet_youtube_side_container" inst="'.$instance.'" yid="'.$youtube_id.'" ytype="'.$youtube_type.'" ypid="'.$youtube_pid.'"></div>';
                        $content .= '</div>';                  
                        $content .= '<a class="oet_youtube_side_container_close" data-dismiss="modal"><span class="dashicons dashicons-no-alt"></span></a>';
                      $content .= '</div>';
                    $content .= '</div>';
                  $content .= '</div>';

                  $content .= '<script>';
                    $content .= 'jQuery( document ).ready(function() {';  
                      $content .= 'jQuery(document).on("shown.bs.modal","#oet-youtube-modal-'.$youtube_id.'", function () {';
                          $content .= 'sideytplayer.play('.$instance.');';
                      $content .= '});';  
                      $content .= 'jQuery(document).on("hide.bs.modal","#oet-youtube-modal-'.$youtube_id.'", function () {';
                          $content .= 'sideytplayer.pause('.$instance.');';
                      $content .= '});';
                    $content .= '});';
                  $content .= '</script>';
                  
                  $instance++;
  
                }else{
                  $content .= '<div class="'.$hclass.'">';
                  $content .= oet_youtube_embed_by_type($youtube_type, $youtube_id, $youtube_pid);
                  $content .= '<p class="'.$class.'">'.$title.'</p>';
                  $content .= '<p>'.$description.'</p>';
                  $content .= '</div>';
                }
            }
            break;
        case "story":
            $count = count($sidebar_content['title']);
            for($index=0;$index<$count;$index++){
                $title = (isset($sidebar_content['title'][$index])?$sidebar_content['title'][$index]:"");
                $description = (isset($sidebar_content['description'][$index])?$sidebar_content['description'][$index]:"");
                $story_id =  (isset($sidebar_content['story'][$index])?$sidebar_content['story'][$index]:"");
                
                $class = "hdng_mtr brdr_mrgn_none";
                $hclass = "sidebar-story-post";
                if ($index==0)
                    $hclass .= " brdr_mrgn_none";
                
                $content .= '<div class="'.$hclass.'">';
                $content .= '<p class="'.$class.'">'.$title.'</p>';
                $content .= '<p>'.$description.'</p>';
                if (shortcode_exists('oet_story'))
                    $content .= do_shortcode('[oet_story id="'.$story_id.'" width=12][/oet_story]');
                $content .= '</div>';
            }
            break;
        case "medium":
            $count = count($sidebar_content['title']);
            for($index=0;$index<$count;$index++){
                $bgcolor = "";
                $background = $sidebar_content['image'][$index];
                $align = $sidebar_content['align'][$index];
                $title = (isset($sidebar_content['title'][$index])?$sidebar_content['title'][$index]:"");
                $description = (isset($sidebar_content['description'][$index])?$sidebar_content['description'][$index]:"");
                $medium_url =  (isset($sidebar_content['url'][$index])?$sidebar_content['url'][$index]:"");
                
                if (isset($sidebar_content['color'][$index]))
                    $bgcolor = "#".$sidebar_content['color'][$index];
                
                $class = "hdng_mtr brdr_mrgn_none";
                $hclass = "sidebar-medium-post";
                if ($index==0)
                    $hclass .= " brdr_mrgn_none";
                
                $content .= '<div class="'.$hclass.'">';
                $content .= do_shortcode('[oet_medium url="'.$medium_url.'" title="'.$title.'" description="'.$description.'" align="none" textalign="'.$align.'" bgcolor="'.$bgcolor.'" image="'.$background.'"  width="100%"]');
                $content .= '</div>';
            }
            break;
    }
    return $content;
}

/** Get Stories **/
function oet_get_stories(){
    $args = array(
        'post_type'         => array('stories'),
        'posts_per_page'    => -1,
        'post_status'       => 'publish',
        'orderby'           => 'title',
        'order'             => 'ASC'
    );
    
    $stories = new WP_Query($args);
    
    return $stories->posts;
}

/** Youtube Embed **/
function oet_youtube_embed_code($url) {
	$embed_code = "";
	
	$youtube_id = oet_get_youtube_id($url);
	
	//Generate embed code
	if ($youtube_id) {
		$embed_code = '<div class="youtube-videoWrapper"><iframe class="oet-youtube-video-ifrm" title="Video Embed" width="640" height="360" src="https://www.youtube.com/embed/'.$youtube_id.'?rel=0" frameborder="0" allowfullscreen></iframe></div>';
	}
	return $embed_code;
}

/** Youtube Embed By Type **/
function oet_youtube_embed_by_type($type, $videoId, $playlistId="") {
    $embed_code = "";
    
    //Generate embed code
    if (!empty($videoId)) {
        if ($type=="video") {
            $embed_code = '<div class="youtube-videoWrapper"><iframe class="oet-youtube-video-ifrm" title="Video Embed" width="640" height="360" src="https://www.youtube.com/embed/'.$videoId.'?rel=0" frameborder="0" allowfullscreen></iframe></div>';
        } elseif ($type=="playlist"){
            $embed_code = '<div class="youtube-videoWrapper"><iframe class="oet-youtube-video-ifrm" title="Video Embed" width="640" height="360" src="https://www.youtube.com/embed/'.$videoId.'?list='.$playlistId.'&rel=0" frameborder="0" allowfullscreen></iframe></div>';
        }
    }
    return $embed_code;
}

/** Get Youtube Id **/
function oet_get_youtube_id($url){
	$youtube_id = null;
	
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		$youtube_id = $id[1];
	} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		$youtube_id = $id[1];
	} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		$youtube_id = $id[1];
	} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		$youtube_id = $id[1];
	} else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		$youtube_id = $id[1];
	}
	
	return $youtube_id;
}

/**
 * Display ACF Dynamic Sidebar
 **/
function oet_display_acf_dynamic_sidebar($page_id){
    $sidebar_content = "";
    // Get Page Meta by Id
    $sidebar_sections = get_post_meta( $page_id, 'oet_sidebar_section' );

    if (have_rows('oet_sidebar', $page_id)) {
        $sidebar_content .= '<div class="col-md-3 col-sm-12 col-xs-12 pblctn_right_sid_mtr">';
        while ( have_rows('oet_sidebar', $page_id) ) : the_row();
            $row = get_row();
            $title = get_sub_field('oet_sidebar_section_title', $page_id);
            $icon = get_sub_field('oet_sidebar_section_icon', $page_id);
            $type = get_sub_field('oet_sidebar_section_type', $page_id);

            $sidebar_content .= '<div class="col-md-12 col-xs-12 oet-sidebar-section-'.$type.'">';
            $sidebar_content .= '   <div class="pblctn_box">';
            $sidebar_content .= '       <span class="socl_icns fa-stack"><i class="fa '.$icon.'"></i></span>';
            $sidebar_content .= '   </div>';
            $sidebar_content .= '   <p class="rght_sid_wdgt_hedng">'. $title .'</p>';
            $content = '';
            switch ($type){
                case "html":
                    $content = get_sub_field('oet_sidebar_html_content', $page_id);
                    break;
                case "link":
                    $content = get_sub_field('oet_sidebar_page_link', $page_id);
                    break;
                case "image":
                    $content = get_sub_field('oet_sidebar_image', $page_id);
                    break;
                case "related":
                    $content = get_sub_field('oet_sidebar_related_content', $page_id);
                    break;
                case "youtube":
                    $content = get_sub_field('oet_sidebar_youtube_content', $page_id);
                    break;
                case "story":
                    $content = get_sub_field('oet_sidebar_story', $page_id);
                    break;
                case "medium":
                    $content = get_sub_field('oet_sidebar_medium_post', $page_id);
                    break;
            }
            $sidebar_content .=     display_acf_sidebar_content_type($type, $content);
            
            $sidebar_content .= '</div>';
        endwhile;
        $sidebar_content .= '</div>';
    } else {
        // Default featured content sidebar
        $sidebar_content = oet_display_default_sidebar($page_id);
    }
    return $sidebar_content;
}

/** Display Content Types on front-end **/
function display_acf_sidebar_content_type($type, $sidebar_content, $page_id=0, $admin_display=false){
    global $post;
    
    $content = "";
    $sectionid = 0;
    switch ($type){
        case "html":
            $html = stripslashes($sidebar_content);
            $content = $html;
            break;
        case "link":
            $index = 0;
            if (!empty($sidebar_content)) {
                foreach($sidebar_content as $scontent){
                    $title = stripslashes($scontent['oet_sidebar_page_link_title']);
                    $description = stripslashes($scontent['oet_sidebar_page_link_short_description']);
                    $link_url = $scontent['oet_sidebar_page_link_url'];
                    if ($index==0)
                        $content .= '<p class="hdng_mtr brdr_mrgn_none"><a href="'.$link_url.'">'.$title.'</a></p>';
                    else
                        $content .= '<p class="hdng_mtr"><a href="'.$link_url.'">'.$title.'</a></p>';
                    $content .= '<p>'.$description.'</p>';
                    $index++;
                }
            }
            break;
        case "image":
            $index = 0;
            if (!empty($sidebar_content)) {
                foreach($sidebar_content as $scontent){
                    $title = stripslashes($scontent['oet_sidebar_image_title']);
                    $image_alt = $title . " featured image";
                    $description = stripslashes($scontent['oet_sidebar_image_short_description']);
                    $image_url = $scontent['oet_sidebar_media_image'];
                    $image_title = $image_url['title'];

                    if (!empty($image_url['alt']))
                        $image_alt = $image_url['alt'];
                    elseif (!empty($image_title))
                        $image_alt = str_replace("-"," ", $image_title);

                    if (isset($image_url['sizes']['medium'])){
                        $image_url = $image_url['sizes']['medium'];
                    } else {
                        $image_url = $image_url['url'];
                    }
                    $class = "hdng_mtr brdr_mrgn_none";
                    $hclass = "sdbr_img_cntnt";
                    if ($index==0)
                        $hclass .= " brdr_mrgn_none";
                    $content .= '<div class="'.$hclass.'">';
                    if (!empty($image_url))
                        $content .= '<div class="hdng_img_mtr"><a href="'.$image_url.'" target="_blank"><img src="'.$image_url.'" alt="'.$image_alt.'"></a></div>';
                    $content .= '<p class="'.$class.'">'.$title.'</p>';
                    $content .= '<p>'.$description.'</p>';
                    $content .= '</div>';
                    $index++;
                }
            }
            break;
        case "related":
            $count = 4;
            if (isset($sidebar_content['oet_sidebar_related_content_display_count']))
                $count = $sidebar_content['oet_sidebar_related_content_display_count'];
            if ($page_id!==0)
                $content = oet_display_default_sidebar($page_id,$count,false);
            else
                $content = oet_display_default_sidebar($post->ID,$count,false);
            break;
        case "youtube":
            $instance = 0;
            $index=0;
            if (!empty($sidebar_content)) {
                foreach($sidebar_content as $scontent){
                    $title = stripslashes($scontent['oet_sidebar_youtube_content_title']);
                    $description = stripslashes($scontent['oet_sidebar_youtube_content_short_description']);
                    $youtube_type = (isset($scontent['oet_sidebar_youtube_content_playlist_id'])?"playlist":"video");
                    $youtube_pid = $scontent['oet_sidebar_youtube_content_playlist_id'];
                    $youtube_id = $scontent['oet_sidebar_youtube_content_video_id'];
                    $youtube_modal = $scontent['oet_sidebar_youtube_content_modal_playback'];

                    $class = "hdng_mtr brdr_mrgn_none";
                    $hclass = "sidebar-youtube-video";
                    if ($index==0)
                        $hclass .= " brdr_mrgn_none";
                    
                    if($youtube_modal){ //modal
                      //$content .= $instance;
                      $content .= '<div class="'.$hclass.'">';
                      $content .= '<a href="#" data-toggle="modal" data-target="#oet-youtube-modal-'.$youtube_id.'">';
                      $content .= '<img src="http://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg" alt="'.$title.'"/>';
                      $content .= '<div class="oet-youtube-play-overlay"><img src="'.get_stylesheet_directory_uri().'/images/ytplay.png" alt="play youtube video"></div>';
                      $content .= '</a>';      
                      $content .= '<h2 class="'.$class.'">'.$title.'</h2>';
                      $content .= '<p>'.$description.'</p>';
                      $content .= '</div>';

                      // only show modal on frontend and not through sidebar preview modal
                      if (!$admin_display) {
                          $content .= '<div class="oet-youtube-modal-wrapper">';
                            $content .= '<div class="modal fade" tabindex="-1" id="oet-youtube-modal-'.$youtube_id.'" role="dialog" aria-labelledby="'.$title.'" aria-hidden="true">';
                              $content .= '<div class="modal-dialog modal-dialog-centered" role="document">';                  
                                $content .= '<div class="modal-content">';
                                  $content .= '<div id="player'.$youtube_id.'" class="oet_youtube_side_container" inst="'.$instance.'" yid="'.$youtube_id.'" ytype="'.$youtube_type.'" ypid="'.$youtube_pid.'"></div>';
                                $content .= '</div>';                  
                                $content .= '<a class="oet_youtube_side_container_close" tabindex="0" data-dismiss="modal"><span class="dashicons dashicons-no-alt"></span></a>';
                              $content .= '</div>';
                            $content .= '</div>';
                          $content .= '</div>';

                          $content .= '<script>';
                            $content .= 'jQuery( document ).ready(function() {';  
                              $content .= 'jQuery(document).on("shown.bs.modal","#oet-youtube-modal-'.$youtube_id.'", function () {';
                                  $content .= 'sideytplayer.play('.$instance.');';
                              $content .= '});';  
                              $content .= 'jQuery(document).on("hide.bs.modal","#oet-youtube-modal-'.$youtube_id.'", function () {';
                                  $content .= 'sideytplayer.pause('.$instance.');';
                              $content .= '});';
                            $content .= '});';
                          $content .= '</script>';
                        }
                      
                      $instance++;

                    }else{
                      $content .= '<div class="'.$hclass.'">';
                      $content .= oet_youtube_embed_by_type($youtube_type, $youtube_id, $youtube_pid);
                      $content .= '<p class="'.$class.'">'.$title.'</p>';
                      $content .= '<p>'.$description.'</p>';
                      $content .= '</div>';
                    }
                    $index++;
                }
            }
            break;
        case "story":
            $index = 0;
            if (!empty($sidebar_content)) {
                foreach($sidebar_content as $scontent){
                    $title = stripslashes($scontent['oet_sidebar_story_title']);
                    $description = stripslashes($scontent['oet_sidebar_story_short_description']);
                    $story_id = $scontent['oet_sidebar_story_content_story']->ID;

                    $class = "hdng_mtr brdr_mrgn_none";
                    $hclass = "sidebar-story-post";
                    if ($index==0)
                        $hclass .= " brdr_mrgn_none";
                    
                    $content .= '<div class="'.$hclass.'">';
                    $content .= '<p class="'.$class.'">'.$title.'</p>';
                    $content .= '<p>'.$description.'</p>';
                    if (shortcode_exists('oet_story'))
                        $content .= do_shortcode('[oet_story id="'.$story_id.'" width=12][/oet_story]');
                    $content .= '</div>';
                    $index++;
                }
            }
            break;
        case "medium":
            $bgcolor = "";
            $index = 0;
            if (!empty($sidebar_content)) {
                foreach($sidebar_content as $scontent){
                    $background = $scontent['oet_sidebar_medium_post_background_image'];
                    if (isset($background['sizes']['medium']))
                        $background = $background['sizes']['medium'];
                    else
                        $background = $background['url'];
                    $align = $scontent['oet_sidebar_medium_post_alignment'];
                    $title = stripslashes($scontent['oet_sidebar_medium_post_title']);
                    $description = stripslashes(strip_tags($scontent['oet_sidebar_medium_post_short_description']));
                    $medium_url =  $scontent['oet_sidebar_medium_post_url'];
                    
                    if (isset($scontent['oet_sidebar_medium_post_background_color'])){
                        $bgcolor = str_replace("#","",$scontent['oet_sidebar_medium_post_background_color']);
                    }
                    
                    $class = "hdng_mtr brdr_mrgn_none";
                    $hclass = "sidebar-medium-post";
                    if ($index==0)
                        $hclass .= " brdr_mrgn_none";
                    
                    $content .= '<div class="'.$hclass.'">';
                    $content .= do_shortcode('[oet_medium url="'.$medium_url.'" title="'.$title.'" description="'.$description.'" align="none" textalign="'.$align.'" bgcolor="'.$bgcolor.'" image="'.$background.'"  width="100%"]');
                    $content .= '</div>';
                }
            }
            break;
    }
    return $content;
}

/**
 * Get Story Url by Id
 */
add_action('wp_ajax_oet_sidebar_story_url_callback', 'oet_sidebar_story_url_callback');
add_action('wp_ajax_nopriv_oet_sidebar_story_url_callback', 'oet_sidebar_story_url_callback');

function oet_sidebar_story_url_callback(){
    $url = "";
    $ID = isset($_REQUEST['id']) ? $_REQUEST['id']: "";
    if ($ID)
        $url = get_permalink($ID);

    echo $url;
    exit();
}

/** 
* Display Sidebar Section
**/
add_action('wp_ajax_oet_display_sidebar_section_callback', 'oet_display_sidebar_section_callback');
add_action('wp_ajax_nopriv_oet_display_sidebar_section_callback', 'oet_display_sidebar_section_callback');
function oet_display_sidebar_section_callback(){
    global $post;
    $content = [];
    $page_id = isset($_REQUEST['id']) ? $_REQUEST['id']: $post->ID;
    $type = isset($_REQUEST['type']) ? $_REQUEST['type']: "";
    $title = isset($_REQUEST['title']) ? $_REQUEST['title']: "";
    $icon = isset($_REQUEST['icon']) ? $_REQUEST['icon']: "";
    $data = isset($_REQUEST['data']) ? $_REQUEST['data']: "";
    
    $sidebar_content .= '<div class="col-md-12 col-xs-12">';
    $sidebar_content .= '   <div class="pblctn_box">';
    $sidebar_content .= '       <span class="socl_icns fa-stack"><i class="fa '.$icon.'"></i></span>';
    $sidebar_content .= '   </div>';
    $sidebar_content .= '   <p class="rght_sid_wdgt_hedng">'. stripslashes($title) .'</p>';

    foreach ($data as $datum){
        $ccontent = oet_get_content_by_type($type,$page_id);
        if($type=="html" || $type=="related")
            $content = oet_preview_content_by_type($type,$datum);
        else
            $content[] = oet_preview_content_by_type($type,$datum);
    }
    
    if ($type=="related")
        $sidebar_content .=     display_acf_sidebar_content_type($type, $content, $page_id, true);
    else
        $sidebar_content .=     display_acf_sidebar_content_type($type, $content, 0, true);
    
    $sidebar_content .= '</div>';

    echo $sidebar_content;

    exit();
}

function oet_get_content_by_type($type, $page_id){
    $content = "";
    if (have_rows('oet_sidebar', $page_id)) {
        while ( have_rows('oet_sidebar', $page_id) ) : the_row();
            $row = get_row();

            $ctype = get_sub_field('oet_sidebar_section_type', $page_id);
            switch ($ctype){
                case "html":
                    $content = get_sub_field('oet_sidebar_html_content', $page_id);
                    break;
                case "link":
                    $content = get_sub_field('oet_sidebar_page_link', $page_id);
                    break;
                case "image":
                    $content = get_sub_field('oet_sidebar_image', $page_id);
                    break;
                case "related":
                    $content = get_sub_field('oet_sidebar_related_content', $page_id);
                    break;
                case "youtube":
                    $content = get_sub_field('oet_sidebar_youtube_content', $page_id);
                    break;
                case "story":
                    $content = get_sub_field('oet_sidebar_story', $page_id);
                    break;
                case "medium":
                    $content = get_sub_field('oet_sidebar_medium_post', $page_id);
                    break;
            }
            if ($ctype==$type){
                break;
            }
        endwhile;
    } 
    return $content;
}

function oet_preview_content_by_type($type, $data){
    $content = null;
    switch ($type){
        case "html":
            $content = $data['content'];
            break;
        case "link":
            $content = array(
                "oet_sidebar_page_link_title" => $data['title'],
                "oet_sidebar_page_link_short_description" => $data['content'],
                "oet_sidebar_page_link_url" => $data['page_url']
            );
            break;
        case "image":
            $image_id = $data['image_id'];
            $image_data = null;
            if ($image_id!==""){
                $image_data = wp_get_attachment_metadata($image_id);
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                $image_data['alt'] = $image_alt;
                $image_title = get_the_title($image_id);
                $image_data['title'] = $image_title;
                $image_sizes = oet_get_all_image_sizes($image_id);
                $image_data['sizes'] = $image_sizes;
            }
            $content = array(
                "oet_sidebar_image_title" => $data['title'],
                "oet_sidebar_image_short_description" => $data['content'],
                "oet_sidebar_media_image" => $image_data
            );
            break;
        case "related":
            $content = $data['count'];
            break;
        case "youtube":
            $content = array(
                "oet_sidebar_youtube_content_title" => $data['title'],
                "oet_sidebar_youtube_content_short_description" => $data['content'],
                "oet_sidebar_youtube_content_playlist_id" => $data['playlist_id'],
                "oet_sidebar_youtube_content_video_id" => $data['video_id'],
                "oet_sidebar_youtube_content_modal_playback" => $data['playback_modal']
            );
            break;
        case "story":
            $story_data = get_post($data['story_id']);
            $content = array(
                "oet_sidebar_story_title" => $data['title'],
                "oet_sidebar_story_short_description" => $data['content'],
                "oet_sidebar_story_content_story" => $story_data
            );
            break;
        case "medium":
            $image_id = $data['image_id'];
            $image_data = null;
            if ($image_id!==""){
                $image_data = wp_get_attachment_metadata($image_id);
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
                $image_data['alt'] = $image_alt;
                $image_title = get_the_title($image_id);
                $image_data['title'] = $image_title;
                $image_sizes = oet_get_all_image_sizes($image_id);
                $image_data['sizes'] = $image_sizes;
            } else {
                $image_data = false;
            }
            $content = array(
                "oet_sidebar_medium_post_title" => $data['title'],
                "oet_sidebar_medium_post_short_description" => $data['content'],
                "oet_sidebar_medium_post_url" => $data['medium_url'],
                "oet_sidebar_medium_post_alignment" => $data['alignment'],
                "oet_sidebar_medium_post_background_image" => $image_data,
                "oet_sidebar_medium_post_background_color" => $data['bg_color']
            );
            break;
    }
    return $content;
}

function oet_get_all_image_sizes($image_id){
    $image_sizes = [];
    $sizes = get_intermediate_image_sizes();
    foreach($sizes as $size){
        $source = wp_get_attachment_image_src($image_id, $size);
        $image_sizes[$size] = $source[0];
        $image_sizes[$size."-width"] = $source[1];
        $image_sizes[$size."-height"] = $source[2];
    }
    return $image_sizes;
}
?>