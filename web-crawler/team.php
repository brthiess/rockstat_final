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
				echo "\xA";
				echo $player->position;
				echo ': ';
				echo $player->first_name;
				echo ' ';
				echo $player->last_name;				
			}
		}

	}
?>