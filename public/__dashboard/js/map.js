var map, infoWindow, geocoder;

function initMap() {

    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        innerHTML = " حدث خطا أتناء تحديد الموفع ";
    }

    function showPosition(position) {
        var Latitude = position.coords.latitude;
        var Longitude = position.coords.longitude;

        document.getElementById("lat").value = Latitude;
        document.getElementById("lng").value = Longitude;

        var latlng = new google.maps.LatLng(Latitude, Longitude);
        var map = new google.maps.Map(document.getElementById('map'), {
            center: latlng,
            zoom: 16,
            disableDefaultUI: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            draggable: true
        });

        var searchBox = new google.maps.places.SearchBox( document.getElementById( 'address' ) );
        google.maps.event.addListener( searchBox, 'places_changed', function () {
            var places = searchBox.getPlaces();
            var bounds = new google.maps.LatLngBounds();
            var i, place;
            for ( i = 0; place = places[ i ]; i++ ) {

                bounds.extend( place.geometry.location );
                marker.setPosition( place.geometry.location );

            }
            map.fitBounds( bounds );
            map.setZoom( 12 );
        } );
        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $("input[name='address']").val(results[0].formatted_address);
                    infowindow.setContent(results[0].formatted_address);
                    //infowindow.open(map, marker);
                }
            }
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {

            document.getElementById("lat").value = this.getPosition().lat();
            document.getElementById("lng").value = this.getPosition().lng();

            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        $("input[name='address']").val(results[0].formatted_address);
                        infowindow.setContent(results[0].formatted_address);
                        //infowindow.open(map, marker);
                    }
                }
            });
        });
    }
}