<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package wp_oese_theme
 * @since 1.5.0
 */
?>
<?php if ('resource'==get_post_type()): ?>
    <?php
        get_template_part('template-parts/nalrc/footer');
    ?>
    </div>
<?php endif; ?>
<?php
$menuLocations = get_nav_menu_locations();
$menuID = $menuLocations['footer'];
$footerNav = wp_get_nav_menu_items($menuID);
$childMenuItems = array();
$parentMenuItems = array();
$items= array();

if($footerNav) {
    foreach ($footerNav as $key => $navItems) {
       // print_r($navItems);
        if($navItems->menu_item_parent == 0){
            $parentMenuItems[$navItems->ID]=array('title'=>$navItems->title,'url'=>$navItems->url);
        }
        else{
            $childMenuItems[$navItems->menu_item_parent][]=array('title'=>$navItems->title,'url'=>$navItems->url);
        }
    }
}

$show_address = get_option('wp_oese_theme_display_footer_address');
    ?>     
          <div class="oese-footer-section">
            <div class="row oese-date-modified-section">
              <div class="col-md-12 oese-lastModified pull-right">
                  <span>Last Modified: <?php echo the_modified_date('m/d/Y') ?></span>
              </div>
            </div>  
            <div class="row">
                <div class="col-md-12">
                    <div class="row custom-common-padding footer-main-section mr-0 ml-0">
                    <?php
                    $parentIndex = 1;
                    $parentItemCount = count($parentMenuItems);

                    foreach ($parentMenuItems as $key => $menuItems) {
                        ?>
                        <div class="footer-menu-item-wrap">
                            <div class="footer-title">
                                <p><a href="<?php echo $menuItems['url']; ?>"><?php echo $menuItems['title']; ?></a></p>
                            </div>
                            <div class="footer-sub-menu">
                            <?php
                                if (isset($childMenuItems[$key])) {
                                $childMenu = $childMenuItems[$key];
                                    if($childMenu){ ?>
                                        <ul class='sub-menu-links'>
                                        <?php  foreach ($childMenu as $key => $value) { ?>
                                            <li>
                                                <a href="<?php echo $value['url']; ?>">
                                                    <?php echo $value['title']; ?>
                                                </a>
                                            </li>
                                       <?php  } ?>
                                        </ul>
                                        <?php
                                    }
                                }
                                if (($parentIndex==$parentItemCount) && !empty($show_address)){
                                   ?>
                                   <div class="address">
                                        U.S. Department of Education
                                        <br />
                                        400 Maryland Ave SW
                                        <br />
                                        Washington D.C. 20202-6244
                                    </div>
                                   <?php
                                }
                            ?>
                            </div>
                        </div>
                        <?php
                        $parentIndex++;
                    } ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row bottom-footer-section mr-0 ml-0">
                        <div class="col-md-2">
                            <div class="footer-bottom-left-logo">
                                <a href="https://www.ed.gov/" title="U.S. Department of Education Home (opens in new window)">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer_logo.png" alt="U.S. Department of Education Logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="footer-bottom-right-links text-right">
                                <?php
                                $menu_location = "sub-footer";
                                if ( has_nav_menu($menu_location) )
                                wp_nav_menu(array('theme_location' => $menu_location, 'menu_class' => 'nav-menu nav-sub-footer'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
<?php wp_footer(); ?>
</body>
</html>
