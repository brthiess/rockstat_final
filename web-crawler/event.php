<?php
	include_once 'curling.php';
	class Event {
		public $location;
		public $start_date;
		public $end_date;
		public $purse;
		public $currency;
		public $name;
		public $gender;
		public $games;
		public $teams;
		public $category;		//WCT or Slam or CCA etc.
		public $ranking_list;
		
		public function __construct($location, $start_date, $end_date, $purse, $currency, $name, $gender, $teams, $category, $ranking_list){
			$this->location = $location;
			$this->start_date = $start_date;
			$this->end_date = $end_date;
			$this->purse = $purse;
			$this->currency = $currency;
			$this->name = $name;
			$this->gender = $gender;
			$this->games = array();
			$this->teams = $teams;
			$this->category = trim($category);
			$this->ranking_list = $ranking_list;
		}
		
		public function print_event() {
			echo "\n\n***Event***";
			echo "\nName: " . $this->name . "\n";
			echo "Location: " . $this->location->city . $this->location->province . "\n";
			echo "Type: " . $this->category . "\n";
			echo "Start Date: " . date('M-d-Y', $this->start_date) . "\n";
			echo "End Date: " . date('M-d-Y', $this->end_date) . "\n";
			echo "Purse: " . $this->purse . " " . $this->currency . "\n";			
			echo "Gender: " . $this->gender . "\n";
			echo print_winnings($this->ranking_list);
			echo "\xA";
			echo "Teams: ";
			foreach($this->teams as $team) {
				$team->print_team();
				echo "\xA";
			}
		}
		
		public function add_game($game) {
			array_push($this->games, $game);
		}
		
		public function add_teams($teams) {
			$this->teams = $teams;
		}
	}

?>