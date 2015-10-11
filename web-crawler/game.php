<?php
include_once 'curling.php';

	class Game 
	{
		public $team1;
		public $team2;
		public $linescore;
		public $hammer;
		public $date;
		public $game_id; //Used for DB
		
		public function __construct($team1, $team2, $linescore, $hammer, $date) {
			$this->team1 = $team1;
			$this->team2 = $team2;
			$this->linescore = $linescore;
			$this->hammer = $hammer;	//whether team1 or team2 started with hammer;
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
		
		//returns true if the team number (1 or 2 only) has hammer in the given end_number
		public function get_hammer($team_number, $end_number) {
			$hammer = $this->hammer;
			for($i = 1; $i < $end_number; $i++) {				
				if ($this->linescore->get_end_score($i, 1) - $this->linescore->get_end_score($i, 2) > 0){  //If this is true it means team 1 scored;
					$hammer = 2;
				}
				else if ($this->linescore->get_end_score($i, 1) - $this->linescore->get_end_score($i, 2) < 0) {
					$hammer = 1;
				}
			}
			if ($team_number == $hammer) {
				return true;
			}
			else {
				return false;
			}
		}
		
		public function get_end($end_number) {
			return $this->linescore->get_end($end_number);
		}
	}
?>