<?php
	include_once 'curling.php';
	class Team {
		public $players;
		public $gender;
		public $name;
		public $team_id; //Used for DB
		
		
		public function __construct($name = "default") {
			$this->players = array();
			$this->name = $name;
		}
		
		public function add_player($player) {
			array_push($this->players, $player);
			if ($this->number_of_players() > 4) {
				echo "ERROR: More than 4 players";
			}
			$this->manage_positions(); //Check to see if multiple players are at the same position
		}
		
		//Checks to see if multiple players are playing the same position
		private function manage_positions() {
			for($i = 1; $i <= 4; $i++) {
				if ($this->collision_at_position($i) == true) {
					echo "\n\n**ERROR: Team with multiple players at same position**\n";
					$players = $this->get_players_at_position($i);
					$this->switch_positions($players);
					$this->print_team();
					//pause("");
				}
			}
		}
		
		//Is given an array of players with conflicting positions and switches them around
		private function switch_positions($players) {
			foreach($players as $player) {
				if ($player->unsure_of_position == true) {
					$player->position = $this->get_best_position();
				}
			}
		}
		
		//Returns true if there is more than one person at a given position on the same team
		private function collision_at_position($position) {
			$count = 0;
			foreach($this->players as $player) {
				if ($player->position == $position) $count++;
			}
			if ($count >= 2) {
				return true;
			}
			else {
				return false;
			}
		}
		
		//Gets the best position for the player
		private function get_best_position() {			
			for($i = 1; $i <= 4; $i++){
				if (!$this->position_is_occupied($i)) {
					return $i;
				}
			}
			echo "\n\n****ERROR: No suitable position found. in get_best_position in team.php****\n";
			//pause("");
			return 1;
		}
		
		//Returns true if a player on this team is playing the given position
		private function position_is_occupied($position) {
			foreach($this->players as $player) {
				if ($player->position == $position) return true;
			}
			return false;
		}
		
		public function get_player($position){
			foreach($this->players as $player) {
				if ($player->position == $position) return $player;
			}
			return new Player("First Name", "Last Name", 4);
		}
		
		public function get_players_at_position($position) {
			$players = array();
			foreach($this->players as $player) {
				if ($player->position == $position) array_push($players, $player);
			}
			return $players;
		}
		
		public function number_of_players() {
			return count($this->players);
		}
		
		//Returns the name of the position specified
		public function get_position($position) {
			foreach($this->players as $player) {
				if ($player->position == $position) return $player->first_name . " " . $player->last_name;
			}
		}
		
		public function print_team() {
			echo "\n";
			foreach($this->players as $player) {
				echo $player->position;
				echo ': ';
				echo $player->first_name;
				echo ' ';
				echo $player->last_name;
				echo "\t";
				if (strlen($player->last_name . $player->first_name) < 12) echo "\t";		//Add extra tab if player has short name
				echo $player->print_stats();
				echo "\xA";				
			}
		}
		
		public function print_team_with_ids() {
			foreach($this->players as $player) {
				echo $player->position;
				echo ': ';
				echo $player->first_name;
				echo ' ';
				echo $player->last_name;
				echo "\t";
				if (strlen($player->last_name . $player->first_name) < 12) echo "\t";		//Add extra tab if player has short name
				echo "ID: " . $player->player_id . "\t";
				echo $player->print_stats();
				echo "\xA";				
			}
		}
		
		public function print_position($position) {
			if ($position == "Skip") {
				foreach($this->players as $player) {
					if ($player->position == "Skip"  || $player->position == 4) {
						echo $player->first_name . " " . $player->last_name;
					}
				}
			}
		}

	}
?>