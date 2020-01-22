<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post;
?>
<div class="oet_dynamic_sidebar_wrapper">
    <?php
    $sidebar_sections = get_post_meta($post->ID,"oet_sidebar_section")[0];
    $index = 0;
    $type = "";
    if (!empty($sidebar_sections)){
        $count = count($sidebar_sections['title']);
        for($index=0;$index<$count;$index++){
            $title = $sidebar_sections['title'][$index];
            $icon = $sidebar_sections['icon'][$index];
            $html = $sidebar_sections['html'][$index];
            if (isset($sidebar_sections['type'][$index]))
                $type = $sidebar_sections['type'][$index];
        ?>
        <div class="panel panel-default oet-sidebar-section-wrapper" id="oet_sidebar_section_'.$totalSections.'">
            <div class="panel-heading">
                <h3 class="panel-title">Section <?php echo ($index + 1); ?></h3>
                <span class="oet-sortable-handle">
                    <i class="fa fa-arrow-down sidebar-section-reorder-down" aria-hidden="true"></i>
                    <i class="fa fa-arrow-up sidebar-section-reorder-up" aria-hidden="true"></i>
                </span>
                <span class="btn btn-danger btn-sm oet-remove-sidebar-section" title="Delete"><i class="fa fa-trash-o"></i> </span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="oet_sidebar_section_title">Title:</label>
                    <input type="text" class="form-control" name="oet_sidebar_section[title][]" placeholder = "Section Title" value="<?php echo $title; ?>">
                </div>
                <div class="form-group">
                    <label for="oet_sidebar_section_icon">Icon:</label>
                    <select name="oet_sidebar_section[icon][]" class="form-control">
                        <option value="fa-star" <?php selected($icon,'fa-star'); ?>>Star</option>
                        <option value="fa-compress" <?php selected(v,'fa-compress'); ?>>Compress</option>
                        <option value="fa-cogs" <?php selected($icon,'fa-cogs'); ?>>Cogs</option>
                        <option value="fa-cog" <?php selected($icon,'fa-cog'); ?>>Cog</option>
                        <option value="fa-globe" <?php selected($icon,'fa-globe'); ?>>Globe</option>
                        <option value="fa-power-off" <?php selected($icon,'fa-power-off'); ?>>Power Off</option>
                        <option value="fa-file-o" <?php selected($icon,'fa-file-o'); ?>>File</option>
                        <option value="fa-wifi" <?php selected($icon,'fa-wifi'); ?>>WiFi</option>
                        <option value="fa-check" <?php selected($icon,'fa-check'); ?>>Check</option>
                        <option value="fa-comment-o" <?php selected($icon,'fa-comment-o'); ?>>Comment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="oet_sidebar_section_html"><?php _e("HTML Content:", OET_THEME_SLUG); ?></label>
                    <?php
                    wp_editor( $html,
                        'oer-sidebar-section-'.($index+1),
                        $settings = array(
                            'textarea_name' => 'oet_sidebar_section[html][]',
                            'media_buttons' => true,
                            'textarea_rows' => 6,
                            'drag_drop_upload' => true,
                            'teeny' => true,
                            'tinymce' => true,
                            'quicktags' => true
                        )
                    );
                    ?>
                </div>
                <div class="form-group">
                    <label for="oet_sidebar_section_type">Content Type:</label>
                    <select name="oet_sidebar_section[type][]" class="form-control oet-sidebar-section-type">
                        <option value=""></option>
                        <option value="link" <?php selected($type,'link'); ?>>Page Link</option>
                        <option value="image" <?php selected($type,'image'); ?>>Image</option>
                        <option value="related" <?php selected($type,'related'); ?>>Related Content</option>
                        <option value="youtube" <?php selected($type,'youtube'); ?>>YouTube Video</option>
                        <option value="story" <?php selected($type,'story'); ?>>Story</option>
                        <option value="medium" <?php selected($type,'medium'); ?>>Medium Post</option>
                    </select>
                </div>
                <div class="form-group oet-content-sections"></div>
            </div>
        </div>    
        <?php
        }
    }
    ?>
    <div class="form-group button-row">
        <button type="button" class="btn btn-default oet-add-sidebar-section"><i class="fa fa-plus"></i> <?php _e("Add Sidebar Section", OET_THEME_SLUG); ?></button>
    </div>
</div>