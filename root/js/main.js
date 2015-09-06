document.addEventListener("DOMContentLoaded", function(event) { 

	var screen_type = window.innerWidth > 700 ? "desktop" : "mobile";  //Mobile or desktop background
	var image_url = "/images/" + screen_type + "/background-" + Math.floor((Math.random() * 17) + 1) + ".jpg";
	
	//Preload the background
	preloadPictures([image_url], function(){
    	document.getElementById("landing-container").className += "landing-container";
		document.getElementById("landing-container").style.backgroundImage = "linear-gradient(rgba(0, 0, 0, 0.298039), rgba(0, 0, 0, 0.298039)), url(" + image_url + ")";
	});
	
	loadAutocomplete();

});

function loadAutocomplete() {
	document.getElementById('search-input').onkeyup=function(){		
		showSuggestions(getSuggestions(this.value));
	};
}

function getSuggestions(value){
	return ["Jennifer Jones", "Kevin Martin"];
}

function showSuggestions(suggestions){
	if (suggestions.length == 0) {
		
	}
}

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