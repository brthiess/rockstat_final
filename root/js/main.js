$(document).ready(function() {
	console.log("hello");
	
	$('#search-input').autoComplete({
		minChars: 2,
		source: function(term, suggest){
			term = term.toLowerCase();
			var choices = ['ActionScript', 'AppleScript', 'Asp', 'actionblah'];
			var matches = [];
			for (i=0; i<choices.length; i++)
				if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
			suggest(matches);
		}
	});
});
function loadAutocomplete() {

}

function getSuggestions(value){
	if (value.length != 0)
		return ["Jennifer Jones", "Kevin Martin"];
	else 
		return [];
}
