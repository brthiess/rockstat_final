<?php
	include_once 'db_connect.php';
	include_once 'insert_db.php';
	
	//Takes an event object and inputs the data into the DB
	function input_html($event) {
		//For each team in the event
			//Insert Player.  Get player id
			//Insert Team. 	Get team id
			//Insert Player_Team.  
		insert_teams($event->teams);

			
		//Insert Basic Event Information.  Get event id
		
		//Insert Event Rankings for each team. 
		
		//For each game
			//Insert  game with the dates and event_id.  Get game id
			//For each player
				//Insert into player_game: player_id, game_id, percentage, num_shots
			//For each end
				//Insert relevant info
			//Insert winners into game_team table
		
		//Done!		
	}
	
	
	

	
	


?>