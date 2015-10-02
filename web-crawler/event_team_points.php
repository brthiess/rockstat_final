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
	
	//Is given an array of Event_Team_Points objects and prints them out in a nice fashion
	function print_winnings($event_winnings_objects) {
		echo "Rank\tName\t\t\tMoney\tPoints\xA";
		foreach($event_winnings_objects as $row) {
			echo $row->rank . "\t";
			echo $row->team->print_position("Skip") . "\t\t";
			echo $row->money . "\t";
			echo $row->points . "\t";
			echo "\xA";
		}
	}

?>