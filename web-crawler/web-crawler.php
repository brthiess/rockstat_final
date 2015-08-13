<?php 
include_once "simple_html_dom.php";
include_once "constants.php";
include_once "parse_wct.php";

// Create DOM from URL or file
$MAIN_URL = 'http://worldcurl.com';

$next_url = $MAIN_URL;
while($next_url != null){
	$html = get_html($next_url);
	$parsed_html = parse_html($html);
	input_html($parsed_html);
	$next_url = get_next_url($html);	
}

//Gets the html from the given url
function get_html($url){
	return file_get_html($url);
}

//Is given the html for a page, and returns 
//an array of games
function parse_html($html, $page_type){
	if ($page_type == WORLD_CURL){
		return parse_wct_html($html);
	}
	else if ($page_type == CCA){
		return parse_cca_html($html);
	}	
}

//Is given the html for a world curl page 
//and returns an array of game objects
function parse_cca_html($html){
	
}

?>