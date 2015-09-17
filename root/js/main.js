document.addEventListener("DOMContentLoaded", function(event) { 	
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