<?php
/**
 * The Header template for our theme
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri();?>/images/favicon.ico" type="image/x-icon">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="container-fluid">
	<div class="container">
    
        <div class="row hdr">
        	<div class="col-md-7 col-sm-8 col-xs-12">
            	<a href="<?php echo site_url();?> ">
                	<img src="<?php echo get_stylesheet_directory_uri();?>/images/logo.png" alt="Home"/>
                </a>
            </div>
            
            <div class="col-md-3 col-sm-4 col-xs-12 col-md-offset-2">
            
            	<div class="col-md-12 col-sm-12 col-xs-5">
                	<div class="form-group has-feedback gray_bg">
                    	
                        <form id="searchform" class="searchform" action="<?php echo site_url();?>" method="get" role="search">
                        	<input type="text" class="form-control" id="inputSuccess2" placeholder="Search" name="s" />
                      		<a href="javascript:" onClick="jQuery(this).closest('form').submit()">
                                <span class="form-control-feedback ">
                              		<img src="<?php echo get_stylesheet_directory_uri();?>/images/search_icn.png" alt="Search"/>
                                </span>
                            </a>
                        </form>
                       
                    </div>
                </div>
                
                <?php
					define("twitter_url", get_option("twitter_url"));
					define("facebook_url", get_option("facebook_url"));
					define("yotube_url", get_option("yotube_url"));
					define("google_url", get_option("google_url"));
					define("linkedin_url", get_option("linkedin_url"));
					define("linktonwltr", get_option("linktonwltr"));	
				?>
               
                <div class="col-md-11 col-sm-12 col-xs-5 col-xs-offset-2 col-md-offset-1 soclize">
                	<a href="<?php echo twitter_url;?>" target="_blank">
                    	<span class="socl_icns fa-stack"><i class="fa fa-twitter fa-stack-2x"></i></span>
                    </a>
                    <a href="<?php echo facebook_url;?>" target="_blank">
                    	<span class="socl_icns fa-stack"><i class="fa fa-facebook fa-stack-2x"></i></span>
                    </a>
                    <a href="<?php echo yotube_url;?>" target="_blank">
                    	<span class="socl_icns fa-stack"><i class="fa fa-youtube-play fa-stack-2x"></i></span>
                    </a>
                    <a href="<?php echo google_url;?>" target="_blank">
                    	<span class="socl_icns fa-stack"><i class="fa fa-google-plus fa-stack-2x"></i></span>
                    </a>
                    <a href="<?php echo linktonwltr;?>" target="_blank">
                    	<span class="socl_icns fa-stack"><i class="fa fa-envelope fa-stack-2x"></i></span>
                    </a>
                </div>
                
            </div>
        </div>
        
        <div class="row top_strp"></div>
        <div class="row navi_bg">
        	<div class="main-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
            </div>
            
            <span class="navi_icn fa-stack"><i class="fa fa-bars fa-stack-2x"></i></span>
            <div class="responsiv-menu">
            	<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'responsiv-menu_ul' ) ); ?>
            </div>
            
        </div>