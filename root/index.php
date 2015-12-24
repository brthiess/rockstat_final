<?php

$stat_types = array('player', 'game', 'team');

//Returns array(Page Type, [Stat Type, Stat ID]).  
function parse_url_path($path) {
	$path_arr = explode('/', $path);
	
	//Check for home page
	if (count($path_arr) <= 2 && ((isset($path[1]) && $path[1] == "") || !isset($path[1])))
		return array('page_type' => 'home');
	
	//Check for Other Pages
	if (isset($path_arr[1]) && $path_arr[1] != "" && ((isset($path_arr[2]) && $path_arr[2] == "") || !isset($path_arr[2])) && count($path_arr) <= 3) {		
		$path_bits = explode('-', $path_arr[1]);
		if (isset($path_bits[0]) && $path_bits[0] != "") {
			$stat_type = $path_bits[0];
			if (isset($path_bits[1]) && $path_bits[1] != "" && !isset($path_bits[2])) {// If true, this is a Stats Page
				$stat_id = $path_bits[1];
				return array('page_type' => 'stat', 'stat_type' => $stat_type, 'stat_id' => $stat_id); //Return the stat type and stat id 
			}
		}
	}
	return array('page_type' => '404');
}

$parsed_url = parse_url_path(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
//Include relevant stat page php file if that is the page type
if ($parsed_url['page_type'] == 'stat') {
	if (array_search(strtolower($parsed_url['stat_type']), array_map('strtolower', $stat_types)) !== false) {
		$_GET['id'] = $parsed_url['stat_id'];
		include_once($parsed_url['stat_type'] . '.php');
	}
}
else if ($parsed_url['page_type'] == 'home') {
	if (isset($_GET['q']) && $_GET['q'] != '') {
		include_once 'search.php';
	}
	else {
		include_once 'main.php';
	}
}
else {
	include_once '404.php';
}
?>