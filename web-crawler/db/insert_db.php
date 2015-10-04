<?php
	include_once 'db_connect.php';
	include_once 'db_conversion.php';
	
	//Is given an array of teams and inserts all of the teams and players into the DB (Only if they weren't already there)
	function insert_teams($teams) {
		foreach($teams as $team) {
			insert_team($team);
		}
	}
	
	//Is given a team and inserts all of the players and the team into the DB
	function insert_team($team) {		
		insert_players($team);
		
		echo $team->get_player(1)->player_id . " " .  $team->get_player(2)->player_id . " " .  $team->get_player(3)->player_id . " " . $team->get_player(4)->player_id;
		pause("insert_team\n\n");
		$team_name = $team->get_position(4);
		
		$gender = gender_to_db($team->gender);
		$team_id = -1;
		
		$conn = db_connect();
		$stmt = $conn->prepare("CALL insert_team(?,?,?,?,?,?)");
		$stmt->bind_param("iiiiii", $team->get_player(1)->player_id, 
									$team->get_player(2)->player_id, 
									$team->get_player(3)->player_id, 
									$team->get_player(4)->player_id,
									$gender, $team_id);
		$stmt->execute();	
		
		$team->team_id = $team_id;
		echo "Team ID: " . $team_id;
	}
	
	//Is given a team and inserts all of the players on the team
	function insert_players($team) {
		foreach($team->players as $player) {
			insert_player($player);
		}
	}
	
	//Is given a player and inserts it into the DB. Returns the player_id
	function insert_player($player) {
		
		$gender = gender_to_db($player->gender);
		
		$conn = db_connect();
		
		$player_id = -1;
		echo $player->first_name .  $player->last_name . $gender . $player_id;
		pause("insert_player\n\n");

		
		//Check if the value exists already
		$stmt = $conn->prepare("SELECT insert_player(?, ?, ?)");
		$stmt->bind_param("ssi", $player->first_name, $player->last_name, $gender);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$player_id  = $result->fetch_array(MYSQLI_NUM)[0]; // this does work :)
		
		$player->player_id = $player_id;
		echo "Player ID: " . $player_id;
		
		return $player_id;
		
		
	}
?>