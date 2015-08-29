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
			print_r($this->ends);
		}
	}
?>