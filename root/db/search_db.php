<?php
/**************
Includes all functions relevant to searching the database
***************/
namespace search;


include_once 'db_connect.php';




	function get_search_results($search_term) {
		$teams = get_matching_teams($search_term);
		$players = get_matching_players($search_term);
		return $teams;
	}
	
	//Returns 2D array.  Each sub array has following keys
	//id => team_id
	//type => "Team"
	//name => team name
	//image => location
	function get_matching_teams($search_term) {
		$conn = db_connect();
		$stmt = $conn->prepare("CALL search_teams(?)");
		$stmt->bind_param("s", $search_term);
								
		$stmt->execute();	
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$teams = array();
		foreach($rows as $row) {
			array_push($teams, array('id' => $row['team_id'], 'type' => 'Team', 'name' => $row['team_name'], 'image' => $row['location']));
		}
		return $teams;
	}
	
	function get_matching_players($search_term) {
		$conn = db_connect();
		$stmt = $conn->prepare("CALL search_players(?)");
		$stmt->bind_param("s", $search_term);
		
		$stmt->execute();	
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$players = array();
		foreach($rows as $row) {
			array_push($players, array('id' => $row['player_id'], 'type' => 'Team', 'name' => $row['first_name'] + ' ' + $row['last_name'], 'image' => $row['gender']));
		}
		return $players;
	}
	
	//Searches for all players on given team id
	function get_players_by_team_id($id) {
		$conn = db_connect();
		$stmt = $conn->prepare("CALL search_player_by_team(?)");
		$stmt->bind_param("i", $id);
		$stmt->execute();	
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
?>