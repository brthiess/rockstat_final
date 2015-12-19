<?php
namespace stats;


//Returns array of player stats
function get_player_stats($player_id, $stat_type){
	$conn = db_connect();
	$stmt = $conn->prepare("CALL get_player_stats(?, ?)");
	$stmt->bind_param("is", $player_id, $stat_type);
	$stmt->execute();	
	$result = $stmt->get_result();
	return $result->fetch_all(MYSQLI_ASSOC)[0];	
}

function get_player_money($player_id) {
	$conn = db_connect();
	$stmt = $conn->prepare("CALL get_player_money(?)");
	$stmt->bind_param("i", $player_id);
	$stmt->execute();	
	$result = $stmt->get_result();
	$money_result = $result->fetch_all(MYSQLI_ASSOC);
	$money_arr = array();
	foreach($money_result as $key=> $money) {
		if($key == "") {
			$money_arr['all_years'] = $money;
		}
		else {
			$money_arr[date('Y', strtotime($money['season_start']))] = $money;
		}
	}
	return $money_arr;
}

?>