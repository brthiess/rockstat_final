<?php
include_once 'curling.php';

	class Game 
	{
		public $team1;
		public $team2;
		public $linescore;
		public $event;
		
		public function __construct($gender) {
			$this->team1 = new Team($gender);
			$this->team2 = new Team($gender);
			$this->linescore = new LineScore();
		}
		
		public function __construct2($gender, $team1, $team2, $linescore, $event) {
			$this->team1 = $team1;
			$this->team2 = $team2;
			$this->gender = $gender;
			$this->linescore = $linescore;
			$this->event = $event;
		}
	}
?>