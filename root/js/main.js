$(document).ready(function() {
	
	//Preload the background
	preloadPictures(['http://tgam.wpengine.netdna-cdn.com/wp-content/uploads/2014/02/OLYK3323-OLYMPICS-CURLING-.jpg'], function(){
    	$("#landing-container").css({"background-image": "linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(http://tgam.wpengine.netdna-cdn.com/wp-content/uploads/2014/02/OLYK3323-OLYMPICS-CURLING-.jpg)", 
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