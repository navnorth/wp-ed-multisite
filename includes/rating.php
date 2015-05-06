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
?>
    <div class='wrap'>
    <h2>Add New Rating</h2>
    <form method='post'>
        <?php wp_nonce_field( 'gat_rating_scale' , 'gat_rating_scale_nonce' ); ?>
        <p><strong><?php echo __('Label:', PLUGIN_DOMAIN); ?></strong><br />
            <input type="text" name="rating_label" size="100" value="<?php echo get_option('label'); ?>" />
        </p>
         <p><strong><?php echo __('Value:', PLUGIN_DOMAIN); ?></strong><br />
            <input type="text" name="rating_value" size="100" value="<?php echo get_option('value'); ?>" />
        </p>
        <p><strong><?php echo __('Description:', PLUGIN_DOMAIN); ?></strong><br />
           <textarea id="rating_description" name="rating_description" cols="110" rows="5"><?php echo get_option('description'); ?></textarea>
        </p>
        <p><strong><?php echo __('Display:', PLUGIN_DOMAIN); ?></strong><br />
           <input type="checkbox" name="rating_display" />
        </p>
        <p><?php submit_button(
            __( 'Save Rating', PLUGIN_DOMAIN ),
            'primary',
            'submit'
        ); ?></p>
        <input type="hidden" name="action" value="add" />
        <input type="hidden" name="page_options" value="rating" />
    </form>
    </div>
<?php 
}

?>