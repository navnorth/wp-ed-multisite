<?php

include ( GAT_PATH . "/classes/organization.list.php");

function get_organizations(){
    $organization_list = new Organization_List();
    
    // Display Heading
    echo "<div class='wrap'>";
    echo "<div id='icon-users' class='icon32'></div>";
    echo "<h2>Organizations</h2>";
    
    //Display Ratings Table
    $organization_list->prepare_items();    
    $organization_list->display();
    
    echo "</div>";
}
function import_organizations(){
    if(isset($_POST["html-upload"]) AND isset($_FILES["organizations"]) AND $_FILES["organizations"]["size"])
    {
        ini_set("max_execution_time", 0);
        set_time_limit(0);
        
        $file = fopen($_FILES["organizations"]["tmp_name"], "r") or die("Unable to read the file.");
        
        $line = 0;
        
        include_once(GAT_PATH . "/classes/organization.php");
        
        $organizations = $heading = array();
        
        while( ! feof($file))
        {
            $row = str_replace(array("\r", "\n"), NULL, fgets($file));
            
            if($line)
                $organizations[] = array_combine($heading, explode("\t", $row));
            else
                $heading = explode("\t", $row);
            
            $line++;
        }
        
        fclose($file);
        
        Organization::insert($organizations);
        
        $success = TRUE;
    }
    
    include(GAT_PATH . "/gat_template/" . __FUNCTION__ . ".php");
}