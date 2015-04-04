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
    });
}



