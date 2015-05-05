<?php

include ( GAT_PATH . "/classes/rating.list.php");

//Show Ratings
function  show_ratings(){
    //Add a nonce field
    wp_nonce_field( 'gat_rating_scale' , 'gat_rating_scale_nonce' );
    
    echo "<h1>Ratings</h1>";
    
    $rating_list = new Rating_List();
    $rating_list->prepare_items();
    
    $rating_list->display();
}

//Add Rating
function add_rating(){
    
}

?>