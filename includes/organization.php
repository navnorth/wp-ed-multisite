<?php

include ( GAT_PATH . "/classes/organization.list.php");
include ( GAT_PATH . "/classes/organization.php");

function create_organization(){
    if (isset($_POST["gat-new-organization-nonce"]) || wp_verify_nonce($_POST["gat-new-organization-nonce"], "gat-new-organization"))
    {
        global $wpdb;
        
        $organization_id = sanitize_text_field($_REQUEST["id"]);
        $FIPST = sanitize_text_field($_REQUEST["FIPST"]);
        $LEAID = sanitize_text_field($_REQUEST["LEAID"]);
        $LEANM = sanitize_text_field($_REQUEST["LEANM"]);
        
        $sql = $wpdb->prepare("INSERT INTO `" . $wpdb->prefix . "organizations` (`FIPST`, `LEAID`, `LEANM`) VALUES (%s, %s, %s)", $FIPST, $LEAID, $LEANM);
        
        return ($wpdb->query($sql) === FALSE) ? FALSE : TRUE;
    }
}
/**
 * Delete Organization
 */
function delete_organization($organization_id){
    if (isset($_REQUEST["_wpnonce"]) || wp_verify_nonce($_REQUEST["_wpnonce"], "gat-delete-organization-nonce"))
    {
        global $wpdb;
        $sql = $wpdb->prepare("DELETE FROM `" . $wpdb->prefix . "organizations` WHERE organization_id = %d", $_REQUEST["id"]);
        
        $wpdb->query($sql);
        
        wp_safe_redirect(site_url() . "/wp-admin/admin.php?page=get-organizations", 302);
    }
}
/**
 * Edit Organization
 */
function edit_organization($organization_id){
    if(isset($_REQUEST["submit"]))
    {
        $organization = new Organization($_REQUEST);
        
        $organization->organization_id = $organization_id;
        
        $update = TRUE;
        
        foreach(array("FIPST", "LEAID", "LEANM") AS $field)
        {
            if($organization->$field == NULL)
            {
                $update = FALSE;
                break;
            }    
        }
        
        if($update)
            $success = update_organization();
    }
    else
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM `" . $wpdb->prefix . "organizations" . "` WHERE organization_id = %d", $organization_id);
        
        $organization = $wpdb->get_row($sql);
    }
    
    include(GAT_PATH . "/gat_template/" . __FUNCTION__ . ".php");
}
/**
 * New Organization
 */
function new_organization(){
    if(isset($_REQUEST["submit"]))
    {
        $organization = new Organization($_REQUEST);
        
        $organization->organization_id = $organization_id;
        
        $create = TRUE;
        
        foreach(array("FIPST", "LEAID", "LEANM") AS $field)
        {
            if($organization->$field == NULL)
            {
                $create = FALSE;
                break;
            }    
        }
        
        if($create)
            $success = create_organization();
    }
    
    include(GAT_PATH . "gat_template/" . __FUNCTION__ . ".php");
}
/**
 * Update Organization
 */
function update_organization(){
    if (isset($_POST["gat-edit-organization-nonce"]) || wp_verify_nonce($_POST["gat-edit-organization-nonce"], "gat-edit-organization"))
    {
        global $wpdb;
        
        $organization_id = sanitize_text_field($_REQUEST["id"]);
        $FIPST = sanitize_text_field($_REQUEST["FIPST"]);
        $LEAID = sanitize_text_field($_REQUEST["LEAID"]);
        $LEANM = sanitize_text_field($_REQUEST["LEANM"]);
        
        $sql = $wpdb->prepare("UPDATE `" . $wpdb->prefix . "organizations` SET `FIPST` = %s, `LEAID` = %s, `LEANM` = %s WHERE `organization_id` = %d", $FIPST, $LEAID, $LEANM, $organization_id);
        
        return ($wpdb->query($sql) === FALSE) ? FALSE : TRUE;
    }
}
/**
 * Get Organizations
 */
function get_organizations(){
    switch($_REQUEST["action"])
    {
        case "new-organization":
            new_organization();
            break;
        case "edit-organization":
            edit_organization($_REQUEST["id"]);
            break;
        case "update-organization":
            update_organization();
            break;
        case "delete-organization":
            delete_organization($_REQUEST["id"]);
            break;
        default:
            $organization_list = new Organization_List();
    
            // Display Heading
            echo "<div class='wrap'>";
            echo "<div id='icon-users' class='icon32'></div>";
            echo "<h2>Organizations <a href='admin.php?page=get-organizations&action=new-organization' class='add-new-h2'>Add New</a></h2>";
            wp_enqueue_script('gat-admin', plugins_url(PLUGIN_DOMAIN . "/js/organization.js"), array('jquery'), 1.0);
            //Display Ratings Table
            $organization_list->prepare_items();    
            $organization_list->display();
            
            echo "</div>";
            break;
    }
}
/**
 * Import Organizations
 */
function import_organizations(){
    if(isset($_POST["html-upload"]) AND isset($_FILES["organizations"]) AND $_FILES["organizations"]["size"])
    {
        ini_set("max_execution_time", 0);
        // set memory 1 GB for the huge data in flat file
        ini_set("memory_limit", "1200M");
        set_time_limit(0);
        
        $file = fopen($_FILES["organizations"]["tmp_name"], "r") or die("Unable to read the file.");
        
        $line = 0;
        
        include_once(GAT_PATH . "/classes/organization.php");
        
        $organizations = $heading = array();
        
        while( ! feof($file))
        {
            $row = str_replace(array("\r", "\n"), NULL, fgets($file));
            
            if (strlen(trim($row))>0){
                if($line){
                    $organizations[] = array_combine($heading, explode("\t", $row));
                } else
                    $heading = explode("\t", $row);
                
                $line++;
            }
        }
        
        fclose($file);
        
        Organization::insert($organizations);
        
        $success = TRUE;
    }
    
    include(GAT_PATH . "/gat_template/" . __FUNCTION__ . ".php");
}