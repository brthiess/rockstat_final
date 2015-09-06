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
		
		public function __construct($location, $start_date, $end_date, $purse, $currency, $name, $gender){
			$this->location = $location;
			$this->start_date = $start_date;
			$this->end_date = $end_date;
			$this->purse = $purse;
			$this->currency = $currency;
			$this->name = $name;
			$this->gender = $gender;
		}
		
		public function print_event() {
			echo "Location: " . $this->location . "\n";
			echo "Start Date: " . date('M-d-Y', $this->start_date) . "\n";
			echo "End Date: " . date('M-d-Y', $this->end_date) . "\n";
			echo "Purse: " . $this->purse . " " . $this->currency . "\n";
			echo "Name: " . $this->name . "\n";
			echo "Gender: " . $this->gender . "\n";
		}
	}

?>