/**
* detect IE 11 below
* returns version of IE or false, if browser is not Internet Explorer
*/
window.wdt_browser_detect = function wdt_browser_detect() {
  var ua = window.navigator.userAgent;
  // Test Values
  // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';  // IE 10
  // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko'; // IE 11
  // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0'; // Edge 12
  // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586'; // Edge 13

  var msie = ua.indexOf('MSIE ');
  if (msie > 0) {  // IE 10 or older => return version number
    return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
  }

  var trident = ua.indexOf('Trident/');
  if (trident > 0) { // IE 11 => return version number
    var rv = ua.indexOf('rv:');
    return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
  }
  
  var edge = ua.indexOf('Edge/');
  if (edge > 0) { // Edge (IE 12+) => return version number
    return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
  }

  return false; // other browser
}

window.wdt_display_browser_message = function wdt_display_browser_message(){
  var htm = '<div class="alert alert-warning alert-dismissible fade show"><strong>Warning!</strong> The dynamic table on this page may not display in your browser. We recommend using <a href="https://www.google.com/chrome/" target="_blank">Chrome</a>, <a href="https://www.microsoft.com/en-us/edge" target="_blank">Edge</a>, or <a href="https://www.mozilla.org/en-US/firefox/new/" target="_blank">Firefox<a>.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
  if(jQuery('div.wpdt-c').first().length){
    jQuery(htm).insertBefore(jQuery('div.wpdt-c').first() );
  }
}

setTimeout(function(){
  var version = wdt_browser_detect();
  if (version !== false && version < 12) wdt_display_browser_message();
},100);