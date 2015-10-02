<?php
	include_once 'curling.php';
	class Team {
		public $players;
		public $gender;
		
		public function __construct() {
			$this->players = array();
		}
		
		public function add_player($player) {
			array_push($this->players, $player);
			if ($this->number_of_players() > 4) {
				echo "ERROR: More than 4 players";
			}
		}
		
		public function number_of_players() {
			return count($this->players);
		}
		
		public function print_team() {
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