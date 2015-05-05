<?php

include ( GAT_PATH . "/classes/class.rating.php");

//Show Ratings
function  show_ratings(){
    //Add a nonce field
    wp_nonce_field( 'gat_rating_scale' , 'gat_rating_scale_nonce' );
    
    echo "<h1>Ratings</h1>";
    
    
}

//Add Rating
function add_rating(){
    
}

?>