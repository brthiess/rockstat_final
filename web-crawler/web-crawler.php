<?php 
include_once "simple_html_dom.php";
include_once "constants.php";
include_once "wct/parse_wct.php";
include_once "db/input.php";
include_once "fake_data.php";

// Create DOM from URL or file
$schedule_url = 'http://www.worldcurl.com/schedule.php?eventtypeid=21';
$schedule_html = get_html($schedule_url);

$next_event_url = get_next_event_url($schedule_html, null);	

while($next_event_url != null){
	//$parsed_event_html = parse_event_html($schedule_html, $next_event_url);
	$parsed_event_html = fake_event_data();
	if ($parsed_event_html != null)
		input_html($parsed_event_html);
	$next_event_url = get_next_event_url($schedule_html, $next_event_url);	
}

//Gets the html dom object from the given url
function get_html($url){
	while(true) {
		try {
			$html = file_get_html($url);
			break;
		}
		catch(Exception $e) {
			echo "\n**Failed to get html.  Trying again**\n";
		}
	}
	return replace_links_with_base_url(get_base_url($url), $html);
}

//Is given the url for an event page, and returns 
//an event object.
//Returns null if nothing to parse
function parse_event_html($schedule_html, $event_url){
	$page_type = get_page_type($schedule_html);
	if ($page_type == WORLD_CURL){
		$event = get_basic_event_information_wct($schedule_html, $event_url);
		$event->games = get_event_games_wct($event_url, $event);
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
	$urls = $schedule_html->find("a");
	
	$found_previous_url = false;
	foreach($urls as $url){
		//Look for previous url
		if ($previous_event_url != null && $url->href == $previous_event_url) {
			$found_previous_url = true;
			continue;
		}
		//If we have found previous url, then look for next event url
		if ($found_previous_url == true && stripos($url->href, "events.php?task=Event&eventid=") !== false) {
			return $url->href;
		}
		if ($previous_event_url == null && stripos($url->href, "events.php?task=Event&eventid=") !== false) {
			return $url->href;
		}
	}
	return null;
}


//Returns the page type:  CCA or WorldCurl for now
function get_page_type($html){
	return WORLD_CURL;
}


//Adds the base url to all links in the html if necessary
function replace_links_with_base_url($base_url, $html) {
	$links = $html->find("a");
	for ($i = 0; $i < count($links); $i++){
		if (!(stripos($links[$i]->href, $base_url) !== false)) {  //If the link does not contain the base url.  Add it.
			$links[$i]->href =  $base_url . $links[$i]->href;
		}		
	}
	return $html;
}


//Gets the base url from the given url
function get_base_url($url) {
	$position = strposOffset("/", $url, 3);
	return substr($url, 0, $position + 1);	
}



?>