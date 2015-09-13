<?php 
include_once "simple_html_dom.php";
include_once "constants.php";
include_once "wct/parse_wct.php";

// Create DOM from URL or file
$MAIN_URL = 'test.html';

$schedule_url = 'schedule.html';
$schedule_html = get_html($schedule_url);

$next_event_url = get_next_event_url($schedule_html, null);	
while($next_event_url != null){
	$parsed_event_html = parse_event_html($schedule_html, $next_event_url);
	if ($parsed_event_html != null)
		input_html($parsed_event_html);
	$next_event_url = get_next_event_url($schedule_html, $next_event_url);	
}

//Gets the html dom object from the given url
function get_html($url){
	return file_get_html($url);
}

//Is given the url for an event page, and returns 
//an event object.
//Returns null if nothing to parse
function parse_event_html($schedule_html, $event_url){
	$page_type = get_page_type($schedule_html);
	if ($page_type == WORLD_CURL){
		$event = get_basic_event_information_wct($schedule_html, $event_url);
		$event->games = get_event_games_wct($event_url);
		return $event;
	}
	else if ($page_type == CCA){
		$event = get_basic_event_information_cca($schedule_html, $event_url);
		$event->games = get_event_games_cca(get_html($event_url));
		return $event;
	}	
}

//Returns the next event URL to visit
function get_next_event_url($schedule_html, $previous_event_url) {
	if ($previous_event_url == null){
		return "http://www.worldcurl.com/events.php?task=Event&eventid=3805";
	}
	return null;
}


//Returns the page type:  CCA or WorldCurl for now
function get_page_type($html){
	return WORLD_CURL;
}

?>