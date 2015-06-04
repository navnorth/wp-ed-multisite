<?php
/*
 Plugin Name: Future-Ready Gap Analysis Tool
 Plugin URI: http://www.navigationnorth.com/wordpress/gat-tool
 Description: This a future-ready Gap Analysis Tool plugin of Navigation North.
 Version: 0.1.1
 Author: Navigation North
 Author URI: http://www.navigationnorth.com

 Copyright (C) 2015 Navigation North

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
 
global $wpdb;
define( 'GAT_PATH' , plugin_dir_path(__FILE__) );
define( 'GAT_URL' , plugin_dir_url(__FILE__) );
define( 'PLUGIN_DOMAIN' , plugin_basename(__FILE__) );
define( 'PLUGIN_PREFIX' , 'gat_'.$wpdb->prefix);

register_activation_hook(__FILE__,'gat_table_create_function');
function gat_table_create_function()
{
	//creating custom tables
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $table_name = PLUGIN_PREFIX . "rating";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
		rating_id int(11) NOT NULL AUTO_INCREMENT,
		rating_meta_id int(11) NOT NULL,
		value int(11) NOT NULL,
		label text NOT NULL,
		description longtext NOT NULL,
		display tinyint(1) NOT NULL,
		PRIMARY KEY (rating_id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
    dbDelta($sql);
	
	$table_name = PLUGIN_PREFIX . "ratingmeta";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        rating_meta_id int(11) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		description longtext NOT NULL,
		PRIMARY KEY (rating_meta_id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);
	
	$table_name = PLUGIN_PREFIX . "dimensions";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        id int(11) NOT NULL AUTO_INCREMENT,
		assessment_id int(11) NOT NULL,
		domain_id int(11) NOT NULL,
		title tinytext NOT NULL,
		description longtext NOT NULL,
		PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);
	
	$table_name = PLUGIN_PREFIX . "videos";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        id int(11) NOT NULL AUTO_INCREMENT,
		domain_id int(11) NOT NULL,
		dimensions_id int(11) NOT NULL,
		label tinytext NOT NULL,
		youtubeid tinytext NOT NULL,
		rating_scale varchar(250) NOT NULL,
		PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);
	
	$table_name = PLUGIN_PREFIX . "response";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        id int(11) NOT NULL AUTO_INCREMENT,
		assessment_id int(11) NOT NULL,
		token varchar(250) NOT NULL,
		email varchar(250) NOT NULL,
		email_verified varchar(250) NOT NULL,
		state varchar(250) NOT NULL,
		organization_id varchar(250) NOT NULL,
		organization text NOT NULL,
		start_date datetime NOT NULL,
		last_saved datetime NOT NULL,
		progress varchar(250) NOT NULL,
		overall_score varchar(250) NOT NULL,
		PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);
	
	$table_name = PLUGIN_PREFIX . "results";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        id int(11) NOT NULL AUTO_INCREMENT,
		assessment_id int(11) NOT NULL,
		domain_id int(11) NOT NULL,
		dimension_id int(11) NOT NULL,
		token varchar(250) NOT NULL,
		rating_scale varchar(250) NOT NULL,
		PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);
	
	$table_name = PLUGIN_PREFIX . "organizations";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
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
	  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);
}

//filte template for front end
add_filter( 'template_include', 'gat_template_loader' );
function gat_template_loader($template)
{
	$file = '';
	if ( is_single() && get_post_type() == 'assessment' )
	{
		$file  = 'single-assessment.php';
		$path  = GAT_PATH."templates/".$file;
	}
	elseif (is_post_type_archive( 'assessment' ))
	{
		$file 	= 'archive-assessment.php';
		$path  = GAT_PATH."templates/".$file;
	}
	
	if ( isset($path) && !empty($path) )
	{
		$template = $path;
	}

	return $template;
}
//Functions for load template
function get_assessment_template_part( $slug, $name = null )
{
	do_action( "get_assessment_template_part{$slug}", $slug, $name );

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates[] = "{$slug}-{$name}.php";

	$templates[] = "{$slug}.php";

	locate_assessment_template($templates, true, false);
}
function locate_assessment_template($template_names, $load = false, $require_once = true )
{
	$located = '';
	foreach ( (array) $template_names as $template_name )
	{
		if ( !$template_name )
			continue;
		if ( file_exists(GAT_PATH . 'templates/' . $template_name))
		{
			$located = GAT_PATH . 'templates/' . $template_name;
			break;
		}
	}

	if ( $load && '' != $located )
		load_assessment_template( $located, $require_once );

	return $located;
}
function load_assessment_template( $_template_file, $require_once = true )
{
	global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

	if ( is_array( $wp_query->query_vars ) )
		extract( $wp_query->query_vars, EXTR_SKIP );

	if ( $require_once )
		require_once( $_template_file );
	else
		require( $_template_file );
}
include_once( GAT_PATH ."/functions.php" );
include_once( GAT_PATH ."/gat_state.php" );
include_once( GAT_PATH ."/includes/init.php" );
include_once( GAT_PATH ."/includes/save-post.php" );
include_once( GAT_PATH ."/includes/ajax.php" );