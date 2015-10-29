<?php
/**************
Includes all functions relevant to searching the database
***************/
namespace search;


include_once 'db_connect.php';




	function get_search_results($search_term) {
		$teams = get_matching_teams($search_term);
		return $teams;
	}
	
	function get_matching_teams($search_term) {
		$conn = db_connect();
		$stmt = $conn->prepare("CALL search_teams(?)");
		$stmt->bind_param("s", $search_term);
								
		$stmt->execute();	
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
?>