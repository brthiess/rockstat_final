<?php
namespace stats;


//Returns array of player stats
function get_player_stats($player_id){
	$conn = db_connect();
	$stmt = $conn->prepare("CALL get_player_stats(?)");
	$stmt->bind_param("i", $player_id);
	$stmt->execute();	
	$result = $stmt->get_result();
	return $result->fetch_all(MYSQLI_ASSOC)[0];	
}
?>