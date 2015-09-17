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
	$scores_url = $event_url . '&view=Scores&showdrawid=1';
	$scores_html = get_html($scores_url);	
	$number_of_draws = get_number_of_draws_wct($scores_html->find(".linescoredrawlink"));
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
		return array();
	}
	$game_objects = array();	
	
	$draw_time = get_draw_time_wct($html);
	
	//Get each game
	$games = $html->find(".linescorebox");
	foreach($games as $game){	
		//Get both teams
		$teams = array();

		$players_html = $game->next_sibling();
		while($players_html->tag != 'table') {
			$players_html = $players_html->next_sibling();
			//echo "\nTag: " . $players_html->tag;
		}
		$players_html = $players_html->find("tr td table td table");
		/*
		echo count($players_html);
		echo '*****\n';
		echo $players_html[0];
		echo '******************************************************';
		echo $players_html[1];
		echo '******************************************************';
		echo $players_html[2];
		*/
		$player_count = 0;
		$team1 = new Team();
		$team2 = new Team();
		foreach($players_html as $player){		
			//Get each player
			$position = trim(str_replace(":", "", $player->find("tr")[0]->plaintext));
			$image = $player->find("tr")[1]->plaintext;
			$name = $player->find("tr")[2]->innertext;
			
			//Parse the name of the player
			$bold_position = strpos($name, "<b>");	
			$br_position = strpos($name, "<br>");
			$bold_end_position = strpos($name, "</b>");
			
			$first_name = substr($name, $bold_position + 3, $br_position - $bold_position - 3);
			$last_name = substr($name, $br_position + 4, $bold_end_position - $br_position - 4);
			
			if ($player_count < 4) {
				$team1->add_player(new Player($first_name, $last_name, $position));
			}
			else if ($player_count < 8) {
				$team2->add_player(new Player($first_name, $last_name, $position));
			}
			else {
				echo "ERROR: More than 8 players";
			}
			$player_count++;
		}
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);		
					
		//Assign hammer
		$hammer = get_hammer_wct($game);
			
		//Get the linescore
		$linescore = get_linescore_wct($game);
		
		$new_game = new Game($team1, $team2, $linescore, $hammer, $draw_time);
		$new_game->print_game();
		//Push a new game onto the game_objects array
		array_push($game_objects, $new_game);
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
		return 1;
	}
	else {
		return 2;
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

function get_draw_time_wct($html) {
	$date_string = $html->find(".linescoredrawhead")[1];
	if (stripos($date_string, "jan") !== false) $month = 1;
	if (stripos($date_string, "feb") !== false) $month = 2;
	if (stripos($date_string, "mar") !== false) $month = 3;
	if (stripos($date_string, "apr") !== false) $month = 4;
	if (stripos($date_string, "may") !== false) $month = 5;
	if (stripos($date_string, "jun") !== false) $month = 6;
	if (stripos($date_string, "jul") !== false) $month = 7;
	if (stripos($date_string, "aug") !== false) $month = 8;
	if (stripos($date_string, "sep") !== false) $month = 9;
	if (stripos($date_string, "oct") !== false) $month = 10;
	if (stripos($date_string, "nov") !== false) $month = 11;
	if (stripos($date_string, "dec") !== false) $month = 12;
	
	$dash_position = stripos($date_string, "--");
	$comma_position = stripos($date_string, ",");
	$day = trim(substr($date_string, $comma_position + 5, 3));
	
	$time = trim(substr($date_string, $dash_position + 2, 7));
	
	$year_string = $html->find(".wctlight")[3]->plaintext;
	$comma_position = stripos($year_string, ",");
	$year = trim(substr($year_string, $comma_position + 1, 5));
	
	return date_create($year . "-" . $month . "-" . $day . 	" " . $time);
}

function get_number_of_draws_wct($draw_numbers) {
	$max = 0;
	foreach($draw_numbers as $draw_number) {
		$draw_number = $draw_number->href;
		$draw_id_position = stripos($draw_number, "showdrawid=") + 11;
		$draw_number = intval(substr($draw_number, $draw_id_position));
		if ($draw_number > $max) {
			$max = $draw_number;
		}
	}
	return $max;
}

?>