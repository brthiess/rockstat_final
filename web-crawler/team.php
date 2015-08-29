<?php
	include_once 'curling.php';
	class Team {
		public $players;
		public $gender;
		
		public function __construct($gender) {
			$this->players = array();
			$this->gender = $gender;
		}


	}
?>