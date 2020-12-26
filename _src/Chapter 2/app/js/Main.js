var Main = {

	// The map object
	map : null,

	// Google Maps Map Options
	mapOptions : {},

	// An array of markers
	markers : [],

	/**
	 * Loads the map object and displays it
	 */
	loadMap : function(lat, lng) {
		zoom = 16;
		if (lat == undefined && lng == undefined)
		{
			lat = "41.878114";
			lng = "-87.629798";
			zoom = 13;
		}
		
		Main.mapOptions = {
			zoom: zoom,
			center: Main.createLocation(lat, lng),
		};

		Main.map = new google.maps.Map(document.getElementById("map-canvas"), Main.mapOptions);
	},

	/**
	 * Creates a new Google Maps location object
	 */
	createLocation : function(lat,lng) {
		return new google.maps.LatLng(lat,lng);
	},

	/**
	 * Adds a new Map Marker to the map
	 * @param GoogleMapsLatLong position 	The position of where our new marker is
	 * @param string title 					The title for a new marker
	 */
	addMarker : function(position, title, icon) {
		if (icon == true)
		{
			var pinColor = "2F76EE"; // a random blue color that i picked
			var icon = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
			            new google.maps.Size(21, 34),
			            new google.maps.Point(0,0),
			            new google.maps.Point(10, 34));
		}

		var marker = new google.maps.Marker({
		    position: position,
		    title: title,
		    icon: icon,
		    types : [
		    	'clothing_store',
		    	'convenience_store',
		    	'book_store',
		    	'shoe_store',
		    	'store',
		    	'restaurant',
		    	'transit_station',
		    	'food'
		    ]
		});

		Main.markers.push(marker);
		marker.setMap(Main.map)
	},

	/**
	 * Clears all map markers from the map and removes all references to them
	 */
	clearMarkers : function() {
		$(Main.markers).each(function() {
			this.setMap(null);
		});

		Main.markers = [];
	}
};