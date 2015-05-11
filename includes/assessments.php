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
    <form method='post' action='admin.php?page=assessments'>
        <?php wp_nonce_field( 'gat_assessment' , 'gat_assessment_nonce' ); ?>
        <div id="titlediv" class="form-field form-required assessment_title-wrap">
            <label for="assessment_title"><?php echo __('Title:', PLUGIN_DOMAIN); ?></label>
            <input name="assessment_title" id="assessment_title" type="text" value="" size="40" aria-required="true">
        </div>
        <div class="form-field form-required assessment_description-wrap">
            <label for="assessment_description"><?php echo __('Description:', PLUGIN_DOMAIN); ?></label>
              <?php wp_editor( "", 'assessment_description' ); ?>
        </div>
        <div class="form-field assessment_results-wrap">
            <label for="assessment_results"><?php echo __('Result:', PLUGIN_DOMAIN); ?></label>
             <?php wp_editor( "", 'assessment_results' ); ?>
        </div>
        <div class="form-field assessment_rating-wrap">
            <label for="assessment_rating"><?php echo __('Rating:', PLUGIN_DOMAIN); ?></label>
            <input name="assessment_rating" id="assessment_rating" type="text" value="" size="40" aria-required="true">
        </div>
        <p><?php submit_button(
            __( 'Save Assessment', PLUGIN_DOMAIN ),
            'primary',
            'submit'
        ); ?></p>
        <input type="hidden" name="action" value="save-assessment" />
        <input type="hidden" name="page_options" value="rating" />
    </form>
    </div>
<?php
}

?>