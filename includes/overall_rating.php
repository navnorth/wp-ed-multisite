<?php

include ( GAT_PATH . "/classes/overall_rating.list.php");

function show_overall_ratings(){
    //Instantiate Rating List class
    $overall_rating = new Overall_Rating_List();
    
    // Display Heading
    echo "<div class='wrap'>";
    echo "<div id='icon-users' class='icon32'></div>";
    echo "<h2>Overall Ratings <a href='admin.php?page=overall-rating&action=add-new' class='add-new-h2'>Add New</a></h2>";
    
    $overall_rating->prepare_items();
    $overall_rating->display();
    
    echo "</div>";
}

?>