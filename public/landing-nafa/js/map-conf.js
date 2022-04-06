$(document).ready(function() {

    "use strict";

    /* ========================================================================= */
    /*  Zoomer Image
    /* ========================================================================= */

    $('.zoom-image').loupe({
        width: 130, // width of magnifier
        height: 130, // height of magnifier
        loupe: 'magnifier' // css class for magnifier
    });
    setTimeout(function() {
        var magnifieTop, magnifieLeft, joomerfrm;
        joomerfrm = $('.zoom-frame');
        magnifieTop = joomerfrm.outerHeight() + joomerfrm.offset().top;
        magnifieLeft = joomerfrm.offset().left + 55;
        $('.magnifier').addClass('htfix');

        $('.magnifier').css({
            positon: 'relative',
            top: magnifieTop - 350,
            left: magnifieLeft + 200
        });
        var rcount = 1;
        $(window).resize(function() {
            magnifieTop = parseInt(joomerfrm.outerHeight());
            magnifieTop = magnifieTop / 2;
            magnifieTop = magnifieTop + parseInt(joomerfrm.offset().top);
            magnifieLeft = joomerfrm.offset().left + 55;
            if (rcount > 2) {
                $('.htfix').css({
                    top: magnifieTop - 20,
                    left: magnifieLeft
                });
            };
            rcount++;
        });
    }, 1000);

    /* ========================================================================= */
    /*  Google Map Location
    /* ========================================================================= */

    function initialize() {
        var mapOptions = {
            zoom: 15,
            scrollwheel: false,
            center: new google.maps.LatLng(30.596492, 32.271459)
        };
        var map = new google.maps.Map(document.getElementById('googleMap'),
            mapOptions);
        var marker = new google.maps.Marker({
            position: map.getCenter(),
            animation: google.maps.Animation.BOUNCE,
            icon: 'img/map_marker.png',
            map: map
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    // End

});