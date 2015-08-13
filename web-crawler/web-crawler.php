<?php 
include_once "simple_html_dom.php";
include_once "constants.php";
include_once "parse_wct.php";

// Create DOM from URL or file
$MAIN_URL = 'http://www.worldcurl.com/events.php?task=Event&eventid=3875';

$next_url = $MAIN_URL;
while($next_url != null){
	$html = get_html($next_url);
	$parsed_html = parse_html($html);
	if ($parsed_html != null)
		input_html($parsed_html);
	$next_url = get_next_url($html);	
}

//Gets the html from the given url
function get_html($url){
	return file_get_html($url);
}

//Is given the html for a page, and returns 
//an array of games
//Returns null if nothing to parse
function parse_html($html){
	$page_type = get_page_type($html);
	if ($page_type == WORLD_CURL){
		return parse_wct_event_page($html);
	}
	else if ($page_type == CCA){
		return parse_cca_event_page($html);
	}	
}

//Returns the next URL to visit
function get_next_url($html) {
	return null;
}


//Returns the page type:  CCA or WorldCurl for now
function get_page_type($html){
	return WORLD_CURL;
}

?>