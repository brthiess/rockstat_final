<?php
	function sync_team_ids($event) {
		echo "\n\n****Syncing IDs****\n";
		$rankings = $event->ranking_list;
		foreach($rankings as $ranking) {
			//pause(" ");
			update_id($ranking->team, $event->teams);
		}
		$games = $event->games;
		foreach($games as $game) {
			update_id($game->team1, $event->teams);
			update_id($game->team2, $event->teams);
		}
		
	}
	
	function update_id($team, $event_teams){
		$found_team = false;
		foreach($event_teams as $event_team) {
			echo "\n\n******Comparing Teams*******\n";
			$event_team->print_team();
			$team->print_team();
			echo "\nTeam ID: " . $event_team->team_id;		
			if (teams_match($team, $event_team)) {		
				echo "\nTeams Match";
				$team->team_id = $event_team->team_id;
				$found_team = true;
				break;
			}
			else {
				echo "\nTeams Don't Match";
			}
			//pause(" ");	
		}
		if (!$found_team) {
			echo "\n\n***ERROR: No Match for team***";
			pause("");
		}
	}
	
	function teams_match($team, $event_team) {
		echo "\nChecking if Teams Match...";
		//pause(" ");
		$players_matching = 0;
		$skip_matches = false;
		for ($i = 1; $i <= 4; $i++) {	
			//pause("\nChecking if " . $team->get_player($i)->first_name . " " . $team->get_player($i)->last_name . " is on the team"); 		
			if (player_is_on_team($team->get_player($i), $event_team)) {
				//pause("\nPlayer is on team");
				$players_matching++;
			}
			if ($i == 4 && player_is_on_team($team->get_player($i), $event_team)) {
				//pause("\nSkip is on team");
				$skip_matches = true;
			}
		}
		if ($players_matching == 4){
			//pause("\n4 Players Match");
			return true;
		}
		if ($skip_matches) {
			echo "\n\n***Warning: Only Skip Matches***\n\n";
			return false;
		}
		return false;
	}
	
	function player_is_on_team($player, $team) {
		for($i = 1; $i <= 4; $i++) {
			if (player_matches($player, $team->get_player($i))) {
				return true;
			}
		}
		return false;
	}
	
	function player_matches($player1, $player2) {
		echo "\nPlayer 1: " . $player1->first_name . " " . $player1->last_name;
		echo "\nPlayer 2: " . $player2->first_name . " " . $player2->last_name;
		if (stripos($player1->first_name, $player2->first_name) !== false || stripos($player2->first_name, $player1->first_name) !== false) {
			if (stripos($player1->last_name, $player2->last_name) !== false || stripos($player2->last_name, $player1->last_name) !== false) {
				$player1->player_id = $player2->player_id;
				echo "\nPlayers Match";
				//pause(" ");
				return true;
			}
		}
		echo "\nPlayers Don't Match";
		//pause(" ");
		return false;			
	}


?>