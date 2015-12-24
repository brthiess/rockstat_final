<?php

	include_once "/db/db_search.php";
	include_once "/db/db_stats.php";

	
	//Returns player name as array.  first_name and last_name
	function get_team_name($team_id) {
		return \search\get_team_name($team_id);
	}
	

	//Return array of player stats
	function get_team_stats($player_id) {			
		$player_stats = array("all" => \stats\get_player_stats($player_id, "all"), 
					 "with"=> \stats\get_player_stats($player_id, "with"), 
					 "without"=>\stats\get_player_stats($player_id, "without"));
		return $player_stats +  \stats\get_player_money($player_id);
	}
?>