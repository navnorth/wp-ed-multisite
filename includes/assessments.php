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
        echo "<h2>Assessments <a href='post-new.php?post_type=assessment' class='add-new-h2'>Add New</a></h2>";
        
        //Display Ratings Table
        $assessment_list->prepare_items();    
        $assessment_list->display();
    
    echo "</div>";
    }
}

//Assessment Content Editor
function assessment_metaboxes(){
    //Add Results Content Meta Box
    add_meta_box(
                 'assessment_result_content' ,
                 __( 'Result Content' , PLUGIN_DOMAIN ) ,
                 'get_assessment_result_content' ,
                 'assessment' ,
                 'normal' ,
                 'default'
                 );
    //Add Ratings Meta Box
    add_meta_box(
                 'assessment_ratings_scale' ,
                 __( 'Rating Scale' , PLUGIN_DOMAIN ) ,
                 'get_ratings_scale' ,
                 'assessment' ,
                 'normal' ,
                 'default'
                 );
}

//Shows the new metabox for Ratings Scale
function get_assessment_result_content( $post ){

    //Add a nonce field
    wp_nonce_field( 'assessment_meta_box' , 'assessment_meta_box_nonce' );
    
    //Get Value from database
    $value = get_post_meta( $post->ID , '_assessment_result_content' , true );
    
    //Results Content
    //echo '<textarea id="assessment_result_content" name="assessment_result_content" cols="110" rows="5">'. esc_attr( $value ) . '</textarea>';
     wp_editor( htmlspecialchars_decode($value), 'assessment_result_content' );
}

//Shows the new metabox for result content
function get_ratings_scale( $post ){

    //Add a nonce field
    wp_nonce_field( 'assessment_rating_meta_box' , 'assessment_rating_meta_box_nonce' );
    
    //Get Value from database
    $value = get_post_meta( $post->ID , '_assessment_rating_scale' , true );
    
    //Results Content
    echo '<textarea id="assessment_rating_scale" name="assessment_rating_scale" cols="110" rows="5">'. esc_attr( $value ) . '</textarea>';
}

?>