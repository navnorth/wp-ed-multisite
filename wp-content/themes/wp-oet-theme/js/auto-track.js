class OutboundLinkTracking{
	constructor(){
	}

	trackEvent(){
		var eventCategory = (arguments.length>0 && arguments[0] !== 'undefined')? arguments[0]:null;
		var eventAction = (arguments.length>1 && arguments[1] !== 'undefined')? arguments[1]:null;
		var eventLabel = (arguments.length>2 && arguments[2] !== 'undefined')? arguments[2]:null;

		// Legacy way of event tracking
		if (typeof ga == 'function'){
			ga('send', 'event', eventCategory, eventAction, eventLabel, 0);	
		}
		//UA and GA4 event tracking
		if (typeof gtag =='function'){
			gtag('event', eventAction, {
				'event_category': eventCategory,
				'event_label': eventLabel,
			});
		}
		
	}
}

// Outbound link click event handler
jQuery(function($){
	$(document).on('click', 'a[href]', function(e){
		var url = $(this).attr('href');	
		
		// Check if link host is not the same with page host
		if (e.currentTarget.host != window.location.host ){
			let link = new OutboundLinkTracking();
			link.trackEvent('Outbound',window.location.pathname,url);

			if (e.metaKey || e.ctrlKey || this.target == "_blank") {
                var newtab = true;
            }

            // put a delay on redirecting to external site so it can send data to GA
            if (!newtab){
            	e.preventDefault();

            	setTimeout(function(){
            		document.location = url;
            	},100);
            }
		}
	});
});