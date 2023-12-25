<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>      
        <?php if (get_option('disclaimer')): ?>
    <div id="disclaimer_footer"><?php echo get_option('disclaimer'); ?></div>
    <?php endif; ?>
        <div class="row ftr oet-footer">
            <!--<div class="col-md-12 col-sm-12 col-xs-12 ftr_strp"></div>-->
            <div class="oet-footer-seal">
              <img src="<?php echo get_stylesheet_directory_uri();?>/images/footer_seal_white.png" alt="ED.gov Logo"/>
            </div>
            <div class="ftr_lnks">
               <?php wp_nav_menu( array('menu' => "Footer Menu") );?>
            </div>
            <div class="col-md-2 col-sm- col-xs-2 text-right ftr_logo pull-right">
              <a href="https://www.ed.gov" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/footer_logo_white.png" alt="ED.gov Logo"/></a>
            </div>
        </div>

    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
