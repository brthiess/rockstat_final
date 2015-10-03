<?php
	
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
		$team_name = $team->get_position(4);
		$gender = gender_to_db($team->gender);
		
		echo "team name: " . $team_name;
		echo "GENDER: " . $gender;
		
		$stmt = $conn->prepare("INSERT INTO team (team_name, gender) VALUES (:team_name, :gender)");
		$stmt->bindParam(":team_name", $team_name);
		$stmt->bindParam(":gender", $gender);
		$stmt->execute();
		$team->team_id = $stmt->lastInsertId();
		
		echo "Team id" . $team->team_id;
		
	}
	
	//Is given a team and inserts all of the players on the team
	function insert_players($team) {
		foreach($team->players as $player) {
			insert_player($player);
		}
	}
	
	//Is given a player and inserts it into the DB. Returns the player_id
	function insert_player($player) {
		
	}
?>