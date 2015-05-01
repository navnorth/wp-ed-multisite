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

include_once( GAT_PATH ."/includes/assessment.php" );

//Register our menus in WP Admin
function register_gat_admin_menus(){
    // Add Assesment menu and sub-menus
    add_menu_page( 'Assessment' , 'Assessment' , 'add_users' , 'get-assessments' , '' , 'dashicons-list-view' , 25 );
    add_submenu_page( 'get-assessments' , 'Assessment' , 'All Assessments' , 'add_users' , 'get-assessments' , 'get_assessments' );
    add_submenu_page( 'get-assessments' , 'New Assessment' , 'Add New' , 'add_users' , 'new-assessment' , 'create_assessment' );
    //Add Response submenu
    add_submenu_page( 'get-assessments' , 'Responses' , 'Responses' , 'add_users' , 'view-responses' , 'view_responses' );
    
    // Add Domains menu and sub-menus
    add_menu_page( 'Domain' , 'Domain' , 'add_users' , 'get-domains' , '' , 'dashicons-admin-site' , 30 );
    add_submenu_page( 'get-domains' , 'Domain' , 'All Domains' , 'add_users' , 'get-domains' , 'get_domains' );
    add_submenu_page( 'get-domains' , 'New Domain' , 'Add New' , 'add_users' , 'new-domain' , 'add_domain' );
    
    //Add Ratings menu and sub-menus
    add_menu_page( 'Rating' , 'Rating' , 'add_users' , 'get-ratings' , '' , 'dashicons-awards' , 35 );
    add_submenu_page( 'get-ratings' , 'Rating' , 'All Ratings' , 'add_users' , 'get-ratings' , 'get_ratings' );
    add_submenu_page( 'get-ratings' , 'New Rating' , 'Add New' , 'add_users' , 'new-rating' , 'add_rating' );
    
    //Add Organizations menu and sub-menus
    add_menu_page( 'Organization' , 'Organization' , 'add_users' , 'get-organizations' , '' , 'dashicons-groups' , 40 );
    add_submenu_page( 'get-organizations' , 'Organizations' , 'All Organizations' , 'add_users' , 'get-organizations' , 'get_organizations' );
    add_submenu_page( 'get-organizations' , 'New Organization' , 'Add New' , 'add_users' , 'new-organization' , 'add_organization' );
    add_submenu_page( 'get-organizations' , 'Import Organizations' , 'Import' , 'add_users' , 'import-organization' , 'import_organizations' );
}
add_action( 'admin_menu' , 'register_gat_admin_menus' );
?>