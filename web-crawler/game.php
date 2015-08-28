<?php
include_once 'linescore.php';
include_once 'team.php';

	class Game 
	{
		public $team1;
		public $team2;
		public $linescore;
		
		public function __construct() {
			$this->team1 = new Team;
			$this->team2 = new Team;
			$this->linescore = new LineScore;
		}
	}
?>