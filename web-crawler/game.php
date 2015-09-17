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
		
		public function print_game() {
			echo "\xA\xATime: ";
			echo date_format($this->date,"Y/m/d H:iP");
			echo "\xA***Team 1***\xA";
			$this->team1->print_team();
			echo "\xA***Team 2***\xA";
			$this->team2->print_team();			
			//Debug
			$this->linescore->print_linescore($this->hammer);
		}
	}
?>