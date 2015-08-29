<?php
	include_once 'curling.php';
	class End {
		public $team1_score;
		public $team2_score;
		
		public function __construct($team1_score, $team2_score) {
			$this->team1_score = $team1_score;
			$this->team2_score = $team2_score;
		}
	}
?>