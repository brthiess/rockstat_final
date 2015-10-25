<?php

	//Returns true if it does not find the game in the DB
	function game_is_not_duplicate($game, $event_id) {
		$game_date = $game->date->format("Y-m-d H:i:s");;
		//echo "\n\n***Checking For Duplicates***";
		//echo "\nEvent ID: " . $event_id;
		//echo "\nGame Date: " . $game->date->format("Y-m-d H:i:s");
		//echo "\nTeam 1 ID: " . $game->team1->team_id;
		//echo "\nTeam 2 ID: " . $game->team2->team_id;
		$conn = db_connect();
		$stmt = $conn->prepare("SELECT  game_exists(?,?,?,?)");
		$stmt->bind_param("isii", $event_id, $game_date, $game->team1->team_id, $game->team2->team_id);
		$stmt->execute();		
		$result = $stmt->get_result();
		$exists = $result->fetch_array(MYSQLI_NUM)[0]; // this does work :)
		
		

		if ($exists == 1) {
			echo "\n\n***Duplicate Found***\n\n";
			return false;
		}
		else {
			//echo "\nGame is not in DB";
			return true;
		}

	}

?>