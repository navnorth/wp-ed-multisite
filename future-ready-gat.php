<?php
/*
 Plugin Name: Future-Ready Gap Analysis Tool
 Plugin URI: http://www.navigationnorth.com/wordpress/gat-tool
 Description: This a future-ready Gap Analysis Tool plugin of Navigation North.
 Version: 0.1.0
 Author: Navigation North
 Author URI: http://www.navigationnorth.com

 Copyright (C) 2014 Navigation North

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */
define( 'GAT_PATH' , plugin_dir_path(__FILE__) );
define( 'GAT_URL' , plugin_dir_url(__FILE__) );
define( 'PLUGIN_DOMAIN' , 'wp-gap-analysis' );

include_once( GAT_PATH ."/includes/init.php" );
include_once( GAT_PATH ."/includes/assessment.php" );
include_once( GAT_PATH ."/includes/domain.php" );
include_once( GAT_PATH ."/includes/dimension.php" );
include_once( GAT_PATH ."/includes/rating.php" );

register_activation_hook( __FILE__ , 'activate_gat_plugin' );
function activate_gat_plugin(){
    //Create Tables used by GAT Plugin
    global $wpdb;
    
    $tables = array( "_rating" , "_ratingmeta" );
    $create_tables = array();
    
    foreach ($tables as $table){
        //Check if table exists
        $table = $wpdb->prefix . $table;
        if ($wpdb->get_var("SHOW TABLES like {$table}") !=  $table) {
            $creat_tables[] = $table;
        }
    }
    
    //If table for creation is not empty, create plugin tables
    if (!empty($create_tables)){
        create_tables($create_tables);
    }
}

function create_tables($tables){
    //create tables
    require_once( ABSPATH . "wp-admin/includes/upgrade.php" );
    foreach ($tables as $table){
        switch ($table){
            case $wpdb->prefix."_rating":
                $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
                        `rating_id` int(11) NOT NULL AUTO_INCREMENT,
                        `rating_meta_id` int(11) NOT NULL,
                        `value` int(11) NOT NULL,
                        `label` text NOT NULL,
                        `description` longtext NOT NULL,
                        `display` tinyint(1) NOT NULL,
                        PRIMARY KEY (`rating_id`)
                      )";
                break;
            case $wpdb->prefix."_ratingmeta":
                $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
                        `rating_meta_id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` tinytext NOT NULL,
                        `description` longtext NOT NULL,
                        PRIMARY KEY (`rating_meta_id`)
                      )";
        }
        dbDelta($sql);
    }
}

//Register our menus in WP Admin
function register_gat_admin_menus(){
    //Add Response submenu under Assessment
    add_submenu_page( 'edit.php?post_type=assessment' , 'Responses' , 'Responses' , 'add_users' , 'view-responses' , 'view_responses' );
    
    //Add Ratings menu and sub-menus
    add_menu_page( 'Rating' , 'Rating' , 'add_users' , 'get-ratings' , '' , 'dashicons-awards' , 35 );
    add_submenu_page( 'get-ratings' , 'Rating' , 'All Ratings' , 'add_users' , 'get-ratings' , 'show_ratings' );
    add_submenu_page( 'get-ratings' , 'New Rating' , 'Add New' , 'add_users' , 'new-rating' , 'add_rating' );
    
    //Add Organizations menu and sub-menus
    add_menu_page( 'Organization' , 'Organization' , 'add_users' , 'get-organizations' , '' , 'dashicons-groups' , 40 );
    add_submenu_page( 'get-organizations' , 'Organizations' , 'All Organizations' , 'add_users' , 'get-organizations' , 'get_organizations' );
    add_submenu_page( 'get-organizations' , 'New Organization' , 'Add New' , 'add_users' , 'new-organization' , 'add_organization' );
    add_submenu_page( 'get-organizations' , 'Import Organizations' , 'Import' , 'add_users' , 'import-organization' , 'import_organizations' );
}
add_action( 'admin_menu' , 'register_gat_admin_menus' );
?>