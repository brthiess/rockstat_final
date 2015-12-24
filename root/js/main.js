$(document).ready(function() {	
	 $( "#search-input-banner, #search-input" ).autoComplete({
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
	  renderItem: function (item, search){				
            // escape special characters
            search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
            return '<div class="autocomplete-suggestion" data-type="' + item[2] + '" data-name="' + item[0] + '" data-id="' + item[1] + '">' + item[0].replace(re, "<b>$1</b>") + '</div>';
	  },
	  onSelect: function(e, term, item){
		  e.preventDefault();
		  window.location.href = "/" + item.data('type').toLowerCase() + "-" + item.data('id') + "/";
	  }
    });
});

function get_team_names(data) {
	team_names = [];
	for (var i = 0; i < data.length; i++) {
		team_names.push([data[i].name, data[i].id, data[i].type]);
	}
	return team_names;
}