var origPosition;
/*
------------------------------------------------------------
Function to activate form button to open the slider.
------------------------------------------------------------
*/
function open_panel() {
    var a = document.getElementById("contact-slider-sidebar");
    if (is_IE()) {
        var ua = window.navigator.userAgent;
        var trident = ua.indexOf('Trident/7'); // IE11 = Trident/7.0
        var edge = ua.indexOf('Edge/');       // Edge
        var msie = ua.indexOf('MSIE ');       // IE10 and below IE9 = Trident/5.0
        // if not Edge or IE11 then check for less than 10
        
        if ( (edge < 0) && (trident < 0) )
        {
            version = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
            if (version < 10) {
                location.href = jQuery(a).attr("data-redirect");
                return false;
            }
        }
    }
    origPosition = parseInt(document.getElementById("contact-slider").style.right);
    slideIt();
    a.setAttribute("id", "contact-slider-sidebar1");
    a.setAttribute("aria-expanded", "true");
    a.setAttribute("aria-label", "Contact Us Expanded");
    a.setAttribute("onclick", "close_panel()");
    // set box-shadow
    content = document.getElementById("contact-slider-content");
    content.style.boxShadow ='0 0 8px gray';
    enable_tabbing(0);
}

/*
------------------------------------------------------------
Function to slide the sidebar form (open form)
------------------------------------------------------------
*/
function slideIt() {
    var slidingDiv = document.getElementById("contact-slider");
    var stopPosition = 0;
    var add = 2;
    if (is_IE()) {
        add = 8;
    }
    if (parseInt(slidingDiv.style.right) < stopPosition) {
        slidingDiv.style.right = parseInt(slidingDiv.style.right) + add + "px";
        setTimeout(slideIt, 1);
    }
}

/*
------------------------------------------------------------
Function to activate form button to close the slider.
------------------------------------------------------------
*/
function close_panel() {
    slideIn();
    a = document.getElementById("contact-slider-sidebar1");
    a.setAttribute("id", "contact-slider-sidebar");
    a.setAttribute("aria-expanded", "false");
    a.setAttribute("aria-label", "Contact Us Collapsed");
    a.setAttribute("onclick", "open_panel()");
    show_cf_form();
    // set box-shadow
    content = document.getElementById("contact-slider-content");
    content.style.boxShadow ='0 0 0';
    enable_tabbing(-1);
}

/*
------------------------------------------------------------
Function to slide the sidebar form (slide in form)
------------------------------------------------------------
*/
function slideIn() {
    var slidingDiv = document.getElementById("contact-slider");
    var stopPosition = origPosition;
    var add = 2;
    if (is_IE()) {
        add = 8;
    }
    if (parseInt(slidingDiv.style.right) > stopPosition) {
        slidingDiv.style.right = parseInt(slidingDiv.style.right) - add + "px";
        setTimeout(slideIn, 1);
    }
}

/*
------------------------------------------------------------
Function to show the form back after hitting submit button
------------------------------------------------------------
*/
function show_cf_form() {
    var cf_form = document.getElementById("cf-form");
    if (cf_form.style.display=="none") {
        cf_form.style.display = 'block';
    }
    hideMessage();
}

function enable_tabbing(tabindex) {
    jQuery('#contact-slider-content').find('.contact-slider-close').attr('tabindex',tabindex);
    jQuery('#contact-slider-content').find('#cf-form input,#cf-form textarea').attr('tabindex',tabindex);
    jQuery('#contact-slider-content').find('.wpcf7-recaptcha').attr('tabindex',tabindex);
    jQuery('#contact-slider-content').find('.wpcf7-recaptcha').attr('data-tabindex',tabindex);
    jQuery('#contact-slider-content').find('.wpcf7-recaptcha iframe').attr('tabindex',tabindex);
    if (tabindex===0) {
        jQuery('#contact-slider-content').find('.wpcf7-recaptcha').css({"visibility":"visible"});
    } else {
        jQuery('#contact-slider-content').find('.wpcf7-recaptcha').css({"visibility":"hidden"});
    }
}

function is_IE(){
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    var trident = ua.indexOf('Trident/'); // IE11
    if (msie > 0 || trident > 0)
        return true;
    else
        return false;
}
