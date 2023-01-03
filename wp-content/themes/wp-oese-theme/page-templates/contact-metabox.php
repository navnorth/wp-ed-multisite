<input type="hidden" id="oii-template" data-template="<?php echo implode("|", Contact_Metabox::$template); ?>" />
<?php
    global $post;
    $contact_heading = get_post_meta($post->ID,'_contact_box_heading',true);
    $contact_icon = get_post_meta($post->ID,'_contact_box_icon',true);
?>
<div id="contact-content-wrap">
    <div class="group">
        <div class="col span_1_of_12"><label>Icon</label></div>
        <div class="col span_5_of_12">
            <select name="contact_box_icon">
                <option value="fa-calendar" <?php if ($contact_icon=="fa-calendar") echo "selected" ?>>Calendar</option>
                <option value="fa-globe" <?php if ($contact_icon=="fa-globe") echo "selected" ?>>Globe</option>
                <option value="fa-link" <?php if ($contact_icon=="fa-link") echo "selected" ?>>Link</option>
                <option value="fa-phone" <?php if ($contact_icon=="fa-phone") echo "selected" ?>>Phone</option>
            </select>
        </div><div class="clear"></div>
    </div>
    <div class="group">
        <div class="col span_1_of_12"><label>Heading</label></div>
        <div class="col span_9_of_12">
            <input type="text" name="contact_box_header" value="<?php echo $contact_heading; ?>" size="100" />
        </div><div class="clear"></div>
        </div>
    <div class="group">
    <?php
        $field_value = get_post_meta( $post->ID, '_contact_box', false );
        wp_editor( $field_value[0], '_contact_box' );
    ?>
    </div>
</div>