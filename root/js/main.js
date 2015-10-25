$(document).ready(function() {	
	 $( "#search-input" ).autoComplete({
      source: function( request, response ) {
		  console.log(request);
        $.ajax({
          url: "/includes/get_autocomplete_results.php",
          dataType: "jsonp",
          data: {
            q: request
          },
          success: function( data ) {
			handleData(data);
          }
        });
      },
      minLength: 2,
    });
});
function loadAutocomplete() {

}

function handleData(data){
	console.log(data);
}

function getSuggestions(value){
	if (value.length != 0)
		return ["Jennifer Jones", "Kevin Martin"];
	else 
		return [];
}
