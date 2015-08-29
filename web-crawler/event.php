<?php
	include_once 'curling.php';
	class Event {
		public $location;
		public $start_date;
		public $end_date;
		public $purse;
		public $name;
		
		public function __construct($location, $start_date, $end_date, $purse, $name){
			$this->location = $location;
			$this->start_date = $start_date;
			$this->end_date = $end_date;
			$this->purse = $purse;
			$this->name = $name;
		}
	}

?>