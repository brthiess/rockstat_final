$(document).ready(function() {	
	 $( "#search-input" ).autoComplete({
      source: function( search_term, suggest) {
        $.ajax({
          url: "/includes/get_autocomplete_results.php",
          dataType: "jsonp",
          data: {
            search: search_term
          },
          success: function( data ) {
			  var names = get_team_names(data);
			  suggest(names);
          },
		  error: function(data){
			  console.log("ERROR");
				console.log(data)
		  }
        });
      },
      minChars: 2,
    });
});

function get_team_names(data) {
	team_names = [];
	for (var i = 0; i < data.length; i++) {
		team_names.push(data[i].team_name);
	}
	return team_names;
}