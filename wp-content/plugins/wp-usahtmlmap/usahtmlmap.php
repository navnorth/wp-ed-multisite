<?php
/*
Plugin Name: Interactive Map of the USA for WP Bypass
Plugin URI: https://www.fla-shop.com
Description: High-quality map plugin of the USA for WordPress. The map depicts states and features color, font, landing page and popup customization
Text Domain: usacustom-html5-map
Domain Path: /languages
Version: 3.1.9
Author: Fla-shop.com and Navigation North
Author URI: https://www.fla-shop.com
License:
*/


require_once('popupbuilder.php');
add_action('plugins_loaded', 'usacustom_html5map_plugin_load_domain' );
function usacustom_html5map_plugin_load_domain() {
    load_plugin_textdomain( 'usacustom-html5-map', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
if (isset($_REQUEST['action']) && $_REQUEST['action']=='usacustom-html5-map-export') { usacustom_html5map_plugin_export(); }
if (isset($_REQUEST['action']) && $_REQUEST['action']=='usacustom-html5-map-export-csv') { usacustom_html5map_plugin_export_csv(); }

add_action('admin_menu', 'usacustom_html5map_plugin_menu');


function usacustom_html5map_plugin_menu() {

    global $wp_roles;

    $role = "usacustomhtml5map_manage_role";

    add_menu_page(__('USA Map', 'usacustom-html5-map'), __('USA Map', 'usacustom-html5-map'), $role, 'usacustom-html5-map-options', 'usacustom_html5map_plugin_options' );

    add_submenu_page('usacustom-html5-map-options', __('General Settings', 'usacustom-html5-map'), __('General Settings', 'usacustom-html5-map'), $role, 'usacustom-html5-map-options', 'usacustom_html5map_plugin_options' );
    add_submenu_page('usacustom-html5-map-options', __('Detailed settings', 'usacustom-html5-map'), __('Detailed settings', 'usacustom-html5-map'), $role, 'usacustom-html5-map-states', 'usacustom_html5map_plugin_states');
    add_submenu_page('usacustom-html5-map-options', __('Groups settings', 'usacustom-html5-map'), __('Groups settings', 'usacustom-html5-map'), $role, 'usacustom-html5-map-groups', 'usacustom_html5map_plugin_groups');
    add_submenu_page('usacustom-html5-map-options', __('Points settings', 'usacustom-html5-map'), __('Points settings', 'usacustom-html5-map'), $role, 'usacustom-html5-map-points', 'usacustom_html5map_plugin_points');
    add_submenu_page('usacustom-html5-map-options', __('Tools', 'usacustom-html5-map'), __('Tools', 'usacustom-html5-map'), $role, 'usacustom-html5-map-tools', 'usacustom_html5map_plugin_tools');
    add_submenu_page('usacustom-html5-map-options', __('Map Preview', 'usacustom-html5-map'), __('Map Preview', 'usacustom-html5-map'), $role, 'usacustom-html5-map-view', 'usacustom_html5map_plugin_view');

    add_submenu_page('usacustom-html5-map-options', __('Maps dashboard', 'usacustom-html5-map'), __('Maps', 'usacustom-html5-map'), $role, 'usacustom-html5-map-maps', 'usacustom_html5map_plugin_maps');



}

function usacustom_html5map_plugin_nav_tabs($page, $map_id)
{
?>
<h2 class="nav-tab-wrapper">
    <a href="?page=usacustom-html5-map-options&map_id=<?php echo $map_id ?>" class="nav-tab <?php echo $page == 'options' ? 'nav-tab-active' : '' ?>"><?php _e('General settings', 'usacustom-html5-map') ?></a>
    <a href="?page=usacustom-html5-map-states&map_id=<?php echo $map_id ?>" class="nav-tab <?php echo $page == 'states' ? 'nav-tab-active' : '' ?>"><?php _e('Detailed settings', 'usacustom-html5-map') ?></a>
    <a href="?page=usacustom-html5-map-groups&map_id=<?php echo $map_id ?>" class="nav-tab <?php echo $page == 'groups' ? 'nav-tab-active' : '' ?>"><?php _e('Groups settings', 'usacustom-html5-map') ?></a>
    <a href="?page=usacustom-html5-map-points&map_id=<?php echo $map_id ?>" class="nav-tab <?php echo $page == 'points' ? 'nav-tab-active' : '' ?>"><?php _e('Points settings', 'usacustom-html5-map') ?></a>
    <a href="?page=usacustom-html5-map-tools&map_id=<?php echo $map_id ?>" class="nav-tab <?php echo $page == 'tools' ? 'nav-tab-active' : '' ?>"><?php _e('Tools', 'usacustom-html5-map') ?></a>
    <a href="?page=usacustom-html5-map-view&map_id=<?php echo $map_id ?>" class="nav-tab <?php echo $page == 'view' ? 'nav-tab-active' : '' ?>"><?php _e('Preview', 'usacustom-html5-map') ?></a>
</h2>
<?php
}

function usacustom_html5map_plugin_map_selector($page, $map_id, &$options) {
?>
<script type="text/javascript">
jQuery(function($){
    $('select[name=map_id]').change(function() {
        location.href='admin.php?page=usacustom-html5-map-<?php echo $page ?>&map_id='+$(this).val();
    });
    $('.tipsy-q').tipsy({gravity: 'w'}).find('span').css('cursor', 'default');
});
</script>
<span class="title" style="width: 100px"><?php echo __('Select a map:', 'usacustom-html5-map'); ?> </span>
    <select name="map_id" style="width: 185px;">
        <?php foreach($options as $id => $map_data) { ?>
            <option value="<?php echo $id; ?>" <?php echo ($id==$map_id) ? 'selected' : '';?>><?php echo $map_data['name'] . (isset($map_data['type']) ? " ($map_data[type])" : ''); ?></option>
        <?php } ?>
    </select>
    <span class="tipsy-q" original-title="<?php esc_attr_e('Select a map for editing and previewing', 'usacustom-html5-map'); ?>">[?]</span>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="admin.php?page=usacustom-html5-map-maps" class="page-title-action tipsy-q" original-title="<?php esc_attr_e('List of all maps, creating a new map, backup', 'usacustom-html5-map'); ?>"><?php _e('Maps dashboard', 'usacustom-html5-map'); ?></a>
<?php
}

function usacustom_html5map_plugin_messages($successes, $errors) {
    if ($successes and is_array($successes)) {
        echo "<div class=\"updated\"><ul>";
        foreach ($successes as $s) {
            echo "<li>" . (is_array($s) ? "<strong>$s[0]</strong>$s[1]" : $s) . "</li>";
        }
        echo "</ul></div>";
    }

    if ($errors and is_array($errors)) {
        echo "<div class=\"error\"><ul>";
        foreach ($errors as $s) {
            echo "<li>" . (is_array($s) ? "<strong>$s[0]</strong>$s[1]" : $s) . "</li>";
        }
        echo "</ul></div>";
    }
}

function usacustom_html5map_plugin_options() {
    include('editmainconfig.php');
}

function usacustom_html5map_plugin_states() {
    include('editstatesconfig.php');
}

function usacustom_html5map_plugin_tools() {
    include('maptools.php');
}

function usacustom_html5map_plugin_groups() {
    include('editgroupsconfig.php');
}
function usacustom_html5map_plugin_points() {
    include('editpointsconfig.php');
}
function usacustom_html5map_plugin_maps() {
    include('mapslist.php');
}

function usacustom_html5map_plugin_view() {

    $options = usacustom_html5map_plugin_get_options();
    $option_keys = is_array($options) ? array_keys($options) : array();
    $map_id  = (isset($_REQUEST['map_id'])) ? intval($_REQUEST['map_id']) : array_shift($option_keys) ;

?>
<div class="wrap usacustom-html5-map main full">
    <h2><?php _e('Map Preview', 'usacustom-html5-map') ?></h2>
    <br />
    <form method="POST" class="">
    <?php usacustom_html5map_plugin_map_selector('view', $map_id, $options) ?>
    <br /><br />
    </form>
    <style type="text/css">
        .usacustomHtml5MapBold {font-weight: bold}
    </style>
<?php
    usacustom_html5map_plugin_nav_tabs('view', $map_id);
    echo '<p>'.sprintf(__('Use shortcode %s for install this map', 'usacustom-html5-map'), '<span class="usacustomHtml5MapBold">[usacustomhtml5map id="'.$map_id.'"]</span>').'</p>';

    echo do_shortcode('<div style="width: 99%">[usacustomhtml5map id="'.$map_id.'"]</div>'); ?>
    </div>
<?php
}

add_action('admin_init','usacustom_html5map_plugin_scripts');

function usacustom_html5map_plugin_scripts(){
    if ( is_admin() ){

        wp_register_style('jquery-tipsy', plugins_url('/static/css/tipsy.css', __FILE__));
        wp_enqueue_style('jquery-tipsy');
        wp_register_style('usacustom-html5-map-adm', plugins_url('/static/css/mapadm.css', __FILE__), array(), 'r3.1.5');
        wp_enqueue_style('usacustom-html5-map-adm');
        wp_register_style('usacustom-html5-map-style', plugins_url('/static/css/map.css', __FILE__), array(), 'r3.1.5');
        wp_enqueue_style('usacustom-html5-map-style');
        wp_enqueue_style('farbtastic');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_script('farbtastic');
        wp_enqueue_script('tiny_mce');
        wp_register_script('jquery-tipsy', plugins_url('/static/js/jquery.tipsy.js', __FILE__));
        wp_enqueue_script('jquery-tipsy');
    }
    else {

        wp_register_style('usacustom-html5-map-style', plugins_url('/static/css/map.css', __FILE__), array(), 'r3.1.5');
        wp_enqueue_style('usacustom-html5-map-style');

        wp_register_script('raphael', plugins_url('/static/js/raphael.min.js', __FILE__));
        wp_enqueue_script('raphael');

        wp_enqueue_script('jquery');

    }

    wp_register_script('usacustom-html5-map-nicescroll', plugins_url('/static/js/jquery.nicescroll.js', __FILE__));
    wp_enqueue_script('usacustom-html5-map-nicescroll');
}

add_action('wp_enqueue_scripts', 'usacustom_html5map_plugin_scripts_method');

function usacustom_html5map_plugin_scripts_method() {
    wp_enqueue_script('jquery');
    wp_register_style('usacustom-html5-map-style', plugins_url('/static/css/map.css', __FILE__));
    wp_enqueue_style('usacustom-html5-map-style');

    wp_register_script('usacustom-html5-map-nicescroll', plugins_url('/static/js/jquery.nicescroll.js', __FILE__));
    wp_enqueue_script('usacustom-html5-map-nicescroll');
}


add_shortcode('usacustomhtml5map', 'usacustom_html5map_plugin_content');

function usacustom_html5map_plugin_enqueue_js($js = null) {
    static $arr = array();
    if ($js) {
        $arr[] = $js;
    } else {
        echo implode("", $arr);
    }
}

function usacustom_html5map_plugin_chk_color($val) {
    $val = sanitize_text_field($val);
    if ($val and $val[0] != '#')
        $val = '#' . $val;

    return $val;
}

function usacustom_html5map_plugin_chk_url($val) {
    if (strpos($val, 'javascript:') === 0)
        return $val;
    return esc_url($val, null, 'url');
}

function usacustom_html5map_plugin_escape_fonts($fonts, $addFonts = false) {
    $fonts = $fonts ? explode(',', $fonts) : array();
    if ($addFonts)
        $fonts = array_merge($fonts, explode(',', $addFonts));

    foreach ($fonts as &$f) {
        $f = '\''.trim($f, ' \'"').'\'';
    }
    return implode(',', $fonts);
}

function usacustom_html5map_plugin_strcmp($a, $b) {
    if (is_array($a) and isset($a['name'])) {
        $a = $a['id'];
        $b = $b['id'];
    } else if (is_object($a) and isset($a->name)) {
        $a = $a->id;
        $b = $b->id;
    } else {
        return 0;
    }
    return $a - $b;
    if (class_exists('\Collator')) {
        static $coll = null;
        if (is_null($coll)) {
            $coll = new \Collator("");
            $coll->setAttribute(\Collator::NUMERIC_COLLATION, \Collator::ON);
        }
        return $coll->compare($a, $b);
    }
    if (function_exists('strcoll')) {
        return strcoll($a, $b);
    }
    return strnatcmp($a, $b);
}

function usacustom_html5map_plugin_rstrcmp($a, $b) {
    return usacustom_html5map_plugin_strcmp($b, $a);
}

function usacustom_html5map_plugin_sort_regions_list(&$list, $sort = null) {
    $old = @setlocale(LC_COLLATE, 0);
    @setlocale(LC_COLLATE, 'en_US.utf8');
    if ($sort == 'asc') {
        uasort($list, 'usacustom_html5map_plugin_strcmp');
    } else if ($sort == 'desc') {
        uasort($list, 'usacustom_html5map_plugin_rstrcmp');
    }
    @setlocale(LC_COLLATE, $old);
}



function usacustom_html5map_plugin_prepare_tooltip_css($options, $prefix) {
    $commentCss = '';
    if ( ! empty($options['popupCommentColor'])) {
        $commentCss .= "\t\t\t\tcolor: $options[popupCommentColor];\n";
    }
    if ( ! empty($options['popupCommentFontSize'])) {
        $commentCss .= "\t\t\t\tfont-size: $options[popupCommentFontSize]px;\n";
    }
    if ( ! empty($options['popupCommentFontFamily'])) {
        $commentCss .= "\t\t\t\tfont-family: ".usacustom_html5map_plugin_escape_fonts($options['popupCommentFontFamily']).";\n";
    }

    $popupTitleCss = '';
    if ( ! empty($options['popupNameColor'])) {
        $popupTitleCss .= "\t\t\t\tcolor: $options[popupNameColor];\n";
    }
    if ( ! empty($options['popupNameFontSize'])) {
        $popupTitleCss .= "\t\t\t\tfont-size: $options[popupNameFontSize]px;\n";
    }
    if ( ! empty($options['popupNameFontFamily'])) {
        $popupTitleCss .= "\t\t\t\tfont-family: ".usacustom_html5map_plugin_escape_fonts($options['popupNameFontFamily']).";\n";
    }
    $result = "$prefix .fm-tooltip-name {
$popupTitleCss
}
$prefix .fm-tooltip-comment {
$commentCss
}
$prefix .fm-tooltip-comment p {
$commentCss
}";
    return $result;
}

function usacustom_html5map_plugin_escape_js_string($s, $q = '"') {
    return "$q" . str_replace($q, "\\$q", $s) . "$q";
}

function usacustom_html5map_plugin_get_map_js_url($options)
{
    $map_file          = plugins_url('/static/', __FILE__)."js/map.js";
    return $map_file;
}

function usacustom_html5map_plugin_get_static_url($url)
{
    return plugins_url('/static/', __FILE__).ltrim($url, '/');
}

function usacustom_html5map_plugin_get_raphael_js_url()
{
    return plugins_url('/static/', __FILE__)."js/raphael.min.js";
}

function usacustom_html5map_plugin_content($atts, $content) {
    static $firstRun = true;
    $dir               = plugins_url('/static/', __FILE__);
    $siteURL           = get_site_url();
    $options           = usacustom_html5map_plugin_get_options();
    $option_keys       = is_array($options) ? array_keys($options) : array();
    $toSelect          = array();
    $selectColors      = array();

    $map_id = isset($atts['id']) ? intval($atts['id']) : array_shift($option_keys);

    if (isset($options[$map_id])) {
        $options = $options[$map_id];
    } else {
        $map_id  = array_shift($option_keys);
        $options = array_shift($options);
    }
    if (isset($atts['select'])) {
        $toSelect = array_map('trim', explode(',', $atts['select']));
        $toSelect = preg_grep('/\S+/', $toSelect);

        if (count($toSelect) and (preg_match('/^#([\da-f]{3}|[\da-f]{6})/i', $toSelect[count($toSelect)-1]) or !preg_match('/^[a-z]{1,}\d+$/i', $toSelect[count($toSelect)-1])))
            array_unshift($selectColors, array_pop($toSelect));

        if (count($toSelect) and (preg_match('/^#([\da-f]{3}|[\da-f]{6})/i', $toSelect[count($toSelect)-1]) or !preg_match('/^[a-z]{1,}\d+$/i', $toSelect[count($toSelect)-1])))
            array_unshift($selectColors, array_pop($toSelect));
    }
    $defOptions = usacustom_html5map_plugin_map_defaults('', 1, true);
    foreach ($defOptions as $k => $v) {
        if (!isset($options[$k]))
            $options[$k] = $v;
    }
    $prfx              = "_$map_id";
    $isResponsive      = $options['isResponsive'];
    $stateInfoArea     = $options['statesInfoArea'];
    $respInfo          = $isResponsive ? ' htmlMapResponsive' : '';
    $type_id           = 0;
    $style             = (!empty($options['maxWidth']) && $isResponsive) ? 'max-width:'.intval($options['maxWidth']).'px' : '';

    static $count = 0;
    static $print_action_registered = false;

    $settings_file = usacustom_html5map_plugin_settings_url($map_id, $options);

    wp_register_script('raphaeljs', usacustom_html5map_plugin_get_raphael_js_url(), array(), 'r3.1.5');
    wp_register_script('usacustom-html5-map-mapjs_'.$type_id, usacustom_html5map_plugin_get_map_js_url($options), array('raphaeljs'), 'r3.1.5');
    wp_register_script('usacustom-html5-map-map_cfg_'.$map_id, $settings_file, array('raphaeljs', 'usacustom-html5-map-mapjs_'.$type_id));
    wp_enqueue_script('usacustom-html5-map-map_cfg_'.$map_id);

    $select_options = "";
    /**
     * A separation line will be putted after states with specified sids
     */
    $separatorAfter = array('st53');
    /**
     * Group options in groups
     * format:
     * 'sid1' => 'Group 1',
     * 'sid2' => 'Group 1',
     * 'sid6' => 'Group 2',
     */
    $groupedOptionsCfg = array(
        'st54' => 'Outlying Areas',
		'st55' => 'Outlying Areas',
		'st56' => 'Outlying Areas',
		'st57' => 'Outlying Areas',
		'st58' => 'Outlying Areas'
    );
    $groupedOptions = array();

    $states = json_decode($options['map_data'], true);
    usacustom_html5map_plugin_sort_regions_list($states, 'asc');
    foreach ($states as $sid => $s) {
        if ($options['areaListOnlyActive'] and !$s['link'])
            continue;
        if (isset($s['hidden']) and $s['hidden'])
            continue;
        if (isset($groupedOptionsCfg[$sid])) {
            $groupedOptions[$groupedOptionsCfg[$sid]][$sid] = $s;
            continue;
        }
        $select_options .= "\t<option value=\"$sid\">".htmlspecialchars($s['name'])."</option>\n";
        if (in_array($sid, $separatorAfter)) {
            $select_options .= "\t<option value=\"\" disabled=\"disabled\">----------------</option>\n";
        }
    }
    foreach ($groupedOptions as $groupName => $groupStates) {
        $select_options .= "\t<optgroup label=\"" . htmlspecialchars($groupName) . "\">\n";

        foreach ($groupStates as $sid => $s) {
            if ($options['areaListOnlyActive'] and !$s['link'])
            continue;
            if (isset($s['hidden']) and $s['hidden'])
                continue;

            $select_options .= "\t\t<option value=\"$sid\">".htmlspecialchars($s['name'])."</option>\n";
            if (in_array($sid, $separatorAfter)) {
                $select_options .= "\t\t<option value=\"\" disabled=\"disabled\">----------------</option>\n";
            }
        }
        $select_options .= "\t</optgroup>\n";
    }

    usacustom_html5map_plugin_popup_builder_enable_scripts($options, $states);
    $popupUrl = usacustom_html5map_plugin_ajax_url('group_info');
    $stateInfoUrl = usacustom_html5map_plugin_ajax_url('state_info', array('map_id' => $map_id, 'sid' => ''));
    $groupInfoUrl = usacustom_html5map_plugin_ajax_url('group_info', array('map_id' => $map_id, 'gid' => ''));

    $mapInit = "
        <!-- start Fla-shop.com HTML5 Map -->";
    $mapInit .= "
        <div class='usacustomHtml5Map$stateInfoArea$respInfo' style='$style'>";

    $containerStyle  = '';
    $areasJs = '';
    $dropDownHtml = '';
    $dropDownJS = '';
    $selectJs = '';
    if ($options['areasList']) {

        $options['listWidth'] = intval($options['listWidth']) ;
        if ($options['listWidth']<=0) { $options['listWidth'] = 20; }

        $areasList = usacustom_html5map_plugin_areas_list($options,$count);

        if ($areasList) {
            $areasJs = '
                jQuery(document).ready(function($) {

                    $( window ).resize(function() {
                        $("#usacustom-html5-map-areas-list_'.$count.'").show().css({height: jQuery("#usacustom-html5-map-map-container_'.$count.' .fm-map-container").height() + "px"}).niceScroll({cursorwidth:"8px"});
                    });

                    $("#usacustom-html5-map-areas-list_'.$count.'").show().css({height: jQuery("#usacustom-html5-map-map-container_'.$count.' .fm-map-container").height() + "px"}).niceScroll({cursorwidth:"8px"});

                    $("#usacustom-html5-map-areas-list_'.$count.' a").click(function() {

                        var id  = $(this).data("key");
                        var map = usacustomhtml5map_map_'.$count.';

                        html5map_onclick(null,id,map);

                        return false;
                    });

                    $("#usacustom-html5-map-areas-list_'.$count.' a").on("mouseover",function() {

                        var id  = $(this).data("key");
                        var map = usacustomhtml5map_map_'.$count.';

                        map.stateHighlightIn(id);

                    });

                    $("#usacustom-html5-map-areas-list_'.$count.' a").on("mouseout",function() {

                        var id  = $(this).data("key");
                        var map = usacustomhtml5map_map_'.$count.';

                        map.stateHighlightOut(id);

                    });

                });';

            $containerStyle = 'width: '.($options['statesInfoArea']!='right' ? 100-$options['listWidth'].'%' : 60-$options['listWidth'].'%' ).'; float: left';

            if ($options['areasListShowDropDown']) {
                $showOnMobile = '';
                if ($options['areasListShowDropDown'] == 'mobile') {
                    $showOnMobile = 'mobile-only';
                } else {
                    $areasList = '';
                    $areasJs = '';
                    $containerStyle = '';
                }
                /*$dropDownHtml = "<div class='usacustomHtml5MapSelector $showOnMobile'><select id='usacustom-html5-map-selector_{$count}'>
                    <option value=''>".__('Select an area', 'usacustom-html5-map')."</option>
                    $select_options
                </select></div>";*/

                // updated dropdown display code
                $dropDownHtml = "<div class='usacustomHtml5MapSelector $showOnMobile'><select id='usacustom-html5-map-selector_{$count}'>
                    <option value=''>".$options['areasListDropdownLabel']."</option>
                    $select_options
                </select></div>";

                $dropDownJS = "jQuery('#usacustom-html5-map-selector_{$count}').change(function() {
                        var sid = jQuery(this).val();
                        if (hightlighted)
                                usacustomhtml5map_map_{$count}.stateHighlightOut(hightlighted);

                        hightlighted = sid;

                        if (sid) {
                            usacustomhtml5map_map_{$count}.stateHighlightIn(sid);

                            html5map_onclick(null,sid,usacustomhtml5map_map_{$count});
                        }
                    });\n";
            }

            $mapInit.= $areasList;
        }
    }

    if (count($toSelect)) {
        $arr = array(
            'color' => usacustom_html5map_plugin_escape_js_string($selectColors ? $selectColors[0] : '#ff0000'),
            'colorOver' => usacustom_html5map_plugin_escape_js_string(count($selectColors) == 2 ? $selectColors[1] : '#8f1d21')
        );

        foreach ($toSelect as $stId) {
            $stId = usacustom_html5map_plugin_escape_js_string($stId);
            $selectJs .= "if (usacustomhtml5map_map_{$count}.mapConfig.map_data[$stId]) {usacustomhtml5map_map_{$count}.mapConfig.map_data[$stId].color = $arr[color]; usacustomhtml5map_map_{$count}.mapConfig.map_data[$stId].colorOver = $arr[colorOver]; }\n";
            $selectJs .= "else if (usacustomhtml5map_map_{$count}.mapConfig.points[$stId]) {usacustomhtml5map_map_{$count}.mapConfig.points[$stId].color = $arr[color]; usacustomhtml5map_map_{$count}.mapConfig.points[$stId].colorOver = $arr[colorOver]; }\n";
        }
    }


    $mapInit.="$dropDownHtml<div id='usacustom-html5-map-map-container_{$count}' class='usacustomHtml5MapContainer' data-map-variable='usacustomhtml5map_map_{$count}'></div>";

    if ($options['statesInfoArea']=='bottom') { $mapInit.="<div style='clear:both; height: 20px;'></div>"; }

    $customJs = "";
    if ($options['customJs']) {
        $customJs = "(function (map, containerId, mapId) {\n{$options['customJs']}\n})(usacustomhtml5map_map_{$count}, 'usacustom-html5-map-map-container_{$count}', $map_id);";
    }

    $mapInit.= "
            <style>
                #usacustom-html5-map-map-container_{$count} {
                    $containerStyle
                }
                ".usacustom_html5map_plugin_prepare_tooltip_css($options, "#usacustom-html5-map-map-container_{$count}")."
                @media only screen and (max-width: 480px) {
                    #usacustom-html5-map-map-container_{$count} {
                        float: none;
                        width: 100%;
                    }
                }
            </style>";
    $mapJs =  "<script type=\"text/javascript\">
            jQuery(function(){
                var hightlighted = null;
                usacustomhtml5map_map_{$count} = new flashopusacustommap(usacustomhtml5map_map_cfg_{$map_id});
                $selectJs
                usacustomhtml5map_map_{$count}.draw('usacustom-html5-map-map-container_{$count}');
                usacustomhtml5map_map_{$count}.on('mousein', function(ev, sid, map) {
                    if (hightlighted && sid != hightlighted) {
                        map.stateHighlightOut(hightlighted);
                        hightlighted = null;
                    }
                });
                $areasJs
                $customJs

                var html5map_onclick = function(ev, sid, map) {
                var cfg      = usacustomhtml5map_map_cfg_{$map_id};
                var link     = map.fetchStateAttr(sid, 'link');
                var is_group = map.fetchStateAttr(sid, 'group');
                var popup_id = map.fetchStateAttr(sid, 'popup-id');
                var is_group_info = false;

                if (typeof cfg.map_data[sid] !== 'undefined')
                        jQuery('#usacustom-html5-map-selector_{$count}').val(sid);
                    else
                        jQuery('#usacustom-html5-map-selector_{$count}').val('');

                if (is_group==undefined) {

                    if (sid.substr(0,1)=='p') {
                        popup_id = map.fetchPointAttr(sid, 'popup_id');
                        link         = map.fetchPointAttr(sid, 'link');
                    }

                } else if (typeof cfg.groups[is_group]['ignore_link'] == 'undefined' || ! cfg.groups[is_group].ignore_link)  {
                    link = cfg.groups[is_group].link;
                    popup_id = cfg.groups[is_group]['popup_id'];
                    is_group_info = true;
                }
                if (link=='#popup') {

                    if (typeof SG_POPUP_DATA == \"object\") {
                        if (popup_id in SG_POPUP_DATA) {

                            SGPopup.prototype.showPopup(popup_id,false);

                        } else {

                            jQuery.ajax({
                                type: 'POST',
                                url: '$popupUrl',
                                data: {popup_id:popup_id},
                            }).done(function(data) {
                                jQuery('body').append(data);
                                SGPopup.prototype.showPopup(popup_id,false);
                            });

                        }
                    }
                    else if (typeof SGPBPopup == \"function\") {
                        var popup = SGPBPopup.createPopupObjById(popup_id);
                        popup.prepareOpen();
                        popup.open();
                    }

                    return false;
                }
                if (link == '#info') {
                    var id = is_group_info ? is_group : (sid.substr(0,1)=='p' ? sid : map.fetchStateAttr(sid, 'id'));
                    jQuery('#usacustom-html5-map-state-info_{$count}').html('". __('Loading...', 'usacustom-html5-map') ."');
                    jQuery.ajax({
                        type: 'POST',
                        url: (is_group_info ? '$groupInfoUrl' : '$stateInfoUrl') + id,
                        success: function(data, textStatus, jqXHR){
                            jQuery('#usacustom-html5-map-state-info_{$count}').html(data);
                            " . (($options['statesInfoArea'] == 'bottom' AND $options['autoScrollToInfo']) ? "
                            jQuery(\"html, body\").animate({ scrollTop: jQuery('#usacustom-html5-map-state-info_{$count}').offset().top - ".$options['autoScrollOffset']." }, 1000);" : "") . "
                        },
                        dataType: 'text'
                    });

                    return false;
                }

                    if (ev===null && link!='') {
                        if (!jQuery('.html5dummilink').length) {
                            jQuery('body').append('<a href=\"#\" class=\"html5dummilink\" style=\"display:none\"></a>');
                        }

                        jQuery('.html5dummilink').attr('href',link).attr('target',(map.fetchStateAttr(sid, 'isNewWindow') ? '_blank' : '_self'))[0].click();

                    }

                };
                usacustomhtml5map_map_{$count}.on('click',html5map_onclick);

                $dropDownJS

            });
            </script>";
    if ( ! $options['delayCodeOutput'])
        $mapInit .= $mapJs;
    $mapInit.= "<div id='usacustom-html5-map-state-info_{$count}' class='usacustomHtml5MapStateInfo'>".
            (empty($options['defaultAddInfo']) ? '' : apply_filters('the_content',$options['defaultAddInfo']))
            ."</div>
            </div>
            <div style='clear: both'></div>
            <!-- end HTML5 Map -->
    ";

    $count++;

    if ($options['delayCodeOutput']) {
        usacustom_html5map_plugin_enqueue_js($options['minimizeOutput'] ? preg_replace('/\s+/', ' ', $mapJs) : $mapJs);

        if ( ! $print_action_registered) {
            if (is_admin()) {
                add_action('admin_footer', 'usacustom_html5map_plugin_enqueue_js', 1000);
            } else {
                add_action('wp_footer', 'usacustom_html5map_plugin_enqueue_js', 1000);
            }
            $print_action_registered = true;
        }
    }

    if ($options['minimizeOutput'])
        $mapInit = preg_replace('/\s+/', ' ', $mapInit);
    return $mapInit;
}


$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'usacustom_html5map_plugin_settings_link' );

function usacustom_html5map_plugin_settings_link($links) {
    $settings_link = '<a href="admin.php?page=usacustom-html5-map-options">'.__('Settings', 'usacustom-html5-map').'</a>';
    array_push($links, $settings_link);
    return $links;
}

function usacustom_html5map_plugin_ajax_url($action, $params = array()) {
    //$url = admin_url('admin-ajax.php');
    $url = plugin_dir_url(__FILE__).'ajax.php';

    $urlParams = array('action=usacustomhtml5map_' . $action);
    foreach ($params as $key => $value) {
        $urlParams[] = $key.'='.urlencode($value);
    }

    $url .= (strpos('?', $url) === false) ? '?' : '&';
    $url .= implode('&', $urlParams);

    return $url;
}

function usacustom_html5map_plugin_ajax_get_settings_js() {
    $mapId  = intval($_REQUEST['map_id']);
    $options = usacustom_html5map_plugin_get_options();
    $options = isset($options[$mapId]) ? $options[$mapId] : null;
    header( 'Content-Type: application/javascript' );

    if (!$options)
        wp_die();

    $options['map_data'] = str_replace('\\\\n','\\n',$options['map_data']);
    usacustom_html5map_plugin_print_map_settings($mapId, $options);

    wp_die();
}
add_action('wp_ajax_usacustomhtml5map_settings_js', 'usacustom_html5map_plugin_ajax_get_settings_js');
add_action('wp_ajax_nopriv_usacustomhtml5map_settings_js', 'usacustom_html5map_plugin_ajax_get_settings_js');

function usacustom_html5map_plugin_ajax_get_state_info() {
    $mapId  = intval($_REQUEST['map_id']);
    $options = usacustom_html5map_plugin_get_options();
    $options = isset($options[$mapId]) ? $options[$mapId] : null;
    if (!$options)
        wp_die();

    $stateId = $_GET['sid'];

    $info = $options['state_info'][$stateId];
    echo apply_filters('the_content',$info);

    wp_die();
}
add_action('wp_ajax_usacustomhtml5map_state_info', 'usacustom_html5map_plugin_ajax_get_state_info');
add_action('wp_ajax_nopriv_usacustomhtml5map_state_info', 'usacustom_html5map_plugin_ajax_get_state_info');

function usacustom_html5map_plugin_ajax_get_group_info() {
    $mapId  = intval($_REQUEST['map_id']);
    $options = usacustom_html5map_plugin_get_options();
    $options = isset($options[$mapId]) ? $options[$mapId] : null;
    if (!$options)
        wp_die();

    $gid = $_GET['gid'];

    $info = isset($options['groups'][$gid]['info']) ? $options['groups'][$gid]['info'] : '';
    echo apply_filters('the_content', $info);

    wp_die();
}
add_action('wp_ajax_usacustomhtml5map_group_info', 'usacustom_html5map_plugin_ajax_get_group_info');
add_action('wp_ajax_nopriv_usacustomhtml5map_group_info', 'usacustom_html5map_plugin_ajax_get_group_info');
function usacustom_html5map_plugin_ajax_get_popup() {
    $popup = do_shortcode('[sg_popup id="'.intval($_REQUEST['popup_id']).'"][/sg_popup]');
    //$popup = substr($popup,0,strpos($popup,'</script>')+9);
    echo $popup;

    wp_die();
}
add_action('wp_ajax_usacustomhtml5map_popup', 'usacustom_html5map_plugin_ajax_get_popup');
add_action('wp_ajax_nopriv_usacustomhtml5map_popup', 'usacustom_html5map_plugin_ajax_popup');
add_action('init', 'usacustom_html5map_plugin_settings', 100);

function usacustom_html5map_plugin_settings() {

    $is_map_call = false;
    foreach($_REQUEST as $key => $value) { if (strpos($key,'usacustomhtml5map')!==false) { $is_map_call = true; break; } }
    if (!$is_map_call) { return false; } else {
        remove_all_actions( 'wp_head' );
        remove_all_actions( 'wp_footer' );
    }

    $req_start = microtime(TRUE);
    if (isset($_REQUEST['usacustomhtml5map_js_data']) or
        isset($_REQUEST['usacustomhtml5map_get_state_info']) or
        isset($_REQUEST['usacustomhtml5map_get_group_info'])) {
        $map_id  = intval($_REQUEST['map_id']);
        $options = usacustom_html5map_plugin_get_options();
        $options = $options[$map_id];
        if ($options)
            $options['map_data'] = str_replace('\\\\n','\\n',$options['map_data']);
    } else if (isset($_REQUEST['usacustomhtml5map_get_popup']) ) {

        $popup = do_shortcode('[sg_popup id="'.intval($_REQUEST['popup_id']).'"][/sg_popup]');
        //$popup = substr($popup,0,strpos($popup,'</script>')+9);
        echo $popup; exit();
    }


    if( isset($_GET['usacustomhtml5map_js_data']) ) {

        header( 'Content-Type: application/javascript' );
        usacustom_html5map_plugin_print_map_settings($map_id, $options);
        echo '// Generated in '.(microtime(TRUE)-$req_start).' secs.';
        exit;
    }

    if(isset($_GET['usacustomhtml5map_get_state_info'])) {
        $stateId = $_GET['usacustomhtml5map_get_state_info'];

        $info = $options['state_info'][$stateId];
        echo apply_filters('the_content',$info);

        exit;
    }

    if(isset($_GET['usacustomhtml5map_get_group_info'])) {
        $gid = $_GET['usacustomhtml5map_get_group_info'];

        $info = isset($options['groups'][$gid]['info']) ? $options['groups'][$gid]['info'] : '';
        echo apply_filters('the_content',$info);

        exit;
    }
}

function usacustom_html5map_plugin_prepare_comment($comment) {
    if (! $comment)
        return $comment;
        return apply_filters('the_content',$comment);
}

function usacustom_html5map_plugin_print_map_settings($map_id, &$map_options) {
    if ( ! $map_options) {
        ?>
        var	map_cfg = {
            map_data: {}
        };
        <?php
        return;
    }
    $data = json_decode($map_options['map_data'], true);
    $protected_shortnames = array();
    $siteURL           = get_site_url();
    foreach ($data as $sid => &$d)
    {
        if (isset($d['comment']))
            $d['comment'] = usacustom_html5map_plugin_prepare_comment($d['comment']);
        if (isset($d['_hide_name'])) {
            unset($d['_hide_name']);
            $d['name'] = '';
        }
        if (isset($map_options['hideSN']) AND ! in_array($sid, $protected_shortnames))
            $d['shortname'] = '';
        if (isset($d['link']))
            $d['link'] = strpos($d['link'], 'javascript:usacustomhtml5map_set_state_text') === 0 ? '#info' : $d['link'];
    }
    unset($d);
    $map_options['map_data'] = json_encode($data);
    $grps = array();
    if (isset($map_options['groups']) AND is_array($map_options['groups'])) {
        foreach ($map_options['groups'] as $gid => $grp) {
            $grps[$gid] = array();
            if ($grp['_popup_over']) {
                $grps[$gid]['name'] = $grp['name'];
                $grps[$gid]['comment'] = usacustom_html5map_plugin_prepare_comment($grp['comment']);
                $grps[$gid]['image'] = $grp['image'];
            }
            if ($grp['_act_over']) {
                $grps[$gid]['link'] = strpos($grp['link'], 'javascript:usacustomhtml5map_set_state_text') === 0 ? '#info' : $grp['link'];
                $grps[$gid]['isNewWindow'] = empty($grp['isNewWindow']) ? FALSE : TRUE;
                $grps[$gid]['popup_id']    = isset($grp['popup-id']) ? intval($grp['popup-id']) : -1;
            } else {
                $grps[$gid]['ignore_link'] = true;
            }
            if ($grp['_clr_over']) {
                $grps[$gid]['color'] = $grp['color_map'];
                $grps[$gid]['colorOver'] = $grp['color_map_over'];
            }
            if ($grp['_ignore_group']) {
                $grps[$gid]['ignoreMouse'] = true;
            }
            if (!$grps[$gid])
                unset($grps[$gid]);
        }
    }
    $defOptions = usacustom_html5map_plugin_map_defaults('', 1, true);
    foreach ($defOptions as $k => $v) {
        if (!isset($map_options[$k]))
            $map_options[$k] = $v;
    }
    if (isset($map_options['points']) AND is_array($map_options['points'])) {
        foreach ($map_options['points'] as $pid => &$p) {
            if (isset($p['comment']))
                $p['comment'] = usacustom_html5map_plugin_prepare_comment($p['comment']);
            if (isset($p['link']))
                $p['link'] = strpos($p['link'], 'javascript:usacustomhtml5map_set_state_text') === 0 ? '#info' : $p['link'];
        }
        unset($p);
    }
    ?>

    var	usacustomhtml5map_map_cfg_<?php echo $map_id ?> = {

    <?php  if(!$map_options['isResponsive']) { ?>
    mapWidth		: <?php echo $map_options['mapWidth']; ?>,
    mapHeight		: <?php echo $map_options['mapHeight']; ?>,
    <?php }     else { ?>
    mapWidth		: 0,
    <?php } ?>
    zoomEnable              : <?php echo $map_options['zoomEnable'] ? 'true' : 'false'; ?>,
    zoomOnlyOnMobile        : <?php echo $map_options['zoomOnlyOnMobile'] ? 'true' : 'false'; ?>,
    zoomEnableControls      : <?php echo $map_options['zoomEnableControls'] ? 'true' : 'false'; ?>,
    zoomIgnoreMouseScroll   : <?php echo $map_options['zoomIgnoreMouseScroll'] ? 'true' : 'false'; ?>,
    zoomMax   : <?php echo $map_options['zoomMax']; ?>,
    zoomStep   : <?php echo $map_options['zoomStep']; ?>,
    pointColor            : "<?php echo $map_options['pointColor']?>",
    pointColorOver        : "<?php echo $map_options['pointColorOver']?>",
    pointNameColor        : "<?php echo $map_options['pointNameColor']?>",
    pointNameColorOver    : "<?php echo $map_options['pointNameColorOver']?>",
    pointNameStrokeColor        : "<?php echo $map_options['pointNameStrokeColor']?>",
    pointNameStrokeColorOver    : "<?php echo $map_options['pointNameStrokeColorOver']?>",
    pointNameStrokeWidth  : "<?php echo (is_null($map_options['pointNameStrokeWidth']) ? $map_options['nameStrokeWidth'] : $map_options['pointNameStrokeWidth']); ?>",
    pointNameStrokeOpacity: "<?php echo (is_null($map_options['pointNameStrokeOpacity']) ? $map_options['nameStrokeOpacity'] : $map_options['pointNameStrokeOpacity']); ?>",
    pointNameFontFamily   : "<?php echo usacustom_html5map_plugin_escape_fonts($map_options['pointNameFontFamily'] ? $map_options['pointNameFontFamily'] : $map_options['nameFontFamily'], 'Arial, sans-serif'); ?>",
    pointNameFontSize     : "<?php echo intval($map_options['pointNameFontSize']).'px'?>",
    pointNameFontWeight   : "bold",
    pointNameStroke       : <?php echo is_null($map_options['pointNameStrokeWidth']) ? ($map_options['nameStrokeWidth'] ? 'true' : 'false') : ($map_options['pointNameStrokeWidth'] ? 'true' : 'false') ?>,

    pointBorderWidth      : 0.5,
    pointBorderColor      : "<?php echo $map_options['pointBorderColor']?>",
    pointBorderColorOver  : "<?php echo $map_options['pointBorderColorOver']?>",
    shadowAllow             : <?php echo $map_options['shadowAllow'] ? 'true' : 'false'; ?>,
    shadowWidth		: <?php echo $map_options['shadowWidth']; ?>,
    shadowOpacity		: <?php echo $map_options['shadowOpacity']; ?>,
    shadowColor		: "<?php echo $map_options['shadowColor']; ?>",
    shadowX			: <?php echo $map_options['shadowX']; ?>,
    shadowY			: <?php echo $map_options['shadowY']; ?>,

    iPhoneLink		: <?php echo $map_options['iPhoneLink']; ?>,

    isNewWindow		: <?php echo $map_options['isNewWindow']; ?>,

    borderWidth     : "<?php echo $map_options['borderWidth']; ?>",
    borderColor		: "<?php echo $map_options['borderColor']; ?>",
    borderColorOver		: "<?php echo $map_options['borderColorOver']; ?>",

    nameColor		: "<?php echo $map_options['nameColor']; ?>",
    nameColorOver		: "<?php echo $map_options['nameColorOver']; ?>",
    nameFontFamily		: "<?php echo usacustom_html5map_plugin_escape_fonts($map_options['nameFontFamily'], 'Arial, sans-serif'); ?>",
    nameFontSize		: "<?php echo $map_options['nameFontSize'].'px'; ?>",
    nameFontWeight		: "<?php echo $map_options['nameFontWeight']; ?>",

    overDelay		: <?php echo $map_options['overDelay']; ?>,
    nameStroke		: <?php echo $map_options['nameStroke']?'true':'false'; ?>,
    nameStrokeColor		: "<?php echo $map_options['nameStrokeColor']; ?>",
    nameStrokeColorOver	: "<?php echo $map_options['nameStrokeColorOver']; ?>",
    nameStrokeWidth		: "<?php echo $map_options['nameStrokeWidth']; ?>",
    nameStrokeOpacity	: "<?php echo $map_options['nameStrokeOpacity']; ?>",
    freezeTooltipOnClick: <?php echo $map_options['freezeTooltipOnClick']?'true':'false'; ?>,

    tooltipOnHighlightIn: <?php echo $map_options['tooltipOnHighlightIn']?'true':'false'; ?>,
    tooltipOnMobileCentralize: <?php echo $map_options['tooltipOnMobileCentralize']?'true':'false'; ?>,
    tooltipOnMobileWidth: "<?php echo $map_options['tooltipOnMobileWidth']; ?>",
    tooltipOnMobileVPosition: "<?php echo $map_options['tooltipOnMobileVPosition']; ?>",

    mapId: "<?php echo $map_options['mapId'] ?>",

    map_data        : <?php echo $map_options['map_data']; ?>
    ,groups          : <?php echo $grps ? json_encode($grps) : '{}'; ?>
    ,points         : <?php echo (isset($map_options['points']) AND $map_options['points']) ? json_encode($map_options['points']) : '{}'; ?>
    };

    <?php
    if (file_exists($params_file = dirname(__FILE__).'/static/paths.json')) {
        echo "usacustomhtml5map_map_cfg_$map_id.map_params = ".file_get_contents($params_file).";\n";
    }
}


function usacustom_html5map_plugin_map_defaults($name='New map', $type=1, $baseOnly=false) {
    $defaults = array(
        'mapWidth'          =>530,
        'mapHeight'         =>410,
        'maxWidth'          =>980,
        'shadowAllow'       => true,
        'zoomEnable'            => false,
        'zoomEnableControls'    => true,
        'zoomIgnoreMouseScroll' => false,
        'zoomOnlyOnMobile'      => false,
        'zoomMax'               => 2,
        'zoomStep'              => 0.2,
        'initialZoom'           => null,
        'defaultPointRadius'    => 4,
        'pointColor'            => "#FFC480",
        'pointColorOver'        => "#DC8135",
        'pointNameColor'        => "#000",
        'pointNameColorOver'    => "#222",
        'pointNameFontFamily'   => '',
        'pointNameFontSize'     => "8",
        'pointNameFontWeight'   => "bold",
        'pointNameStroke'       => null,
        'pointNameStrokeColor'  => "#FFFFFF",
        'pointNameStrokeColorOver'  => "#FFFFFF",
        'pointNameStrokeWidth'  => null,
        'pointNameStrokeOpacity'=> null,

        'pointBorderWidth'      => 0.5,
        'pointBorderColor'      => "#ffffff",
        'pointBorderColorOver'  => "#eeeeee",
        'shadowWidth'       => 1.5,
        'shadowOpacity'     => 0.2,
        'shadowColor'       => "black",
        'shadowX'           => 0,
        'shadowY'           => 0,
        'iPhoneLink'        => "true",
        'isNewWindow'       => "false",
        'borderWidth'       => 1.01,
        'borderColor'       => "#ffffff",
        'borderColorOver'   => "#ffffff",
        'nameColor'         => "#ffffff",
        'nameColorOver'     => "#ffffff",
        'nameFontFamily'    => '',
        'nameFontSize'      =>8,
        'nameFontWeight'    => "bold",
        'overDelay'         => 300,
        'statesInfoArea'    => "bottom",
        'autoScrollToInfo'  => 0,
        'autoScrollOffset'  => 0,
        'isResponsive'      => "1",
        'nameStroke'        => true,
        'nameStrokeColor'   => "#000000",
        'nameStrokeColorOver'=> "#000000",
        'nameStrokeWidth'   =>  1.5,
        'nameStrokeOpacity' => 0.5,
        'freezeTooltipOnClick' => false,

        'areasList'         =>false,
        'areasListShowDropDown' => false,
        'areaListOnlyActive'=> false,
        'listWidth'         => '20',
        'listFontSize'      => '14px',
        'areasListDropdownLabel' => 'Select an area',
        'popupNameColor'    => "#000000",
        'popupNameFontFamily'   => "",
        'popupNameFontSize'     => "20",
        'popupCommentColor'     => '',
        'popupCommentFontFamily'=> '',
        'popupCommentFontSize'  => '',
        'tooltipOnHighlightIn'  => true,
        'tooltipOnMobileCentralize' => true,
        'tooltipOnMobileWidth' => '80%',
        'tooltipOnMobileVPosition' => 'bottom',
        'minimizeOutput' => true,
        'delayCodeOutput' => false,
        'customJs' => '',

    );

    $initialStatesPath = dirname(__FILE__).'/static/settings_tpl.json';
    $defaults['mapId'] = 'Zn6Wus';
    if ($baseOnly)
        return $defaults;
    $defaults['name']           = $name;
    $defaults['update_time']    = time();
    $defaults['map_data']       = file_get_contents($initialStatesPath);
    $defaults['cacheSettings']  = is_writable(dirname(__FILE__).'/static');
    $arr = json_decode($defaults['map_data'], true);
    foreach ($arr as $i) {
        $defaults['state_info'][$i['id']] = '';
    }

    return $defaults;
}

function usacustom_html5map_plugin_settings_url($map_id, &$map_options) {
    $cacheURL   = plugins_url('/static/cache', __FILE__);
    $siteURL    = get_site_url();
    //$phpURL     = "{$siteURL}/index.php?usacustomhtml5map_js_data=true&map_id=$map_id&r=".rand(11111,99999);
    $phpURL     = usacustom_html5map_plugin_ajax_url('settings_js', array('map_id' => $map_id, 'r' => rand(11111,99999)));

    if ( ! $map_options['update_time'])
        return $phpURL;

    if ( ! (isset($map_options['cacheSettings']) and $map_options['cacheSettings']))
        return $phpURL;

    $cache_name = "usacustom-html5-map-{$map_id}-{$map_options['update_time']}.js";
    $static_path = dirname(__FILE__).'/static';
    $cache_path  = "$static_path/cache";

    if (!is_writable($static_path))
        return $phpURL;

    if (file_exists("$cache_path/$cache_name"))
        return "$cacheURL/$cache_name";

    if (!file_exists($cache_path)) {
        if (is_writable($static_path))
            mkdir($cache_path);
        else
            return $phpURL;
    }

    if (usacustom_html5map_plugin_generate_cache($map_id, $map_options, $cache_path, $cache_name))
        return "$cacheURL/$cache_name";
    else
        return $phpURL;
}

function usacustom_html5map_plugin_generate_cache($map_id, &$map_options, $cache_path, $cache_name) {
    $name_prefix = "usacustom-html5-map-{$map_id}";
    $dh = opendir($cache_path);
    if (!$dh)
        return false;
    while ($file = readdir($dh)) {
        if (strpos($file, $name_prefix) !== false)
            unlink("$cache_path/$file");
    }
    closedir($dh);

    ob_start();
    usacustom_html5map_plugin_print_map_settings($map_id, $map_options);
    $cntnt = ob_get_clean();
    if (file_put_contents("$cache_path/$cache_name", $cntnt))
        return true;
    else
        return false;
}

function usacustom_html5map_plugin_group_defaults($name) {
    return array(
        'group_name' => $name,
        '_popup_over' => false,
        '_act_over' => false,
        '_clr_over' => false,
        '_ignore_group' => false,
        'name' => $name,
        'comment' => '',
        'info' => '',
        'image' => '',
        'link' => '',
        'color_map' => '#ffffff',
        'color_map_over' => '#ffffff'
    );
}


function usacustom_html5map_plugin_wp_editor_for_tooltip($content, $name = 'tooltip', $id = 'tooltip_editor') {
    wp_editor($content, $id, array(
        'wpautop'       => 1,
        'media_buttons' => 1,
        'textarea_name' => $name,
        'textarea_rows' => 5,
        'tabindex'      => null,
        'editor_css'    => '',
        'editor_class'  => '',
        'teeny'         => 0,
        'dfw'           => 0,
        'tinymce'       => 1,
        'quicktags'     => 1,
        'drag_drop_upload' => false
    ));
}
function usacustom_html5map_plugin_get_options($blog_id = null, $option_name = "usacustomhtml5map_options") {
    $res = is_multisite() ?
        get_blog_option(is_null($blog_id) ? get_current_blog_id() : $blog_id, 'usacustomhtml5map_options') :
        get_site_option($option_name);
    return $res ? $res : array();
}

function usacustom_html5map_plugin_save_options(&$options, $blog_id = null, $option_name = "usacustomhtml5map_options") {
    if ( is_multisite() ) {
        update_blog_option(is_null($blog_id) ? get_current_blog_id() : $blog_id, 'usacustomhtml5map_options', $options);
    } else {
        update_site_option($option_name,$options);
    }
}

function usacustom_html5map_plugin_delete_options($blog_id = null) {
    if ( is_multisite() ) {
        delete_blog_option(is_null($blog_id) ? get_current_blog_id() : $blog_id, 'usacustomhtml5map_options');
    } else {
        delete_site_option('usacustomhtml5map_options');
    }
}

register_activation_hook( __FILE__, 'usacustom_html5map_plugin_activation' );

function usacustom_html5map_plugin_activation() {

    $options = array(0 => usacustom_html5map_plugin_map_defaults());

    add_site_option('usacustomhtml5map_options', $options);

}

register_deactivation_hook( __FILE__, 'usacustom_html5map_plugin_deactivation' );

function usacustom_html5map_plugin_deactivation() {

}

register_uninstall_hook( __FILE__, 'usacustom_html5map_plugin_uninstall' );

function usacustom_html5map_plugin_uninstall() {
    delete_site_option('usacustomhtml5map_options');
}

add_filter('widget_text', 'do_shortcode');


function usacustom_html5map_plugin_export() {
    $maps = array();
    if (isset($_REQUEST['map_id']) and is_array($_REQUEST['map_id']))
        $maps = $_REQUEST['map_id'];
    elseif (isset($_REQUEST['maps']))
        $maps = explode(',', $_REQUEST['maps']);
    if ( ! $maps)
        return;
    $options = usacustom_html5map_plugin_get_options();

    foreach($options as $map_id => $option) {
        if (!in_array($map_id,$maps)) {
            unset($options[$map_id]);
        }
        unset($options[$map_id]['point_editor_settings']);
    }

    if (count($options)>0) {
        $options = json_encode($options);

        header($_SERVER["SERVER_PROTOCOL"] . ' 200 OK');
        header('Content-Type: text/json');
        header('Content-Length: ' . (strlen($options)));
        header('Connection: close');
        header('Content-Disposition: attachment; filename="maps.json";');
        echo $options;

        exit();
    }

}

function usacustom_html5map_plugin_get_csv_import_export_keys($type) {
    switch ($type) {
        case 'states':
        return array(
            'id'            => 'id',
            'shortname'     => 'shortname',
            'name'          => 'name',
            'comment'       => 'comment',
            'info'          => 'info',
            'image'         => 'image',
            'link'          => 'link',
            'isNewWindow'   => 'isNewWindow',
            'clickAction'   => 'clickAction',
            'popupId'       => 'popup-id',
            'color'         => 'color_map',
            'colorOver'     => 'color_map_over',
            'class'         => 'class',
            'hideName'      => '_hide_name',
            'hideArea'      => 'hidden',
            'groupId'       => 'group'
        );
        case 'groups':
        return array(
            'groupId'       => 'id',
            'groupName'     => 'group_name',
            'name'          => 'name',
            'comment'       => 'comment',
            'info'          => 'info',
            'image'         => 'image',
            'link'          => 'link',
            'isNewWindow'   => 'isNewWindow',
            'clickAction'   => 'clickAction',
            'popupId'       => 'popup-id',
            'color'         => 'color_map',
            'colorOver'     => 'color_map_over',
            'overridePopup' => '_popup_over',
            'overrideAction'=> '_act_over',
            'overrideColors'=> '_clr_over',
            'ignoreMouse'   => '_ignore_group',
        );
        case 'points':
        return array(
            'pointId'       => 'id',
            'shortname'     => 'shortname',
            'name'          => 'name',
            'comment'       => 'comment',
            'info'          => 'info',
            'image'         => 'image',
            'link'          => 'link',
            'isNewWindow'   => 'isNewWindow',
            'clickAction'   => 'clickAction',
            'popupId'       => 'popup_id',
            'color'         => 'color',
            'colorOver'     => 'colorOver',
            'borderColor'           => 'borderColor',
            'borderColorOver'       => 'borderColorOver',
            'nameColor'             => 'nameColor',
            'nameColorOver'         => 'nameColorOver',
            'nameStrokeColor'       => 'nameStrokeColor',
            'nameStrokeColorOver'   => 'nameStrokeColorOver',
            'class'         => 'class',
            'nameFontSize'  => 'nameFontSize',
            'textPos'       => 'textPos',
            'textX'         => 'tx',
            'textY'         => 'ty',
            'x'             => 'x',
            'y'             => 'y',
            'radius'        => 'radius',
            'pointType'     => 'pointType'
        );
    }
    return array();
}

function usacustom_html5map_plugin_detect_export_click_action(&$row) {
    $action = "none";
    if (!isset($row['link'])) $action = "none";
    elseif(stripos($row['link'], "javascript:[\w_]+_set_state_text") !== false or $row['link'] == '#info' ) $action = "info";
    elseif(trim($row['link']) == "#popup") $action = "popup";
    elseif(trim($row['link']) != "") $action = "link";
    else $action = "none";
    $row['clickAction'] = $action;
}

function usacustom_html5map_plugin_export_csv() {
    if ( ! is_admin())
        return;
    remove_all_actions('wp_head');
    remove_all_actions('wp_footer');

    $all_options = usacustom_html5map_plugin_get_options();
    $options_keys = array_keys($all_options);
    $def_map_id = reset($options_keys);

    $map_id = isset($_GET['map_id']) ? (int)$_GET['map_id'] : $def_map_id;

    $map_options = &$all_options[$map_id];

    $field_delimiters = array(
        ',' => ',',
        ';' => ';',
        ':' => ':',
        'sp'=> ' ',
        'tb'=> "\t"
    );
    $text_delimiters = array(
        "'" => "'",
        '"' => '"',
        'n' => null
    );

    $fd = stripslashes($_REQUEST['field-delimiter']);
    $td = stripslashes($_REQUEST['text-delimiter']);
    if ( ! array_key_exists($fd, $field_delimiters)) {
        $fd = ',';
    }
    else {
        $fd = $field_delimiters[$fd];
    }
    if ( ! array_key_exists($td, $text_delimiters)) {
        $td = '"';
    }
    else {
        $td = $text_delimiters[$td];
    }

    $tmp_name = tempnam(sys_get_temp_dir(), 'mapcsv');
    $fh = fopen($tmp_name, 'w');
    $import_export_keys = usacustom_html5map_plugin_get_csv_import_export_keys('states');
    $header = array_keys($import_export_keys);
    $fields = array_values($import_export_keys);
    fputcsv($fh, $header, $fd, $td);
    $st_params = json_decode($map_options['map_data'], true);
    foreach ($st_params as $id => $params) {
        $params['id'] = $id;
        $params['info'] = isset($map_options['state_info'][$iid = preg_replace('/\D+/', '', $id)]) ?$map_options['state_info'][$iid] : '';
        usacustom_html5map_plugin_detect_export_click_action($params);
        $data = array();
        foreach(array('_hide_name', 'isNewWindow', 'hidden') as $f) $params[$f] = empty($params[$f]) ? '' : 'yes';
        foreach ($fields as $f) if ($f)
            $data[$f] = isset($params[$f]) ? $params[$f] : '';
        if ($params['clickAction'] !== 'link') $data['link'] = '';
        fputcsv($fh, $data, $fd, $td);
    }
    if (!empty($map_options['groups'])) {
        $import_export_keys = usacustom_html5map_plugin_get_csv_import_export_keys('groups');
        $header = array_keys($import_export_keys);
        $fields = array_values($import_export_keys);
        fputcsv($fh, $header, $fd, $td);
        foreach ($map_options['groups'] as $id => $params) {
            $params['id'] = $id;
            usacustom_html5map_plugin_detect_export_click_action($params);
            $data = array();
            foreach(array('isNewWindow', '_popup_over', '_act_over', '_clr_over', '_ignore_group') as $f) $params[$f] = empty($params[$f]) ? '' : 'yes';
            foreach ($fields as $f) if ($f)
                $data[$f] = isset($params[$f]) ? $params[$f] : '';
            if ($params['clickAction'] !== 'link') $data['link'] = '';
            fputcsv($fh, $data, $fd, $td);
        }
    }
    if (!empty($map_options['points'])) {
        $import_export_keys = usacustom_html5map_plugin_get_csv_import_export_keys('points');
        $header = array_keys($import_export_keys);
        $fields = array_values($import_export_keys);
        fputcsv($fh, $header, $fd, $td);
        foreach ($map_options['points'] as $id => $params) {
            $params['id'] = $id;
            $params['info'] = isset($map_options['state_info'][$id]) ?$map_options['state_info'][$id] : '';
            usacustom_html5map_plugin_detect_export_click_action($params);
            $data = array();
            foreach(array('isNewWindow') as $f) $params[$f] = empty($params[$f]) ? '' : 'yes';
            foreach ($fields as $f) if ($f)
                $data[$f] = isset($params[$f]) ? $params[$f] : '';
            if ($params['clickAction'] !== 'link') $data['link'] = '';
            fputcsv($fh, $data, $fd, $td);
        }
    }
    fclose($fh);
    header('Content-type: text/csv');
    header('Content-length: '.filesize($tmp_name));
    header('Connection: close');
    header('Content-Disposition: attachment; filename="usacustomhtml5map-'.$map_id.'.csv";');
    readfile($tmp_name);
    unlink($tmp_name);
    exit;
}


function usacustom_html5map_plugin_import(&$errors) {
    $errors = array();
    $csv_types = array('text/csv','text/comma-separated-values','application/vnd.ms-excel');
    if(is_uploaded_file($_FILES['import_file']["tmp_name"])) {

        if (in_array($_FILES['import_file']['type'], $csv_types))
        {
            $errors[] = sprintf(__('CSV import should be done on the "<a href="%s">Import / Export</a>" tab', 'usacustom-html5-map'), "admin.php?page=usacustom-html5-map-tools");
            return false;
        }

        $hwnd = fopen($_FILES['import_file']["tmp_name"],'r');
        $data = fread($hwnd,filesize($_FILES['import_file']["tmp_name"]));
        fclose($hwnd);

        $data    = json_decode($data, true);

        if ($data) {
            $def_settings = file_get_contents(dirname(__FILE__).'/static/settings_tpl.json');
            $def_settings = json_decode($def_settings, true);
            $states_count = count($def_settings);
            $options = usacustom_html5map_plugin_get_options();

            foreach($data as $map_id => $map_data) {
                if (isset($map_data['map_data']) and $map_data['map_data']) {

                    $data = json_decode($map_data['map_data'], true);
                    $cur_count = $data ? count($data) : 0;
                    $c = $options ? max(array_keys($options))+1 : 0;
                    if ($cur_count != $states_count) {
                        $errors[] = sprintf(__('Failed to import "%s", looks like it is a wrong map. Got %d states when expected states count was: %d', 'usacustom-html5-map'), $map_data['name'], $cur_count, $states_count);
                        continue;
                    }
                    $map_data['update_time'] = time();
                    $map_data['map_data'] = preg_replace("/javascript:[\w_]+_set_state_text[^\(]*\([^\)]+\);/", "#info", $map_data['map_data']);
                    $options[]              = $map_data;
                } else {
                   $errors[] = sprintf(__('Section "%s" skipped cause it has no "map_data" block.', 'usacustom-html5-map'), $map_id);
                }

            }
            usacustom_html5map_plugin_save_options($options);
        } else {
            $errors[] = __('Failed to parse uploaded file. Is it JSON?', 'usacustom-html5-map');
        }

        unlink($_FILES['import_file']["tmp_name"]);

    } else {
        $errors[] = __('File uploading error!', 'usacustom-html5-map');
    }
    return !count($errors);
}

function usacustom_html5map_plugin_areas_list($options,$count) {

    $map_data = (array)json_decode($options['map_data']);
    $areas    = array();
    foreach($map_data as $key => $area) {
        if ($options['areaListOnlyActive'] and !$area->link)
            continue;
        if (isset($area->hidden) and $area->hidden)
            continue;
        $areas[$area->name] = array(
            'id'   => $area->id,
            'key'  => $key,
            'name' => $area->name,
        );
    }

    if (empty($areas))
        return '';

    usacustom_html5map_plugin_sort_regions_list($areas, 'asc');

    $options['listFontSize'] = intval($options['listFontSize'])>0 ? $options['listFontSize'] : 16;

    $html = "<div class=\"usacustomHtml5Map-areas-list\" id=\"usacustom-html5-map-areas-list_{$count}\" style=\"width: ".$options['listWidth']."%;\" data-count=\"$count\">";

    foreach ($areas as $area) {
        $html.="<div class=\"usacustomHtml5Map-areas-item\"><a href=\"#\" style=\"font-size: ".$options['listFontSize']."px\" data-key=\"".$area['key']."\" data-id=\"".$area['id']."\" >".$area['name']."</a></div>";
    }

    $html.= "</div>";

    return $html;
}

function usacustom_html5map_plugin_user_has_cap($allcaps, $cap, $args) {

    $user_id      = get_current_user_id();
    $current_user = get_user_by('id', $user_id);
    $allowed      = usacustom_html5map_plugin_get_options(null, 'usacustomhtml5map_goptions');

    if (!(isset($allowed['roles']) and is_array($allowed['roles']))) {
        $allowed['roles'] = array();
    }

    $allowed['roles']['administrator'] = true;

    foreach($allowed['roles'] as $role => $val) {
        if ($val && $current_user && in_array($role, (array)$current_user->roles)) {
            $allcaps['usacustomhtml5map_manage_role'] = true;
            break;
        }
    }

    return $allcaps;
}
add_filter('user_has_cap', 'usacustom_html5map_plugin_user_has_cap', 10, 3 );

add_action('init', 'usacustom_html5map_plugin_convert_old_popup_ids', 100);

function usacustom_html5map_plugin_convert_old_popup_ids() {
	$is_converted = get_option('usacustomhtml5map_popup_ids_converted');
	if ($is_converted)
		return;

	if (usacustom_html5map_plugin_popup_bulder_type() == 1)
		return;

	$maps = usacustom_html5map_plugin_get_options();
	$modified = false;
	foreach ($maps as &$mapOptions) {
		$res = usacustom_html5map_plugin_popup_builder_cover_old_ids($mapOptions);
		$modified = $res || $modified;
	}

	if ($modified) {
		usacustom_html5map_plugin_save_options($maps);
	}
	update_option('usacustomhtml5map_popup_ids_converted', 1);
}
