<?php
	include_once 'curling.php';
	class Team {
		public $players;
		public $gender;
		
		public function __construct() {
			$this->players = array();
		}
		
		public function add_player($player) {
			array_push($this->$players, $player);
		}
		
		public function number_of_players() {
			return count($players);
		}


	}
?>