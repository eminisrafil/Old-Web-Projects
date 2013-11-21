(function() {
    var myOptions;
    var map;

    function initializemap() {
        myOptions = {
            center: new google.maps.LatLng(0, 0),
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false,
            enableHighAccuracy: true,
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        start();
    }

    function geo() {
        if (navigator.geolocation)
            navigator.geolocation.getCurrentPosition(update_geo, handler);
        else
            alert("Geolocation not supported by your browser!");
    }


    function update_geo(pos) {
        user.lat = pos.coords.latitude;
        user.lng = pos.coords.longitude;
    }


    // perform geo lookup, but only if the geolocation object exists

    function start() {
        if (navigator.geolocation)
            navigator.geolocation.getCurrentPosition(print_geo, handler);
        else
            alert("Geolocation not supported by your browser!");
    }

    // geolocation error handler

    function handler(err) {
        alert("Error #" + err.code + ": " + err.message);
    }

    // geolocation callback function        

    function print_geo(pos) {

        // fetch coordinates and store into a Google Maps LatLng object
        var latlng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
        var latlng2 = new google.maps.LatLng(pos.coords.latitude + .001, pos.coords.longitude + .001);

        //console.log(pos.coords.latitude);
        //console.log(pos.coords.longitude);
        //console.log(latlng);
        //console.log(latlng2);
        // set the center of the map to the location
        map.setCenter(latlng);

        // display a marker at the location
        var marker1 = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: latlng
        });

        // display a circle showing the accuracy radius
        var circle = new google.maps.Circle({
            map: map,
            clickable: true,
            center: latlng,
            //radius: (pos.coords.accuracy) 
            radius: 15
        });

        // reset the zoom to show the entirety of the accuracy radius
        //map.fitBounds(circle.getBounds());
    }

    function markers(array) {


        var infowindow = new InfoBubble({
            map: map,
            shadowStyle: 0,
            padding: 0,
            backgroundColor: 'rgb(57,57,57)',
            borderRadius: 4,
            arrowSize: 10,
            borderWidth: 1,
            borderColor: '#2c2c2c',
            disableAutoPan: true,
            hideCloseButton: true,
            arrowPosition: 30,
            backgroundClassName: 'phoney',
            arrowStyle: 2
        });

        for (i = 0; i < array.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(array[i][1], array[i][2]),
                map: map,
                draggable: true,
                flat: true,
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent('<div class = phoneytext>' + array[i][0] + '</div>');
                    infowindow.open(map, marker);
                }
            })(marker, i));
            /*  
			var circle2 = new google.maps.Circle({
				map: map,
				clickable: true,
				center: new google.maps.LatLng(array[i][1], array[i][2]),
				//radius: (pos.coords.accuracy) 
				radius: 15 
			});
			
			google.maps.event.addListener(circle2, 'click', (function(circle2, i) {
				return function() {
				  infowindow.setContent('<div class = phoneytext>' +array[i][0]+ '</div>');
				  infowindow.open(map, circle2);
				}
			})(circle2, i));*/
        }

        google.maps.event.addListener(map, 'click', (function() {
            if (infowindow.isOpen()) {
                infowindow.close();
            }
        }));

    }
})();