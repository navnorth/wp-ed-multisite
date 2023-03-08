jQuery( document ).ready(function() {
    var itemmenu = jQuery('.nav-menu > .menu-item-has-children > .sub-menu');
    var top_submenus = itemmenu.children().length;
    var total_submenus = itemmenu.find("li").length;
    var i = 0, n = 0, r = 0;
    var menu_height = 33;
    var new_top=0;
    var add_menuclass = false;
    var offset = -8;
    itemmenu.find("li").each(function(index){
        var $this = jQuery(this);
        var $siblings;
        if ($this.hasClass("menu-item-has-children")) {
            $siblings = $this.siblings()
            if (index <(total_submenus/2))
                add_menuclass = true;
            else
                add_menuclass = false;
            n++;
        }
        if (i>=total_submenus/2) {
            if (add_menuclass) {
                $this.addClass("menu-left");
                add_menuclass=false;
            } else {
                if ($this.hasClass("menu-item-has-children")){
                    offset += 10;
                    new_top = r*menu_height - offset;
                    $this.addClass("menu-right").attr("style","position:absolute !important;border-right:none;top:" + new_top + "px");
                    r++;
                } else {
                    new_top = r*menu_height - offset;
                    if ($this.parents().length==10) {
                        new_top -= 14;
                        $this.addClass("menu-right").attr("style","position:absolute !important;border-right:none;top:" + new_top + "px;");
                    } else {
                        $this.attr("style","width:461px !important;float:none !important; border-right:none; display:block !important;");
                        $this.find("a").attr("style","margin-top:-5px;");
                        offset += 3;
                    }
                    r++;
                }
            }
        } else {
            $this.addClass("menu-left");
        }
        i++;
    });
});
