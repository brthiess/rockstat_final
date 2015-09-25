<?php 
	
	class Event_Team_Points {
		
		public $team;
		public $money;
		public $points;
		public $rank;
		
		public function __construct($team, $money, $points, $rank) {
			$this->team = $team;
			$this->money = $money;
			$this->points = $points;
			$this->rank = $rank;
		}
	}

?>