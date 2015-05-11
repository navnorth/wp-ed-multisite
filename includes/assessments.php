<?php

if( ! class_exists("Assessment_List"))
    require_once(GAT_PATH . "/classes/assessment.list.php");
    
function get_assessments(){
    
    if ( 'add-new' == $_REQUEST['action'] ) {
        add_assessment();
    } else {
        //Instantiate Assessment List class
        $assessment_list = new Assessment_List();
        
        // Display Heading
        echo "<div class='wrap'>";
        echo "<div id='icon-users' class='icon32'></div>";
        echo "<h2>Assessments <a href='admin.php?page=assessments&action=add-new' class='add-new-h2'>Add New</a></h2>";
        
        //Display Ratings Table
        $assessment_list->prepare_items();    
        $assessment_list->display();
    
    echo "</div>";
    }
}

function add_assessment(){
?>
    <div class='wrap'>
    <h2>Add New Assessment</h2>
    <form method='post'>
        <?php wp_nonce_field( 'gat_assessment' , 'gat_assessment_nonce' ); ?>
        <div class="form-field form-required assessment_title-wrap">
            <label for="assessment_title"><?php echo __('Label:', PLUGIN_DOMAIN); ?></label>
            <input name="assessment_title" id="assessment_title" type="text" value="" size="40" aria-required="true">
        </div>
        <div class="form-field form-required assessment_description-wrap">
            <label for="assessment_description"><?php echo __('Value:', PLUGIN_DOMAIN); ?></label>
            <input name="assessment_description" id="assessment_description" type="text" value="" size="40" aria-required="true">
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

?>