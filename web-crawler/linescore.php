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
	}
?>