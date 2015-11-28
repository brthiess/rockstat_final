$(document).ready(function() {
	$(".suffix").prev().on("numberChanged", function(event, new_number) {		
		$(this).next().text(get_suffix(new_number));	
	});
	$(".ghost-button").click(function() {
		var group = $(this).closest(".section").attr("data-group");	//Get the group the button was clicked in.  (Games, Player Percentages, etc.)
		var stat_type = $(this).attr("data-stat-type");		//Get the stat type.  (All, With Hammer, Without Hammer, etc.)
		if ($(this).attr("class").indexOf("clicked") >= 0) {
			console.log("ASDF");
			$("[data-group='" + group + "'] .ghost-button").removeClass("clicked");
			update(group, "all");
		}
		else {
			$("[data-group='" + group + "'] .ghost-button").removeClass("clicked");
			$(this).addClass("clicked");
			update(group, stat_type);
		}		
	});
	init_graphs();
	update("games", "all", true);
	
});


//Initiatilize the graph variables
function init_graphs() {
	$("[data-type='graph']").each(function() {
		var ctx = document.getElementById($(this).attr("id")).getContext("2d");
		var myNewChart = new Chart(ctx).Pie(chartsData[$(this).attr("data-source")]);
	});
}

//Updates the given group (Games, Player Percentages, etc.) for the given stat type (All, With Hammer, Without Hammer etc)
function update(group, stat_type, startAtZero) {
	if (startAtZero === undefined) startAtZero = false;
	updateGraphs();
	updateNumbers(group, stat_type, startAtZero);
}

function updateGraphs() {
	
}

function updateNumbers(group, stat_type, startAtZero) {	
	$("[data-group='" + group + "'] [data-type='number'] ").each(function() {		
		count(this, stats[stat_type][$(this).attr("data-stat")], startAtZero);
	});
}
	
//Animate the given number to change to the new number
function count(div, ending_number, startAtZero) {
		var starting_number = $(div).text().match(/\d+/)[0];	//Start with previous number unless page has just loaded
		if (startAtZero) {
			starting_number = 0;
		}
		$(div).prop('Counter', starting_number).animate({
			Counter: ending_number
		}, {
			duration: 800,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
				$(this).trigger("numberChanged", Math.ceil(now));
			}
		});
}
//Is given a number and returns the appropriate suffix.  (st nd rd etc)
function get_suffix(number){
    var j = number % 10,
        k = number % 100;
    if (j == 1 && k != 11) {
        return "st";
    }
    if (j == 2 && k != 12) {
        return "nd";
    }
    if (j == 3 && k != 13) {
        return "rd";
    }
    return "th";
}