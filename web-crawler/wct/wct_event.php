<?php

include_once $directory . "parse_money_list_wct.php";

function get_event_date_wct($schedule_html, $event_url, $time) {
	$dom_lower = get_event_dom_block_lower_wct($schedule_html, $event_url);
	$date_string = $dom_lower->find("td")[0]->plaintext;
	return mktime(0,0,0,get_month_wct($date_string, $time), get_day_wct($date_string, $time), get_year_wct($schedule_html->find("html body table tbody tr td table tbody tr td font.wctlight b")[0], $date_string));
}

//Parse out the month from a date string.  
//$date is the datestring
//$time is whether you want start or end time
function get_month_wct($date, $time) {
	$MONTHS = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"); 
	//Go through each month and check if it exists in the date string
	$month = -1;
	for($i = 0; $i < count($MONTHS); $i++) {
		//Check each month
		if (stripos($date, $MONTHS[$i]) !== false) {
			if ($time == "start") {
				//If the previous month exists in the string
				if (stripos($date, $MONTHS[mod($i - 1, 12)]) !== false) {
					//This is the correct month
					$month = mod($i - 1, 12);
				}
				else {
					$month = $i;
				}
			}
			else {
				//If the next month exists in the string
				if (stripos($date, $MONTHS[mod($i + 1, 12)]) !== false) {
					$month = mod($i + 1, 12);
				}
				else {
					$month = $i;	
				}
			}
		}
	}
	if ($month == -1) {
		echo "\nMonth was -1";
	}
	return $month + 1;
}

function get_day_wct($date, $time){
	$dash_position = stripos($date, '-');
	$day = -1;
	$date_string = "";
	if ($time == 'start'){
		$date_string = substr($date, 0, $dash_position);		
	}
	else {		
		$date_string = substr($date, $dash_position + 1);
	}
	$day = intval(preg_replace("/[^0-9]/","",$date_string));
	if ($day < 0) {
		echo "\nDay was -1";
	}
	return $day;
}

function get_year_wct($year_string, $date_string){
	$dash_position = stripos($year_string, '-');
	$year = -1;
	$year_string = substr($year_string, 0, $dash_position);
	$year = intval(preg_replace("/[^0-9]/","",$year_string));
	
	if ($year < 0){
		echo "Year equals -1";
	}
	if(get_month_wct($date_string, "start") <= 6){		
		return $year + 1;
	}
	else {
		return $year;
	}
}

function get_purse_wct($purse_string) {
	$purse = -1;
	$purse = intval(preg_replace("/[^0-9]/","",$purse_string));
	if ($purse == -1) {
		echo "Purse is $-1";
	}	
	return $purse;
}

function get_gender_wct($schedule_html) {
	if (stripos($schedule_html, 'bgcolor=#F2DDDA') !== false) {
		return WOMEN;
	}
	else if (stripos($schedule_html, 'bgcolor=#CEDFE9') !== false) {
		return MEN;
	}
	return -1;
}

function get_event_dom_block_upper_wct($schedule_html, $event_url) {
	return $schedule_html->find("a[href=" . $event_url . "]")[0]->parent()->parent()->parent()->parent();
}

function get_event_dom_block_lower_wct($schedule_html, $event_url) {
	return $schedule_html->find("a[href=" . $event_url . "]")[0]->parent()->parent()->parent()->parent()->next_sibling();
}

function get_event_name_wct($schedule_html, $event_url) {
	return $schedule_html->find("a[href=" . $event_url . "]")[0]->plaintext;
}

function get_event_location_wct($schedule_html, $event_url) {
	$dom_block = get_event_dom_block_upper_wct($schedule_html, $event_url);
	$location_string = $dom_block->find("td[align=right]")[0]->plaintext;
	
	$comma_position = 	stripos($location_string, ',');
	$city = substr($location_string, 0, $comma_position);
	$province = substr($location_string, $comma_position + 1);
	
	if (strlen($city) <= 2) {
		echo "\nCity string length less than 2";
	}
	if (strlen($province) <=2) {
		echo "\nProvince string length less than 2";
	}
	return new Location($city, $province);
}

function get_event_purse_wct($schedule_html, $event_url) {
	$dom_lower = get_event_dom_block_lower_wct($schedule_html, $event_url);
	$purse_string = $dom_lower->find("td")[1]->plaintext;
	
	$purse = -1;
	$purse = intval(preg_replace("/[^0-9]/","",$purse_string));
	if ($purse == -1) {
		echo "Purse is $-1";
	}
	return $purse;
}

function get_event_currency_wct($schedule_html, $event_url) {
	$dom_lower = get_event_dom_block_lower_wct($schedule_html, $event_url);
	$purse_string = $dom_lower->find("td")[1]->plaintext;
	$open_bracket_position = stripos($purse_string, "(");
	$closed_bracket_position = stripos($purse_string, ")");
	return substr($purse_string, $open_bracket_position + 1, $closed_bracket_position - $open_bracket_position - 1);
}

function get_event_teams_wct($event_url, $gender) {
	$teams_url = $event_url . "&view=Teams";
	$teams_html = get_html($teams_url);
	$team_names = $teams_html->find(".wctlight_team_text");
	$player_names = $teams_html->find(".wctlight_player_text");

	$team_objects = array();
	for ($i = 0; $i < count($team_names); $i++){
		$team = new Team();
		

		for ($k = 4; $k >= 1; $k--) {
			$first_name = explode("<br>", $player_names[$i * 4 + 4 - $k]->innertext)[0];
			$last_name = explode("<br>", $player_names[$i * 4 + 4 - $k]->innertext)[1];
			$team->add_player(new Player($first_name, $last_name, number_to_position($k), null, $gender));
		}
		$team->gender = $gender;
		array_push($team_objects, $team);
	}
	return $team_objects;
}

//Is given the event url and returns an array of the winnings each team received
function get_event_winnings_wct($event_url, $teams) {
	$event_page_html = get_html($event_url . "&view=Money");
	$prize_purse = $event_page_html->find(".wctlight");
	$money_list;
	for ($i = 0; $i < count($prize_purse); $i++) {
		if (stripos($prize_purse[$i], "prize purse") !== false) {
			//echo $prize_purse[$i];
			$money_list = $prize_purse[$i]->parent()->parent()->parent()->next_sibling();
			break;
		}
	}
	$rows = $money_list->find("tr td table tr");
	$event_winnings_objects = array();
	for($i = 1; $i < count($rows); $i++) {
		$info = $rows[$i]->find("td");
		$team = get_team_wct($info[1]->plaintext, $teams);
		$money = get_money_winnings_wct($info[2]);
		$points = get_points_wct($info[3]);
		array_push($event_winnings_objects, new Event_Team_Points($team, $money, $points));
	}
	if (count($event_winnings_objects) == 0) {
		echo "\n****Error: No rankings found.  Going to look at playoffs draw*****\n";
		$event_winnings_objects = get_event_winnings_wct_workaround($event_url);
	}
	return $event_winnings_objects;

}

function get_event_category_wct($schedule_html, $event_url) {
	$event_row = get_event_dom_block_upper_wct($schedule_html, $event_url);
	if (stripos($event_row, "grandslam") !== false) {
		RETURN GRAND_SLAM;
	}
	else {
		RETURN WCT;
	}
}

//If getting the initial rankings failed, this function will do a less reliable lookup at the playoffs page
function get_event_winnings_wct_workaround($event_url) {
	$event_playoffs_html = get_html($event_url . "&view=Playoffs");
	$bracket_html = $event_playoffs_html->find("font.teams");
	echo "Count: " . count($bracket_html);
	$html_bracket_rank = 1;
	$teams_found = array();
	$event_winnings_objects = array();
	//Go backwards through the bracket.  Start at champ and work way backwards.
	foreach($bracket_html as $team_bracket) {
		$team = get_team_wct($team_bracket->plaintext);
		//If the team has not already been added, add it.
		if (!in_array($team, $teams_found)) {
			array_push($event_winnings_objects, new Event_Team_Points($team, -1, -1, 6));
			array_push($teams_found, $team);
		}
	}
	if (count($event_winnings_objects) == 0) {
		echo "\n****Error: No rankings found again...***\n";
	}
	return $event_winnings_objects;
}

function get_event_format_wct($event_url) {
	$event_html = get_html($event_url);
	$event_info_html = $event_html->find(".wctlight");
	$number_of_qualifiers = preg_replace("/[^0-9]/","",substr($event_info_html[7]->plaintext, stripos($event_info_html[7]->plaintext, "(")));
	$event_type = $event_info_html[9]->plaintext;
	//echo "Number of qualifiers: " . $number_of_qualifiers;
	//echo "Event Type: " . $event_type;
	return new Format($event_type, $number_of_qualifiers);
}

function get_event_FGZ($event_category) {
	if (stripos($event_category, "WCT") !== false) {
		return 4;
	}
	else if (stripos($event_category, "Slam") !== false) {
		return 5;
	}
	else {
		echo "\n****Error: FGZ not found****";
		return 4;
	}
}

?>