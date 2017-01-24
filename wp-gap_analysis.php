<?php
/*
 Plugin Name:  Gap Analysis Tool
 Plugin URI:   https://www.navigationnorth.com/solutions/wordpress/gap-analysis-plugin
 Description:  The Gap Analysis Tool provides users with custom content based on a self-assessment. Developed by Navigation North, in collaboration with AIR, for the Future Ready Leaders program.
 Version:      0.2.9
 Author:       Navigation North
 Author URI:   https://www.navigationnorth.com
 Text Domain:  wp-gap-analysis
 License:      GPL3
 License URI:  https://www.gnu.org/licenses/gpl-3.0.html

 Copyright (C) 2017 Navigation North

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

global $wpdb, $gat_session;
define( 'GAT_PATH' , plugin_dir_path(__FILE__) );
define( 'GAT_URL' , plugin_dir_url(__FILE__) );
define( 'PLUGIN_DOMAIN' , plugin_basename(__FILE__) );
define( 'PLUGIN_PREFIX' , $wpdb->prefix.'gat_');

// Plugin Name and Version
define( 'GAT_PLUGIN_NAME', 'Gap Analysis Tool' );
define( 'GAT_PLUGIN_VERSION', '0.2.9' );
define( 'GAT_PLUGIN_INFO', 'https://www.navigationnorth.com/solutions/wordpress/gap-analysis-plugin' );

/*Score Limit*/
define( 'SCORE_HIGH_UPPER' , 4);
define( 'SCORE_HIGH_DOWN' , 2.5);
define( 'SCORE_LOW_UPPER' , 1.5);
define( 'SCORE_LOW_DOWN' , 0);

register_activation_hook(__FILE__,'gat_table_create_function');
function gat_table_create_function()
{
	//creating custom tables
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $table_name = PLUGIN_PREFIX . "dimensions";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        id int(11) NOT NULL AUTO_INCREMENT,
		assessment_id int(11) NOT NULL,
		domain_id int(11) NOT NULL,
		title tinytext NOT NULL,
		description longtext NOT NULL,
        dimension_order tinyint(4) NOT NULL,
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
		district varchar(250) NOT NULL,
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

	$table_name = PLUGIN_PREFIX . "resulted_video";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        id int(11) NOT NULL AUTO_INCREMENT,
		assessment_id int(11) NOT NULL,
		domain_id int(11) NOT NULL,
		dimensions_id int(11) NOT NULL,
		token varchar(250) NOT NULL,
		youtubeid varchar(250) NOT NULL,
		start varchar(250) NOT NULL,
		end varchar(250) NOT NULL,
		seek varchar(250) NOT NULL,
		PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	dbDelta($sql);

	$table_name = PLUGIN_PREFIX . "organizations";
    $sql = "CREATE TABLE IF NOT EXISTS ". $table_name ."(
        `organization_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`FIPST` char(2) NOT NULL,
		`LEAID` char(9) NOT NULL,
		`SCHNO` char(7) NOT NULL,
		`STID` char(5) NOT NULL,
		`SEASCH` char(6) NOT NULL,
		`LEANM` text NOT NULL,
		`SCHNAM` text NOT NULL,
		`PHONE` char(12) NOT NULL,
		`MSTREE` text NOT NULL,
		`MCITY` text NOT NULL,
		`MSTATE` char(2) NOT NULL,
		`MZIP` char(5) NOT NULL,
		`MZIP4` char(9) NOT NULL,
		`LSTREE` text NOT NULL,
		`LCITY` text NOT NULL,
		`LSTATE` char(2) NOT NULL,
		`LZIP` char(5) NOT NULL,
		`LZIP4` char(9) NOT NULL,
		`TYPE` tinyint(2) NOT NULL,
		`STATUS` tinyint(2) NOT NULL,
		`UNION` char(3) NOT NULL,
		`ULOCAL` tinyint(2) NOT NULL,
		`LATCOD` decimal(10,6) NOT NULL,
		`LONCOD` decimal(10,6) NOT NULL,
		`CONUM` char(5) NOT NULL,
		`CONAME` text NOT NULL,
		`CDCODE` char(4) NOT NULL,
		`GSLO` char(2) NOT NULL,
		`GSHI` char(2) NOT NULL,
		`CHARTR` char(1) NOT NULL,
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
?>
