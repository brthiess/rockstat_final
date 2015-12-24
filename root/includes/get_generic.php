<?php

	include_once "/db/db_search.php";
	include_once "/db/db_stats.php";

	
	//Returns player name as array.  first_name and last_name
	function get_name($player_id) {
		return \search\get_player_name($player_id);
	}
?>