<?php
	include_once 'curling.php';
	class LineScore 
	{
		public $ends;
		public function __construct() {
			$this->ends = array();
		}
		public function addEnd($team1_score, $team2_score) {
			array_push($this->ends, new End($team1_score, $team2_score));
		}
		//Gets the differential of the current end_number being played.
		public function get_differential($end_number, $team_number) {
			$differential = 0;
			for($i = 0; $i < $end_number - 1 && $i < count($this->ends); $i++) {
				$differential += $this->ends[$i]->team1_score;
				$differential -= $this->ends[$i]->team2_score;
			}
			if ($team_number == 1) {
				return $differential;
			}
			else if ($team_number == 2) {
				return -$differential;
			}
			else {
				echo "\n****ERROR: Invalid Team Number selected in get_differential****";
				return $differential;
			}			
		}
		public function get_end_score($end_number, $team_number) {
			if ($team_number == 1) {
				return $this->ends[$end_number - 1]->team1_score;
			}
			else if ($team_number == 2) {
				return $this->ends[$end_number - 1]->team2_score;
			}
			else {
				echo "\n***Invalid Team Number Passed In, in get_end_score****";
				return $this->ends[$end_number - 1]->team1_score;
			}
		}
		public function print_linescore(){
			if (func_num_args() == 1) {
				$hammer = func_get_arg(0);
			}
			
			echo "\xA  ";
			$end_number = 1;
			foreach($this->ends as $end) {
				echo $end_number . '  ';
				$end_number++;
			}
			
			echo "\xA";
			if ($hammer == 1) {
				echo "h ";
			}
			else {
				echo "  ";
			}
			foreach($this->ends as $end) {
				echo $end->team1_score . '  ';
			}
			
			echo "\xA";
			if ($hammer == 2) {
				echo "h ";
			}
			else {
				echo "  ";
			}
			foreach($this->ends as $end) {
				echo $end->team2_score . '  ';
			}
		}
		public function get_end($end_number) {
			return $this->ends[$end_number - 1];
		}
		public function get_total($team_number) {
			$total = 0;
			foreach($this->ends as $end) {
				if ($team_number == 1) {
					$total += $end->team1_score;
				}
				else if ($team_number == 2) {
					$total += $end->team2_score;
				}
				else {
					echo "\n********ERROR: Invalid team number in get_end()******";
				}
			}
			return $total;
		}
	}
?>