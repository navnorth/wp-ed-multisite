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
include_once( GAT_PATH ."/includes/organization.php" );

register_activation_hook( __FILE__ , 'activate_gat_plugin' );
function activate_gat_plugin(){
    //Create Tables used by GAT Plugin
    global $wpdb;
    
    $tables = array( "rating" , "ratingmeta" , "organizations" );
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
            case $wpdb->prefix."rating":
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
            case $wpdb->prefix."ratingmeta":
                $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
                        `rating_meta_id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` tinytext NOT NULL,
                        `description` longtext NOT NULL,
                        PRIMARY KEY (`rating_meta_id`)
                      )";
                break;
            case $wpdb->prefix."organizations":
                $sql = "CREATE TABLE IF NOT EXISTS `gat_organizations` (
                        `organization_id` bigint(20) NOT NULL AUTO_INCREMENT,
                        `FIPST` char(2) NOT NULL COMMENT 'ANSI1 State Code',
                        `LEAID` char(9) NOT NULL COMMENT 'NCES Local Education Agency ID',
                        `SCHNO` char(7) NOT NULL COMMENT 'NCES School ID',
                        `STID` char(5) NOT NULL COMMENT 'State Local Education Agency ID',
                        `SEASCH` char(6) NOT NULL COMMENT 'State School ID',
                        `LEANM` text NOT NULL COMMENT 'Name of Education Agency',
                        `SCHNAM` text NOT NULL COMMENT 'Name of School',
                        `PHONE` char(12) NOT NULL COMMENT 'Area code + Telephone Number',
                        `MSTREE` text NOT NULL COMMENT 'Mailing Street',
                        `MCITY` text NOT NULL COMMENT 'Mailing City',
                        `MSTATE` char(2) NOT NULL COMMENT 'Mailing State (PO Abbreviation)',
                        `MZIP` char(5) NOT NULL COMMENT 'Mailing ZIP Code',
                        `MZIP4` char(9) NOT NULL COMMENT 'Mailing ZIP Code + 4',
                        `LSTREE` text NOT NULL COMMENT 'Location Street',
                        `LCITY` text NOT NULL COMMENT 'Location City',
                        `LSTATE` char(2) NOT NULL COMMENT 'Location State',
                        `LZIP` char(5) NOT NULL COMMENT 'Location Zip Code',
                        `LZIP4` char(9) NOT NULL COMMENT 'Location Zip Code + 4',
                        `TYPE` tinyint(2) NOT NULL COMMENT 'School Type Code [1] Regular school [2] Special education school 3: Vocational education school 4:  Alternative/other school 5: Reportable programSchool Type Code [1] Regular school [2] Special education school [3] Vocational education school [4]  Alternative/other school [5] Reportable program',
                        `STATUS` tinyint(2) NOT NULL COMMENT 'Operational Status Code [1] School was operational at the time of the last report and is currently operational [2] School has closed since the time of the last report [3] School has been opened since the time of the last report [4] School was in existence, but not reported in a previous year’s CCD school universe survey, and is now being added [5] School was listed in previous year’s CCD school universe as being affiliated with a different education agency [6] School is temporarily closed and may reopen within 3 years [7] School is scheduled to be operational within 2 years [8] School was closed on a previous year’s file but has reopened',
                        `UNION` char(3) NOT NULL COMMENT ' Supervisory Union Identification Number',
                        `ULOCAL` tinyint(2) NOT NULL COMMENT 'Urban-centric Locale Code [11] City, Large [12] City, Midsize [13] City, Small [21] Suburb, Large [22] Suburb, Midsize [23] Suburb, Small [31] Town, Fringe [32] Town, Distant [33] Town, Remote [41] Rural, Fringe [42]  Rural, Distant [43] Rural, Remote',
                        `LATCOD` decimal(10,6) NOT NULL COMMENT 'Latitude',
                        `LONCOD` decimal(10,6) NOT NULL COMMENT 'Longitude',
                        `CONUM` char(5) NOT NULL COMMENT 'ANSI County Code',
                        `CONAME` text NOT NULL COMMENT 'County Name',
                        `CDCODE` char(4) NOT NULL COMMENT '113th Congressional District Code',
                        `GSLO` char(2) NOT NULL COMMENT 'Low Grade Span Offered',
                        `GSHI` char(2) NOT NULL COMMENT 'High Grade Span Offered',
                        `CHARTR` char(1) NOT NULL COMMENT 'Charter Status [1] Yes [2] No',
                        PRIMARY KEY (`organization_id`)
                      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
                break;
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