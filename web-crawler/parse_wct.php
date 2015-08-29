<?php
include_once "simple_html_dom.php";
include_once "curling.php";

//Is given the html for a world curl page 
//and returns an array of game objects
//Returns null if nothing to parse
//Otherwise returns an array of game objects
function parse_wct_html($html){
	$page_type = get_page_type_wct($html);
	if ($page_type == WCT_EVENT_PAGE) 
		parse_wct_event_page($html);
	else {
		if ($page_type == ERROR)
			echo "\n*****ERROR: Can't Determine Page Type****";
		return null;	
	}
}

//Is given a page with scores on it
function parse_wct_event_page($html) {
	//First check to make sure we are on a page that has scores on it.  If not, return null
	if (!wct_page_has_scores_on_it($html))
		return null;
	
	$game_objects = array();
	//Get each game
	$games = $html->find(".linescorebox");
	foreach($games as $game){
		$teams_html = $game->find(".linescoreteam");
		
		//Get both teams
		$teams = array();
		foreach($teams_html as $team){
			array_push($teams,$team->find(".linescoreteamlink")[0]->plaintext);
		}
		//Check that there are only 2 teams
		if (count($teams) != 2) {
			echo 'Found a game with' . count($teams) . 'teams';
		}
		
		//Assign hammer
		$hammer = $game->find(".linescorehammer");
		//Check if the upper linescore team has hammer
		if (strpos($hammer[0]->plaintext, 'hammer.gif') !== false) {
			$hammer = 0;
		}
		else {
			$hammer = 1;
		}
		$linescore = new LineScore();
		$ends = $game->find(".linescoreend");
		$number_of_ends = count($ends)/2;
		for($i = 0; $i < $number_of_ends; $i++){
			echo $ends[$i]->plaintext;
			$linescore->addEnd($ends[$i]->plaintext, $ends[$i + $number_of_ends]->plaintext);
		}
		$linescore->print_linescore();
		
	}	
}

//Check to see if the page has curling scores on it.
function wct_page_has_scores_on_it($html) {
	$teams = $html->find('.linescoreteamlink');
	if (count($teams) == 0) {
		return false;
	}
	return true;
}

//Returns the page type 
// 1 = Main Page
// 2 = Schedule Page
// 3 = Event Page
function get_page_type_wct($html){
	$main_page = 0;
	$schedule_page = 0;
	$event_page = 0;
	
	$dom = str_get_html($html);
	
	$title = $dom->find('title');
	foreach($title as $title_name) {
		if($title_name->innertext == "World Curling Tour") {
			$main_page += 1;
			$schedule_page += 1;
		}
	}
	
	if (strpos($html, "Top 20 Women") !== false) $main_page += 1;
	if (strpos($html, "Top 20 Men") !== false) $main_page += 1;
	if (strpos($html, "Men's Money List") !== false) $main_page += 1;
	if (strpos($html, "Women's Money List") !== false) $main_page += 1;
	if (strpos($html, "Featured Profile") !== false) $main_page += 1;
	if (strpos($html, "Social Media") !== false) $main_page += 1;
	if (strpos($html, "Sheet Show") !== false) $main_page += 1;
	if (substr_count($html, "youtube") >= 3) $main_page += 1;
	
	if (strpos($html, "Women's Money List") !== false) $schedule_page += 1;
	if (strpos($html, "2015-16 Tour Schedule") !== false) $schedule_page += 1;
	if (strpos($html, "2015-16 Tour Schedule") !== false) $schedule_page += 1;
	if (strpos($html, "Men's Money List") !== false) $schedule_page += 1;
	if (substr_count($html, "Week") > 6) $schedule_page += 1;
	if (substr_count($html, "Purse") > 6) $schedule_page += 1;
	if (substr_count($html, "Format") > 6) $schedule_page += 1;
	if (substr_count($html, "Round Robin") > 6) $schedule_page += 1;
	
	if (strpos($html, "Statistics") !== false) $event_page += 1;
	if (strpos($html, "Scores") !== false) $event_page += 1;
	if (strpos($html, "Playoffs") !== false) $event_page += 1;
	if (strpos($html, "Draw") !== false) $event_page += 1;
	if (strpos($html, "Teams") !== false) $event_page += 1;
	if (strpos($html, "News") !== false) $event_page += 1;
	if (strpos($html, "HMR") !== false) $event_page += 1;
	if (strpos($html, "SF") !== false) $event_page += 1;
	if (strpos($html, "qualifiers") !== false) $event_page += 1;
	
	if ($main_page > $schedule_page && $main_page > $event_page) 
		return WCT_HOME_PAGE;
	else if ($schedule_page > $main_page && $schedule_page > $event_page)
		return WCT_SCHEDULE_PAGE;
	else if ($event_page > $schedule_page && $event_page > $main_page)
		return WCT_EVENT_PAGE;
	else
		return ERROR;
	
}
?>