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
        var Latitude = document.getElementById("lat").value;
        var Longitude = document.getElementById("lng").value;
        if((Latitude == '' || Latitude == null) && (Longitude == '' || Longitude == null)){
            Latitude = position.coords.latitude;
            Longitude = position.coords.longitude;
        }
        document.getElementById("lat").value = Latitude;
        document.getElementById("lng").value = Longitude;
        // if(document.getElementById("lat").value != '' || document.getElementById("lat").value != null){
        //     Latitude = document.getElementById("lat").value;
        //     Longitude = document.getElementById("lng").value;
        // }


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
                if (results[1]) {
                    var arrAddress = results;
                    $.each(arrAddress, function(i, address_component) {
                        if (address_component.types[0] == "locality") {
                            $("input[name='city_name']").val(address_component.address_components[0].long_name);
                            itemLocality = address_component.address_components[0].long_name;
                        }
                    });
                }
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
                    if (results[1]) {
                        var arrAddress = results;
                        $.each(arrAddress, function(i, address_component) {
                            if (address_component.types[0] == "locality") {
                                $("input[name='city_name']").val(address_component.address_components[0].long_name);
                                itemLocality = address_component.address_components[0].long_name;
                            }
                        });
                    }
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
function getAddressParts(obj) {

    var address = [];

    obj.address_components.forEach( function(el) {
        address[el.types[0]] = el.short_name;
    });

    return address;

} //getAddressParts()
