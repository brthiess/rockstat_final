<?php
	
	include_once 'insert_db.php';
	include_once 'sync.php';
	
	//Takes an event object and inputs the data into the DB
	function input_html($event) {
		//For each team in the event
			//Insert Player.  Get player id
			//Insert Team. 	Get team id
			//Insert Player_Team.  
		insert_teams($event->teams);
		
		sync_team_ids($event);

			
		//Insert Basic Event Information.  Get event id
		$event->event_id = insert_event($event);
		
		//Insert Event Rankings for each team. 
		insert_rankings($event->ranking_list, $event->event_id);
		//For each game
		echo "\n\nCount of Games: " . count($event->games);
		insert_games($event->games, $event->event_id);
			//Insert  game with the dates and event_id.  Get game id
			//For each player
			
				//Insert into player_game: player_id, game_id, percentage, num_shots
			//For each end
				//Insert relevant info
			//Insert winners into game_team table
		
		//Done!		
	}
	

	
	
	

	
	


?>