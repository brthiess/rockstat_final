<?php

	class Player {
		public $first_name;
		public $last_name;
		public $position;
		public $stats;
		
		public function __construct($first_name, $last_name, $position, $stats = null) {
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->position = $position;
			$this->stats = $stats;
		}
		
		
		//Print the stats if they exist
		public function print_stats() {
			if ($this->stats != null) {
				echo "%" . $this->stats->percentage;				
			}
		}
	}
?>