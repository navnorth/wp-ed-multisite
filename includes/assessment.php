<?php

//Get All Assessments
function get_assessments(){
    $assessments = array();
    
    return $assessments;
}

//Assessment Content Editor
function assessment_metaboxes(){
    //Add 
    add_meta_box(
                 'assessment_result_content' ,
                 __( 'Results Content' , PLUGIN_DOMAIN ) ,
                 'get_assessment_result_content' ,
                 'assessment' ,
                 'normal' ,
                 'default' ,
                 'save_assessment_result_content'
                 );
}
add_action( 'add_meta_boxes', 'assessment_metaboxes' );

//Shows the new metabox for result content
function get_assessment_result_content( $post ){

    //Add a nonce field
    wp_nonce_field( 'assessment_meta_box' , 'assessment_meta_box_nonce' );
    
    //Get Value from database
    $value = get_post_meta( $post->ID , '_my_meta_value_key' , true );
    
    echo '<label for="assessment_result_content">';
	_e( 'Results Content', PLUGIN_DOMAIN );
    echo '</label> ';
    echo '<textarea id="assessment_result_content" name="assessment_result_content" cols="110" rows="5">'. esc_attr( $value ) . '</textarea>';
}

//Save Assessment result_content
function save_assessment_result_content( $post_id ){
        // Check if our nonce is set.
        if ( ! isset( $_POST['assessment_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['assessment_meta_box_nonce'], 'assessment_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'assessment' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	
	// Make sure that it is set.
	if ( ! isset( $_POST['assessment_result_content'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['assessment_result_content'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}

?>