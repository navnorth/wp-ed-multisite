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
        <div class="row ftr">
            <div class="col-md-12 col-sm-12 col-xs-12 ftr_strp"></div>
            <div class="col-md-10 col-sm 10 col-xs-10 ftr_lnks">
               <?php wp_nav_menu( array('menu' => "Footer Menu") );?>
            </div>
            <div class="col-md-2 col-sm- col-xs-2 text-right ftr_logo">
                <a href="https://www.ed.gov" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/footer_logo.png" alt="Logo"/></a>
            </div>
        </div>

    </div>
</div>
<?php wp_footer(); ?>
<!--[if lt IE 10]>
<!--<script src="<?php //echo get_stylesheet_directory_uri(); ?>/js/ie-menu.js" type="text/javascript"></script>-->
<![endif]-->
</body>
</html>
