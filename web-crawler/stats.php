<?php

	class Stats {
		
		public $percentage;
		public $number_of_shots;
		
		function __construct($percentage, $number_of_shots) {
			$this->percentage = $percentage;
			$this->number_of_shots = $number_of_shots;
		}
		
	}
?>