$(document).ready(function() {
	var image_url = "/images/desktop/background-" + Math.floor((Math.random() * 17) + 1) + ".jpg";
	
	//Preload the background
	preloadPictures([image_url], function(){
    	$("#landing-container").css({"background-image": "linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(" + image_url + ")", 
								 "background-size" :  "100%",
								 "animation" : "fadein 2s"});
	});

});



//Used to load the background, in the background!
var preloadPictures = function(pictureUrls, callback) {
    var i,
        j,
        loaded = 0;

    for (i = 0, j = pictureUrls.length; i < j; i++) {
        (function (img, src) {
            img.onload = function () {                               
                if (++loaded == pictureUrls.length && callback) {
                    callback();
                }
            };

            // Use the following callback methods to debug
            // in case of an unexpected behavior.
            img.onerror = function () {};
            img.onabort = function () {};

            img.src = src;
        } (new Image(), pictureUrls[i]));
    }
};