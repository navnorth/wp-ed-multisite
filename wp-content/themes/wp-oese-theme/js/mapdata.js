var simplemaps_usmap_mapdata = {

	main_settings:{
		//General settings
		width: 'responsive',
		background_color: '#DCE1EB',	
		background_transparent: 'no',
		border_color: '#ffffff',
		popups: 'detect', //on_click, on_hover, or detect
	
		//State defaults
		state_description:   'Click for State Information',
		state_color: '#0075EB',
		state_hover_color: '#3B729F',
		state_url: 'http://dev.oss.seiservices.com/sample1.aspx',
		border_size: 1.5,		
		all_states_inactive: 'no',
		all_states_zoomable: 'no',		
		
		//Location defaults
		location_description:  'Location description',
		location_color: '#FF0067',
		location_opacity: .8,
		location_hover_opacity: 1,
		location_url: '',
		location_size: 25,
		location_type: 'square', // circle, square, image
		location_image_source: 'frog.png', //name of image in the map_images folder		
		location_border_color: '#FFFFFF',
		location_border: 2,
		location_hover_border: 2.5,				
		all_locations_inactive: 'no',
		all_locations_hidden: 'no',
		
		//Labels
		label_color: '#d5ddec',	
		label_hover_color: '#d5ddec',		
		label_size: 22,
		label_font: 'Arial',
		hide_labels: 'no',
		hide_eastern_labels: 'no',
		
		//Zoom settings
		zoom: 'yes', //use default regions
		back_image: 'no',   //Use image instead of arrow for back zoom				
		arrow_color: '#3B729F',
		arrow_color_border: '#88A4BC',
		initial_back: 'no', //Show back button when zoomed out and do this JavaScript upon click		
		initial_zoom: -1,  //-1 is zoomed out, 0 is for the first continent etc	
		initial_zoom_solo: 'no', //hide adjacent states when starting map zoomed in
		region_opacity: 1,
		region_hover_opacity: .6,
		zoom_out_incrementally: 'yes',  // if no, map will zoom all the way out on click
		zoom_percentage: .99,
		zoom_time: .5, //time to zoom between regions in seconds
		
		//Popup settings
		popup_color: 'white',
		popup_opacity: .9,
		popup_shadow: 1,
		popup_corners: 5,
		popup_font: '12px/1.5 Verdana, Arial, Helvetica, sans-serif',
		popup_nocss: 'no', //use your own css	
		
		//Advanced settings
		div: 'map',
		auto_load: 'yes',		
		url_new_tab: 'no', 
		images_directory: 'default', //e.g. 'map_images/'
		fade_time:  .1, //time to fade out		
		link_text: '(Link)'  //Text mobile browsers will see for links	
		
	},

	state_specific:{	
		"HI": {
			name: 'Hawaii',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/about/offices/list/oese/oss/frimap/hi.html'
		},
		"AK": {
			name: 'Alaska',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/alaska-states-monitored/'
			},
		"FL": {
			name: 'Florida',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/florida-states-monitored/',
			inactive: 'no'
			},
		"NH": {
			name: 'New Hampshire',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/nh.html'
			},
		"VT": {
			name: 'Vermont',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/vt.html'
			},
		"ME": {
			name: 'Maine',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/me.html'	
			},
		"RI": {
			name: 'Rhode Island',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/rhode-island-states-monitored/'		
			},
		"NY": {
			name: 'New York',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ny.html'	
		},
		"PA": {
			name: 'Pennsylvania',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/pa.html'				
			},
		"NJ": {
			name: 'New Jersey',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/nj.html'				
			},
		"DE": {
			name: 'Delaware',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/de.html'			
			},
		"MD": {
			name: 'Maryland',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/md.html'						
			},
		"VA": {
			name: 'Virginia',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/virginia-states-monitored/'			
			},
		"WV": {
			name: 'West Virginia',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/wv.html'				
			},
		"OH": {
			name: 'Ohio',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/oh.html'		
			},
		"IN": {
			name: 'Indiana',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/in.html'				
			},
		"IL": {
			name: 'Illinois',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/il.html'			
			},
		"CT": {
			name: 'Connecticut',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/connecticut-states-monitored/'				
			},
		"WI": {
			name: 'Wisconsin',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/wi.html'			
			},
		"NC": {
			name: 'North Carolina',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/nc.html'			
			},
		"DC": {
			name: 'District of Columbia',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/dc.html'
		},
		"MA": {
			name: 'Massachusetts',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ma.html'				
			},
		"TN": {
			name: 'Tennessee',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/tn.html'		
			},
		"AR": {
			name: 'Arkansas',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ar.html'			
			},
		"MO": {
			name: 'Missouri',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/mo.html'			
			},
		"GA": {
			name: 'Georgia',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/georgia-states-monitored/'			
			},
		"SC": {
			name: 'South Carolina',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/sc.html'			
			},
		"KY": {
			name: 'Kentucky',
			description: 'default',
			color:'#004285',
			zoomable: 'no',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ky.html'			
			},
		"AL": {
			name: 'Alabama',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/al.html'					
			},
		"LA": {
			name: 'Louisiana',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/la.html'			
			},
		"MS": {
			name: 'Mississippi',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ms.html'				
			},
		"IA": {
			name: 'Iowa',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ia.html'			
			},
		"MN": {
			name: 'Minnesota',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/mn.html'
			},
		"OK": {
			name: 'Oklahoma',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ok.html'			
			},
		"TX": {
			name: 'Texas',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/texas-states-monitored/'			
			},
		"NM": {
			name: 'New Mexico',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/nm.html'		
			},
		"KS": {
			name: 'Kansas',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ks.html'			
			},
		"NE": {
			name: 'Nebraska',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ne.html'		
			},
		"SD": {
			name: 'South Dakota',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/sd.html'
			},
		"ND": {
			name: 'North Dakota',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/nd.html'
			},
		"WY": {
			name: 'Wyoming',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/wy.html'
			},
		"MT": {
			name: 'Montana',
			description: 'default',
			color:'#0075EB',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/mt.html'
			},
		"CO": {
			name: 'Colorado',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/co.html'
			},
		"UT": {
			name: 'Utah',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/ut.html'
			},
		"AZ": {
			name: 'Arizona',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/arizona-states-monitored/'
			},
		"NV": {
			name: 'Nevada',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/nv.html'		
			},
		"OR": {
			name: 'Oregon',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/or.html'		
			},
		"WA": {
			name: 'Washington',
			description: 'default',
			color:'#004285',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/washington-states-monitored/'				
			},
		"CA": {
			name: 'California',
			description: 'default',
			color: '#580085',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/california-states-monitored/'					
			},
		"MI": {
			name: 'Michigan',
			description: 'default',
			color:'#981F33',
			hover_color: 'default',
			url: '/offices/office-of-formula-grants/title-i-achievement-focused-monitoring/michigan-states-monitored/'				
			},
		"ID": {
			name: 'Idaho',
			description: 'default',
			color: '#2D8700',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/id.html'
			},
		// Territories - Hidden unless hide is set to "no"
		"GU": {
			name: 'Guam',
			description: 'default',
			color: 'default',
			hover_color: 'default',
			url: 'default',
			hide: 'yes'
			},
		"VI": {
			name: 'Virgin Islands',
			image_source: 'x.png',			
			description: 'default',
			color: 'default',
			hover_color: 'default',
			url: 'default',
			hide: 'yes'
			},
		"PR": {
			name: 'Puerto Rico',
			description: 'default',
			color: '#6EC940',
			hover_color: 'default',
			url: '/admins/lead/account/performance/map/pr.html',
			hide: 'no'
			},
		"MP": {
			name: 'Northern Mariana Islands',
			description: 'default',
			color: 'default',
			hover_color: 'default',
			url: 'default',
			hide: 'yes'
			}		
		},
	
	locations:{
	"0": { //must give each location an id, so that you can reference it later
		name: "BIE",
		lat: 30.71, 
		lng: -78.00,
		description: 'default',
		color:'#0075EB',
		url: 'default',
		type: 'default',
		size: '/admins/lead/account/performance/map/bie.html' //Note:  You must omit the comma after the last property in an object to prevent errors in internet explorer.
		},
		//1: {
		//	name: 'Anchorage',
		//	lat: 61.2180556,
		//	lng: -149.9002778, 
		//	color: 'default',
			//type: 'circle'
	//	}
	},
	
	labels:{
		"HI": {
			color: 'default',
			hover_color: 'default',
			font_family: 'default',
			pill: 'yes',	
			width: 'default',			
		},
		"0": {
			color: 'default',
			hover_color: 'default',
			font_family: 'default',
			pill: 'yes',	
			width: 'default',			
		},
		"CT":{parent_id: 'CT', x: '932', y: '243', pill: 'yes', width: 45, display: 'all'},
		'NH':{parent_id: 'NH', x: '932', y: '183', pill: 'yes', width: 45, display: 'all'},
		"PR": {
			color: 'default',
			hover_color: 'default',
			font_family: 'default',
			pill: 'yes',	
			width: 'default',			
		}
	}
	
}



