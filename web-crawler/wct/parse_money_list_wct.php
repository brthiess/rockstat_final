<?php

function get_rank_wct($rank_string){ 
	return preg_replace("/[^0-9]/","",$rank_string);
}

function get_team_wct($team_string){
	$comma_position = stripos($team_string, ",");
	$last_name = trim(substr($team_string, 0, $comma_position));
	$first_name = trim(substr($team_string, $comma_position + 1));
	$player = new Player($first_name, $last_name, "Skip");
	$team = new Team();
	$team->add_player($player);
	return $team;
}

function get_money_winnings_wct($money_string) {
	return preg_replace("/[^0-9]/","",$money_string);
}

function get_points_wct($points_string) {
	return filter_var($points_string, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

?>