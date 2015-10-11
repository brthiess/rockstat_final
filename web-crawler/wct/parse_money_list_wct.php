<?php

function get_team_wct($team_string, $teams){
	$comma_position = stripos($team_string, ",");
	$last_name = trim(substr($team_string, 0, $comma_position));
	$team = get_team_from_last_name($last_name, $teams);
	return $team;
}

function get_money_winnings_wct($money_string) {
	return preg_replace("/[^0-9]/","",$money_string);
}

function get_points_wct($points_string) {
	return filter_var($points_string, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

?>