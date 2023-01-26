<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post;
?>
<div class="oet_dynamic_sidebar_wrapper">
    <?php
    $hidden = " hidden";
    $sidebar_sections = null;
    $sidebar_section = get_post_meta($post->ID,"oet_sidebar_section");
    if ($sidebar_section)
        $sidebar_sections = $sidebar_section[0];
    $index = 0;
    $type = "";
    if (!empty($sidebar_sections)){
        $count = count($sidebar_sections['title']);
        for($index=0;$index<$count;$index++){
            $title = (isset($sidebar_sections['title'][$index])?$sidebar_sections['title'][$index]:"");
            $icon = (isset($sidebar_sections['icon'][$index])?$sidebar_sections['icon'][$index]:"");
            $order = (isset($sidebar_sections['order'][$index])?$sidebar_sections['order'][$index]:($index+1));
            $html = (isset($sidebar_sections['html'][$index])?$sidebar_sections['html'][$index]:"");
            $type = (isset($sidebar_sections['type'][$index])?$sidebar_sections['type'][$index]:"");
            if ($type=="related")
                $hidden = "";
            $content_type = (isset($sidebar_sections['content'][$type])?$sidebar_sections['content'][$type]:"");
            if ($type=="html")
                $content_type = (isset($sidebar_sections['content'][$type][$order])?$sidebar_sections['content'][$type][$order]:"");
        ?>
        <div class="panel panel-default oet-sidebar-section-wrapper" id="oet_sidebar_section_<?php echo ($index+1); ?>">
            <input type="hidden" name="oet_sidebar_section[order][]" class="element-order" value="<?php echo $order;?>">
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
                    <label fosr="oet_sidebar_section_title">Title:</label>
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
                    <label for="oet_sidebar_section_type">Content Type:</label>
                    <select name="oet_sidebar_section[type][]" class="form-control oet-sidebar-section-type">
                        <option value="html" <?php selected($type,'html'); ?>>Free-form HTML</option>
                        <option value="link" <?php selected($type,'link'); ?>>Page Link</option>
                        <option value="image" <?php selected($type,'image'); ?>>Image</option>
                        <option value="related" <?php selected($type,'related'); ?>>Related Content</option>
                        <option value="youtube" <?php selected($type,'youtube'); ?>>YouTube Video</option>
                        <option value="story" <?php selected($type,'story'); ?>>Story</option>
                        <option value="medium" <?php selected($type,'medium'); ?>>Medium Post</option>
                    </select>
                </div>
                <div class="form-group oet-related-content-helper<?php echo $hidden; ?>">
                    <em>Automatic listing of related content based on matching categories and tags from this page.</em>
                </div>
                <div class="form-group oet-content-sections subsection-visible">
                    <?php
                    echo get_fields_from_content_type($type, $index+1, $content_type);
                    ?>
                </div>
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