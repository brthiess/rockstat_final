<?php
	include_once 'db_connect.php';
	include_once 'db_conversion.php';
	
	
	function execute_function($stmt) {
		$stmt->execute();		
		$result = $stmt->get_result();
		return $result->fetch_array(MYSQLI_NUM)[0]; // this does work :)
	}
	
	//Is given an array of teams and inserts all of the teams and players into the DB (Only if they weren't already there)
	function insert_teams($teams) {
		foreach($teams as $team) {
			insert_team($team);
		}
	}
	
	//Is given a team and inserts all of the players and the team into the DB
	function insert_team($team) {		
		$gender = gender_to_db($team->gender);
		insert_players($team);
		echo ("\n***Insert Team: \n");
		$team->print_team_with_ids();
		echo "\nGender: " . $gender;
		$team_name = $team->get_position(4);
		

		$team_id = -1;
		
		$conn = db_connect();
		$stmt = $conn->prepare("SELECT insert_team(?,?,?,?,?)");
		$stmt->bind_param("iiiii", $team->get_player(1)->player_id, 
									$team->get_player(2)->player_id, 
									$team->get_player(3)->player_id, 
									$team->get_player(4)->player_id,
									$gender);
		$stmt->execute();		
		$result = $stmt->get_result();
		$team_id = $result->fetch_array(MYSQLI_NUM)[0]; // this does work :)
		
		$team->team_id = $team_id;
		echo "\nTeam ID: " . $team_id;
		pause("\n\n");
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
		echo "Insert Player Name: " . $player->first_name . " " .  $player->last_name . "\nGender: " . $gender;
		

		
		//Check if the value exists already
		$stmt = $conn->prepare("SELECT insert_player(?, ?, ?)");
		$stmt->bind_param("ssi", $player->first_name, $player->last_name, $gender);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$player_id  = $result->fetch_array(MYSQLI_NUM)[0]; // this does work :)
		pause("\nPlayer ID Returned: " . $player_id);
		$player->player_id = $player_id;
		
		return $player_id;
		
		
	}
	
	function insert_event($event) {		
		$event->print_event();
		
		$start_date = date("Y-m-d", $event->start_date);
		$end_date = date("Y-m-d", $event->end_date);
		
		
		$conn = db_connect();
		$stmt = $conn->prepare("SELECT insert_event(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssiisssssii", $event->name, $event->format->type, $event->number_of_qualifiers, $event->FGZ, $event->category, $event->location->city, $event->location->province, $start_date, $end_date, $event->purse, $event->currency, $event->gender);
		$stmt->execute();
		$result = $stmt->get_result();
		$event_id = $result->fetch_array(MYSQLI_NUM)[0];
		pause("\nEvent ID Returned: " . $event_id);
		return $event_id;
	}
?>