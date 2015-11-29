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
?>