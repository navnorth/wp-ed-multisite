<?php
/**
 * The Header template for our theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- force IE to disable compatibility mode on IE9+, due to ed.gov intranet... this must be first in HEAD -->
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge;IE=11;IE=10;IE=9" />-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php wp_title('|', true, 'left'); ?></title>
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <?php wp_head(); ?>
    <?php echo oese_ga_script(); ?>
    <?php $site_title = get_bloginfo(); ?>
</head>

<!--[if IE 7]>
<body <?php body_class("ie ie7"); ?>>
<![endif]-->
<!--[if IE 8]>
<body <?php body_class("ie ie8"); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<body <?php body_class(); ?>>
<!--<![endif]-->
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp_nn_theme' ); ?></a>
<input type="hidden" name="screenWidth" id="screenWidth" value="">
<!-- Container -->
<div class="container-fluid">
    <div class="container">

         <!--Div seperator-->
        <div class="row mr-0 ml-0">
            <div class="col-md-12 pr-0 pl-0">
                <div class="seperate-dark-blue-border"></div>
            </div>
        </div>

        <div class="row top-nav-spacing">
           <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-9">
                <a class="oese-logo-home" href="<?php echo site_url(); ?>" Title="Home">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg"
                         alt="U.S. Department of Education United States of America, Office of Elementary &amp; Secondary Education" class="svg-replace" id="header_logo"/>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12 offset-xl-2 offset-lg-2 offset-md-1 d-sm-inline-block d-block d-md-block d-lg-block d-xl-block">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6 topbar-search-section">
                        <div class="form-group has-feedback gray_bg">
                            <form id="searchform" class="searchform" action="<?php echo site_url(); ?>" method="get"
                                  role="search">
                                <div class="input-group to-focus">
                                    <label class="search-label" for="inputSuccess2">Search:</label>
                                    <input type="text" class="form-control top-search-input" id="inputSuccess2" placeholder="Search" name="s"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary custom-search-btn" type="button" onClick="jQuery(this).closest('form').submit()">
                                            <i class="fas fa-search"></i><span class="search-button-label">Search</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mobile-nav-bar">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-menu navi_bg">
                    <?php
                    $menu_name = "primary";
                    $locations = get_nav_menu_locations();
                    $menu = wp_get_nav_menu_object($locations["$menu_name"]);
                    $menuitems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC'));
                    wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu', 'walker' => new oii_walker_nav_menu($menuitems)));
                    ?>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 responsive-menu-section">
                <span class="navi_icn fa-stack mobile-nav-icons"><i class="fas fa-bars fa-stack-2x"></i></span>
                <div class="responsiv-menu">
                    <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'responsiv-menu_ul')); ?>
                </div>
            </div>
        </div>

         <div class="row breadcrumbs-section mr-0 ml-0">
            <?php
            if (!is_front_page() && !is_search()){
                if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); }
            }
            ?>
        </div>


