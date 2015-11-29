<?php

	include_once "/db/db_search.php";
	include_once "/db/db_stats.php";

	
	//Returns player name as array.  first_name and last_name
	function get_player_name($player_id) {
		return \search\get_player_name($player_id);
	}
	

	//Return array of player stats
	function get_player_stats($player_id) {	
		$player_stats = \stats\get_player_stats($player_id);
		return array("all" => $player_stats, "with"=> $player_stats, "without"=>$player_stats);
	}
?>