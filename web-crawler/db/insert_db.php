<?php
	include_once 'db_connect.php';
	include_once 'db_conversion.php';
	include_once 'manage_db.php';
	
	
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
		echo "\n\n\n*******Inserting Event******";
		$event->print_event();
		
		$start_date = date("Y-m-d", $event->start_date);
		$end_date = date("Y-m-d", $event->end_date);
		
		
		$conn = db_connect();
		$stmt = $conn->prepare("SELECT insert_event(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssiisssssiii", $event->name, $event->format->type, $event->number_of_qualifiers, $event->FGZ, $event->category, $event->location->city, $event->location->province, $start_date, $end_date, $event->purse, $event->currency, $event->gender);
		$stmt->execute();
		$result = $stmt->get_result();
		$event_id = $result->fetch_array(MYSQLI_NUM)[0];
		pause("\nEvent ID Returned: " . $event_id);
		return $event_id;
	}
	
	function insert_rankings($rankings, $event_id) {
		$conn = db_connect();		
		foreach($rankings as $ranking) {	
			
			$ranking->print_individual_team_winnings();
			echo "\nTeam ID: " . $ranking->team->team_id;
			echo "\nEvent ID: " . $event_id;
			
			echo "Inserting Ranking";
			
			
			$stmt = $conn->prepare("SELECT insert_rankings(?, ?, ?, ?)");
			$stmt->bind_param("iiid", $ranking->team->team_id, $event_id, $ranking->money, $ranking->points);
			$stmt->execute();
			$stmt->close();
		}	
	}
	
	function insert_games($games, $event_id) {		
		foreach($games as $game) {
			if (game_is_not_duplicate($game)) {
				insert_game($game, $event_id);
				insert_game_stats($game);
				insert_linescore($game);
				insert_game_team($game);
			}
		}
	}
	

	
	function insert_game($game, $event_id) {
		echo "\n\n\n********Inserting Game*******";
		$conn = db_connect();
		$game->print_game();
		$game_date =  $game->date->format("Y-m-d H:i:s");
		echo "\nDate: " . $game_date;
		pause(" ");
		
		$stmt = $conn->prepare("SELECT insert_game(?, ?)");
		$stmt->bind_param("is", $event_id, $game_date);
		$stmt->execute();
		$result = $stmt->get_result();
		$game_id = $result->fetch_array(MYSQLI_NUM)[0];
		$game->game_id = $game_id;
		echo "Game ID: " . $game->game_id;
		$stmt->close();
	}
	
	function insert_game_stats($game) {
		$conn = db_connect();
		insert_team_stats($game->team1, $game->game_id);
		insert_team_stats($game->team2, $game->game_id);
	}
	
	function insert_team_stats($team, $game_id) {
		$players = $team->players;
		foreach($players as $player) {
			insert_player_stats($player, $game_id);
		}
	}
	
	function insert_player_stats($player, $game_id) {
		if ($player->stats == null) {
			return;
		}
		$conn = db_connect();
		echo "\n\n\n******Insert Player Stats******** ";
		$player->print_player();
		pause(" ");
		$stmt = $conn->prepare("SELECT insert_player_stats(?, ?, ?, ?)");
		$stmt->bind_param("iidi", $player->player_id, $game_id, $player->stats->percentage, $player->stats->number_of_shots);
		$stmt->execute();
		$stmt->close();
	}
	
	function insert_linescore($game) {
		$ends = $game->linescore->ends;
		$end_number = 1;
		foreach($ends as $end) {
			insert_end($end_number, $game);
			$end_number++;
		}
	}
	
	function insert_end($end_number, $game) {	
		$team1_score = $game->get_end($end_number)->team1_score;
		$team2_score = $game->get_end($end_number)->team2_score;	
		if ($team1_score == "X" || $team1_score == null) {
			return;
		}

		insert_end_game($end_number, $game->game_id, $game->get_end($end_number));	
		
		$hammer_team1 = boolean_to_db($game->get_hammer(1, $end_number));
		$hammer_team2 = boolean_to_db($game->get_hammer(2, $end_number));
		$differential_team1 = $game->linescore->get_differential($end_number, 1);
		$differential_team2 = $game->linescore->get_differential($end_number, 2);

		$end_id = $game->get_end($end_number)->end_id;
		
		echo "\n\n\n********Inserting End********";
		echo "\nEnd Number: " . $end_number;
		echo "\nEnd ID: " . $end_id;
		echo "\nTeam 1 ID: " . $game->team1->team_id;
		echo "\nTeam 2 ID: " . $game->team2->team_id;
		echo "\nTeam 1 Score: " . $team1_score;
		echo "\nTeam 2 Score: " . $team2_score;
		echo "\nTeam 1 Differential: " . $differential_team1;
		echo "\nTeam 2 Differential: " . $differential_team2;
		echo "\nHammer Team 1: " . $hammer_team1;
		echo "\nHammer Team 2: " . $hammer_team2;

		pause(" ");
		
		$conn = db_connect();
		$stmt = $conn->prepare("SELECT insert_end(?, ?, ?, ?, ?)");
		$stmt->bind_param("iiiii", $end_id, $game->team1->team_id, $team1_score, $differential_team1, $hammer_team1);
		$stmt->execute();
		$stmt->close();
		
		
		$conn = db_connect();
		$stmt = $conn->prepare("SELECT insert_end(?, ?, ?, ?, ?)");
		$stmt->bind_param("iiiii", $end_id, $game->team2->team_id, $team2_score, $differential_team2, $hammer_team2);
		$stmt->execute();	
		$stmt->close();
	}
	
	function insert_end_game($end_number, $game_id,  $end) {
		$conn = db_connect();
		echo "\n\n\n******Insert End Game******* ";
		echo "\nEnd Number: " . $end_number;
		echo "\nGame ID: " . $game_id;
		pause(" ");
		$stmt = $conn->prepare("SELECT insert_end_game(?, ?)");
		$stmt->bind_param("ii", $end_number, $game_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$end_id = $result->fetch_array(MYSQLI_NUM)[0];
		$end->end_id = $end_id;
		echo "End ID: " . $end->end_id;
		$stmt->close();
	}
	
	function insert_game_team($game) {		
		$winner_team1 = boolean_to_db($game->is_winner(1));
		$winner_team2 = boolean_to_db($game->is_winner(2));
		
		echo "\n\n\n******Inserting game team******";
		echo "\nTeam 1 Winner: " . $winner_team1;
		echo "\nGame ID: " . $game->game_id;
		echo "\nTeam 1 ID: " . $game->team1->team_id;		
		echo "\nTeam 2 Winner: " . $winner_team2;
		echo "\nGame ID: " . $game->game_id;
		echo "\nTeam 2 ID: " . $game->team2->team_id;
		pause(" ");
	
		$conn = db_connect();
		$stmt = $conn->prepare("SELECT insert_game_team(?, ?, ?)");
		$stmt->bind_param("iii", $game->game_id, $game->team1->team_id, $winner_team1);
		$stmt->execute();	
		$stmt->close();	

		$conn = db_connect();
		$stmt = $conn->prepare("SELECT insert_game_team(?, ?, ?)");
		$stmt->bind_param("iii", $game->game_id, $game->team2->team_id, $winner_team2);
		$stmt->execute();	
		$stmt->close();			
	}
?>