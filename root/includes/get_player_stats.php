<?php
	include_once "/db/db_stats.php";
	
	function get_player_stats($player_id) {
		
		return array( "all" => array("games"=>49, "games-rank"=>214, "wins"=>5, "wins-rank"=>44, "losses"=>44, "losses-rank"=>55, "win-percentage"=>5, "win-percentage-rank"=>22, "losing-percentage"=> 95), "with" => array("games"=>33, "games-rank"=>21, "wins"=>3, "wins-rank"=>44, "losses"=>223, "losses-rank"=>99, "win-percentage"=>33, "win-percentage-rank"=>67, "losing-percentage"=> 67), "without" => array("games"=>44, "games-rank"=>21, "wins"=>2, "wins-rank"=>442, "losses"=>44, "losses-rank"=>55, "win-percentage"=>15, "win-percentage-rank"=>22, "losing-percentage"=> 85));
	}
?>