<?php
// Enqueue inline footnotes script
function enqueue_inline_footnotes_script(){
    wp_enqueue_script('oet-inline-footnotes', get_stylesheet_directory_uri().'/blocks/footnotes/jquery-inline-footnotes-min.js');
}
add_action( 'wp_enqueue_scripts', 'enqueue_inline_footnotes_script', 20 );

function oet_init_inline_footnote(){
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('sup').each(function(){
                if ($(this).find('a').length){
                    let num = $(this).find('a').text();
                    $(this).attr('id','fnref:'+num);
                    $(this).find('a').attr('rel','footnote');
                }
            });
          $("[rel=footnote]").inlineFootnote();
        });
    </script>
    <?php
}
add_action( 'wp_footer' , 'oet_init_inline_footnote' );

// Initialize block
function oet_footnotes_block_init(){
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/footnotes/';
    $version_58 = is_version_58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "oet-block/oet-publication-intro-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-footnotes-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-footnotes-block-editor', 'oet_footnotes', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => false, 'back_icon' => get_stylesheet_directory_uri().'/images/footnote-back-icon.svg' ) );


    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-footnotes-block-editor-style',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-footnotes-block-style',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 'oet-block/oet-footnotes-block', array(
        'editor_script' => 'oet-footnotes-block-editor',
        'editor_style'  => 'oet-footnotes-block-editor-style',
        'style'         => 'oet-footnotes-block-style',
    ) );
}

// Register Block via block.json
function oet_footnotes_block_json_init() {
    $dir = dirname(__FILE__);
    $dir_url = get_stylesheet_directory_uri().'/blocks/footnotes/';
    $version_58 = is_version_58();

    $script_asset_path = "$dir/build/index.asset.php";
    if ( ! file_exists( $script_asset_path ) ) {
        throw new Error(
            'You need to run `npm start` or `npm run build` for the "create-block/oer-object-resources-block" block first.'
        );
    }
    $index_js     = 'build/index.js';
    $script_asset = require( $script_asset_path );
    wp_register_script(
        'oet-footnotes-block-editor',
        $dir_url . $index_js,
        $script_asset['dependencies'],
        $script_asset['version']
    );
    wp_localize_script( 'oet-footnotes-block-editor', 'oet_footnotes', array( 'home_url' => home_url(), 'ajax_url' => admin_url( 'admin-ajax.php' ), 'version_58' => $version_58 ) );

    $editor_css = 'build/index.css';
    wp_register_style(
        'oet-footnotes-block-editor',
        $dir_url . $editor_css,
        array(),
        filemtime( "$dir/$editor_css" )
    );

    $style_css = 'build/style-index.css';
    wp_register_style(
        'oet-footnotes-block-style',
        $dir_url . $style_css,
        array(),
        filemtime( "$dir/$style_css" )
    );

    register_block_type( 
        __DIR__ ,
        array(
            'editor_script' => 'oet-footnotes-block-editor',
            'editor_style'  => 'oet-footnotes-block-editor',
            'style'         => 'oet-footnotest-block-style',
        )
    );
}

// Checks WP version
if (!function_exists('is_version_58')) {
    function is_version_58(){
        if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
            return false;
        } else {
            return true;
        }
    }
}

add_action( 'init', 'oet_footnotes_block_init' );
// Checks WP version to register block via block json if version is 5.8 or later
/**--if ( is_version_58() ) {
    add_action( 'init', 'oet_footnotes_block_json_init' );
} else {
    add_action( 'init', 'oet_footnotes_block_init' );
}--**/
?>