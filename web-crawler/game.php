<?php
include_once 'curling.php';

	class Game 
	{
		public $team1;
		public $team2;
		public $linescore;
		public $hammer;
		public $date;
		
		public function __construct($team1, $team2, $linescore, $hammer, $date) {
			$this->team1 = $team1;
			$this->team2 = $team2;
			$this->linescore = $linescore;
			$this->hammer = $hammer;
			$this->date = $date;
		}
	}
?>