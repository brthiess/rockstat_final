//Global Charts Array
var charts = new Array();

$(document).ready(function() {

	$(".suffix").prev().on("numberChanged", function(event, new_number) {		
		$(this).next().text(get_suffix(new_number));	
	});
	$(".ghost-button").click(function() {
		var group = $(this).closest(".section").attr("data-group");	//Get the group the button was clicked in.  (Games, Player Percentages, etc.)
		var stat_type = $(this).attr("data-stat-type");		//Get the stat type.  (All, With Hammer, Without Hammer, etc.)
		if ($(this).attr("class").indexOf("clicked") >= 0) {
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
	Chart.defaults.global.responsive = false;
	$("[data-type='graph']").each(function() {
		var ctx = document.getElementById($(this).attr("id")).getContext("2d");
		charts[$(this).attr("id")] = new Chart(ctx).Pie(chartsData[$(this).attr("data-source")]);
	});
}

//Updates the given group (Games, Player Percentages, etc.) for the given stat type (All, With Hammer, Without Hammer etc)
function update(group, stat_type, startAtZero) {
	if (startAtZero === undefined) startAtZero = false;
	updateGraphs(group, stat_type);
	updateNumbers(group, stat_type, startAtZero);
}

function updateGraphs(group, stat_type) {
	//Get all graphs in the group and update them so they show the stats for the new stat type. 
	$("[data-group='" + group + "'] [data-type='graph'] ").each(function() {
		//If chart type is Pie Chart
		if ($(this).attr("data-graph-type") == "pie") {
			//Get all possible stats for this chart
			var chart_stats = $(this).attr("data-stats").split(" ");
			//Update each area of the chart
			for (var i = 0; i < charts[$(this).attr("id")].segments.length; i++) {
				charts[$(this).attr("id")].segments[i].value = stats[stat_type][chart_stats[i]];
				//console.log(stats[stat_type][chart_stats[i]]);
			}
		}
		charts[$(this).attr("id")].update();
	});
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