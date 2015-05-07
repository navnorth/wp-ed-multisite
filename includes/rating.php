<?php

include ( GAT_PATH . "/classes/rating.list.php");

//Show Ratings
function  show_ratings(){
    
    //Instantiate Rating List class
    $rating_list = new Rating_List();
    
    // Display Heading
    echo "<div class='wrap'>";
    echo "<div id='icon-users' class='icon32'></div>";
    echo "<h2>Ratings</h2>";
    
    //Display Ratings Table
    $rating_list->prepare_items();    
    $rating_list->display();
    
    echo "</div>";
}

//Add Rating
function add_rating(){
    global $wpdb;
    if ( 'save-rating' == $_REQUEST['action'] ) {
        
        //Verify nonce before saving
        if ( isset( $_POST['gat_rating_scale_nonce'] ) || wp_verify_nonce( $_POST['gat_rating_scale_nonce'], 'gat_rating_scale' )) {
            //Save Rating here
            $ratingmeta_id = 1;
            $label = sanitize_text_field($_POST['rating_label']);
            $value = sanitize_text_field($_POST['rating_value']);
            $description = sanitize_text_field($_POST['rating_description']);
            $display = !empty($_POST['rating_display'])?1:0;
            
            $rating_table = $wpdb->prefix."ratings";
            $sql = $wpdb->prepare("INSERT INTO {$rating_table} VALUES('', %d, %d, %s, %s, %d)", $ratingmeta_id, $value, $label, $description, $display );
            
            if ($wpdb->query($sql)) {
                $rating_list_url = site_url()."/wp-admin/admin.php?page=get-ratings";
                wp_safe_redirect($rating_list_url, 302);
                exit();
            }
        }
    } else {
?>
    <div class='wrap'>
    <h2>Add New Rating</h2>
    <form method='post'>
        <?php wp_nonce_field( 'gat_rating_scale' , 'gat_rating_scale_nonce' ); ?>
        <div class="form-field form-required rating_label-wrap">
            <label for="rating_label"><?php echo __('Label:', PLUGIN_DOMAIN); ?></label>
            <input name="rating_label" id="rating_label" type="text" value="" size="40" aria-required="true">
        </div>
        <div class="form-field form-required rating_value-wrap">
            <label for="rating_value"><?php echo __('Value:', PLUGIN_DOMAIN); ?></label>
            <input name="rating_value" id="rating_value" type="text" value="" size="40" aria-required="true">
        </div>
        <div class="form-field rating_description-wrap">
            <label for="rating_description"><?php echo __('Description:', PLUGIN_DOMAIN); ?></label>
            <textarea id="rating_description" name="rating_description" aria-required="true" cols="110" rows="5"></textarea>
        </div>
        <div class="form-field rating_display-wrap">
            <label for="rating_display"><?php echo __('Display:', PLUGIN_DOMAIN); ?></label>
            <input type="checkbox" name="rating_display" value="1" />
        </div>
        <p><?php submit_button(
            __( 'Save Rating', PLUGIN_DOMAIN ),
            'primary',
            'submit'
        ); ?></p>
        <input type="hidden" name="action" value="save-rating" />
        <input type="hidden" name="page_options" value="rating" />
    </form>
    </div>
<?php
    }
}

function edit_rating(){
    
}

?>