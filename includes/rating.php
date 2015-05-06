<?php

include ( GAT_PATH . "/classes/rating.list.php");

//Show Ratings
function  show_ratings(){
    //Add a nonce field
    wp_nonce_field( 'gat_rating_scale' , 'gat_rating_scale_nonce' );
    
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
    
}

?>