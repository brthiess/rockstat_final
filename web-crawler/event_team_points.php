<?php 
	
	class Event_Team_Points {
		
		public $team;
		public $money;
		public $points;
		
		public function __construct($team, $money, $points) {
			$this->team = $team;
			$this->money = $money;
			$this->points = $points;
		}
		
		public function print_individual_team_winnings() {
			echo "\nMoney: " . $this->money;
			echo "\nPoints: " . $this->points;
		}
		

	}
	

	
	//Is given an array of Event_Team_Points objects and prints them out in a nice fashion
	function print_winnings($event_winnings_objects) {
		echo "Name\t\t\tMoney\tPoints\xA";
		foreach($event_winnings_objects as $row) {
			echo $row->team->print_position("Skip") . "\t";
			if (strlen($row->team->get_position(4)) < 14) echo "\t";
			echo $row->money . "\t";
			echo $row->points . "\t";
			echo "\xA";
		}
	}

?>