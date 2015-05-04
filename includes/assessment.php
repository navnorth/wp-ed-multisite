<?php

//Get All Assessments
function get_assessments(){
    $assessments = array();
    
    return $assessments;
}

//Assessment Content Editor
function assessment_metaboxes(){
    //Add Results Content Meta Box
    add_meta_box(
                 'assessment_result_content' ,
                 __( 'Results Content' , PLUGIN_DOMAIN ) ,
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
	$my_data = esc_textarea( $_POST['assessment_result_content'] );
        
	// Update the meta field in the database.
        if (isset($my_data)) {
            update_post_meta( $post_id, '_assessment_result_content', $my_data );
        }
        
        // Sanitize user input
        $ratings = sanitize_text_field( $_POST['assessment_rating_scale'] );
        
        // Update rating scale in the database
        if (isset($ratings)) {
            update_post_meta( $post_id, '_assessment_rating_scale', $ratings );
        }
}
add_action( 'save_post', 'save_assessment_result_content' );

?>