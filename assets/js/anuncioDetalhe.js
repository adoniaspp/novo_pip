function slideAnuncio() {

    $(document).ready(function() {
        var options = {
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $ChanceToShow: 2,
                $AutoCenter: 1
            }
        };
        var jssor_slider1 = new $JssorSlider$('slider1_container', options);
        map = new GMaps({
            div: '#mapaModal',
            lat: 0,
            lng: 0,
            width: '100%',
            height: '300px'
        });
//                var endereco = "<?php echo $endereco->enderecoMapa(); ?>";
//                GMaps.geocode({
//                    address: endereco.trim(),
//                    callback: function(results, status) {
//                        //                        console.log(results);
//                        //                        console.log(status);
//                        if (status == 'OK') {
//                            var latlng = results[0].geometry.location;
//                            map = new GMaps({
//                                div: '#mapaModal',
//                                lat: 0,
//                                lng: 0,
//                                width: '100%',
//                                height: '300px'
//                            });
//                            //                            console.log(map);
//                            map.setCenter(latlng.lat(), latlng.lng());
//                            map.addMarker({
//                                lat: latlng.lat(),
//                                lng: latlng.lng()
//                            });
//                        }
//                    }
//                });

    });
}



