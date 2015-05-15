<?php

//Domain metaboxes
function domain_metaboxes(){
    
}

//Show Domains
function show_domains(){
    wp_safe_redirect(admin_url()."edit.php?post_type=domain");
}

?>