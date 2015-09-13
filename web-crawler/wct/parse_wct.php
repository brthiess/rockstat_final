<?php
$directory = dirname(__DIR__) . "/wct/";
include_once $directory .  "../simple_html_dom.php";
include_once $directory . "../curling.php";
include_once $directory . "../constants.php";
include_once $directory . "../math.php";
include_once $directory . "wct_event.php";

//Is given the html dom object for a world curl page 
//and returns an array of game objects
//Returns null if nothing to parse
//Otherwise returns an array of game objects
function get_event_games_wct($event_url){
	$game_objects = array();
	$scores_url = $event_url . '&view=Scores';
	$scores_html = get_html($scores_url);	
	$number_of_draws = count($scores_html->find(".linescoredrawlink")) + 1;
	for($draw_id = 1; $draw_id <= $number_of_draws; $draw_id++) {
		$draw_url = $event_url . '&view=Scores&showdrawid=' . $draw_id;
		$html = get_html($draw_url);
		$page_type = get_page_type_wct($html);
		if ($page_type == WCT_EVENT_PAGE) 
			array_merge($game_objects, parse_wct_event_page($html));
		else {
			if ($page_type == ERROR)
				echo "\n*****ERROR: Can't Determine Page Type****";	
		}
	}
	return $game_objects;
}

//Gets the basic event information from the schedule_page and event url
function get_basic_event_information_wct($schedule_html, $event_url) {
	//if page contains pink background
	$event_gender = get_gender_wct($schedule_html);
	if ($event_gender == -1) {
		echo "\nNo Gender Found.  Error";
	}
	$event_name = get_event_name_wct($schedule_html, $event_url);
	$event_location = get_event_location_wct($schedule_html, $event_url);
	$start_date = get_event_date_wct($schedule_html, $event_url, "start");
	$end_date = get_event_date_wct($schedule_html, $event_url, "end");
	$event_purse = get_event_purse_wct($schedule_html, $event_url);
	$event_currency = get_event_currency_wct($schedule_html, $event_url);	
	
	$event = new Event($event_location, $start_date, $end_date, $event_purse, $event_currency, $event_name, $event_gender);
	$event->print_event();
	return new Event($event_location, $start_date, $end_date, $event_purse, $event_currency, $event_name, $event_gender);
}

//Is given a page with scores on it
//And returns an array of games
function parse_wct_event_page($html) {
	//First check to make sure we are on a page that has scores on it.  If not, return null
	if (!wct_page_has_scores_on_it($html)) {
		echo "\nERROR: Page has no scores";
		return null;
	}
	
	$game_objects = array();	
	
	
	//Get each game
	$games = $html->find(".linescorebox");
	foreach($games as $game){	
		
		//Get both teams
		$teams = array();
		$players_html = $game->next_sibling()->find("tbody tr td table tbody tr td");
		$player_count = 0;
		$team1 = new Team();
		$team2 = new Team();
		foreach($players_html as $player){

			//Get each player
			$position = $player->find("tr")[0]->plaintext;
			$image = $player->find("tr")[1]->plaintext;
			$name = $player->find("tr")[2]->plaintext;	
			
			if ($player_count < 4) {
				$team1->add_player(new Player($name, $name, $position));
			}
			else if ($player_count < 8) {
				$team2->add_player(new Player($name, $name, $position));
			}
			else {
				echo "ERROR: More than 8 players";
			}
		}

		
		//Assign hammer
		$hammer = get_hammer_wct($game);
		
		//Get the linescore
		$linescore = get_linescore_wct($game);
		
		//Push a new game onto the game_objects array
		array_push($game_objects, new Game($team1, $team2, $linescore, $hammer));
	}
	return $game_objects;
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


//Get the hammer given a html game object on the world curl website
function get_hammer_wct($game) {
	$hammer = $game->find(".linescorehammer");
	//Check if the upper linescore team has hammer
	if (strpos($hammer[0]->plaintext, 'hammer.gif') !== false) {
		return 0;
	}
	else {
		return 1;
	}	
}

function get_linescore_wct($game){
	$linescore = new LineScore();
	$ends = $game->find(".linescoreend");
	$number_of_ends = count($ends)/2;
	
	//Common sense check.  If game has 2 or less ends something is wrong.
	if ($number_of_ends <=2) {
		echo 'Found a game with <= 2 ends';
	}
	for($i = 0; $i < $number_of_ends; $i++){
		$linescore->addEnd(str_replace("&nbsp;", "", $ends[$i]->plaintext), str_replace("&nbsp;", "", $ends[$i + $number_of_ends]->plaintext));
	}
	return $linescore;
}


//Is given the html for a page and returns an event object
function get_event_wct($html) {
	$event_name = $html->find(".wctlight")[0]->plaintext;
	//Common Sense check
	if (strlen($event_name) <= 3) {
		echo 'Short Event name found';
	}
	
	$event_location = $html->find(".wctlight")[1]->plaintext;
	//Common Sense check
	if (strlen($event_location) <= 3) {
		echo 'Short Event location found';
	}
	//Get the event date
	$event_date_html = str_replace("&nbsp;", "", $html->find(".wctlight")[3]->plaintext);
	$start_date = get_date_wct($event_date_html, "start");
	$end_date = get_date_wct($event_date_html, "end");
	
	//Get the event purse
	$event_purse = get_purse_wct($html->find(".wctlight")[5]->plaintext);
	
	$event_currency = get_currency_wct($html->find(".wctlight")[5]->plaintext);
	
	$event_gender = get_gender_wct($html);

	return new Event($event_location, $start_date, $end_date, $event_purse, $event_currency, $event_name, $event_gender);
}


?>