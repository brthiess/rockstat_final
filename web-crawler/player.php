<?php

	class Player {
		public $first_name;
		public $last_name;
		public $position;
		public $stats;
		public $gender;
		public $player_id; //Used for DB
		public $unsure_of_position;
		public $calls_game;
		
		public function __construct($first_name, $last_name, $position, $stats = null, $gender = null) {
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->unsure_of_position = false;
			$this->calls_game = false;
			$this->position = $this->parse_position($position);
			$this->stats = $stats;
			$this->gender = $gender;
		}
		
		
		//Print the stats if they exist
		public function print_stats() {
			if ($this->stats != null) {
				echo $this->stats->percentage . "%";
			}
		}
		
		private function parse_position($position) {
			if (stripos($position, "Fourth") !== false || $position == 4) {
				return 4;
			}
			else if (stripos($position, "Third") !== false || stripos($position, "Vice") !== false || $position == 3) {
				return 3;
			}
			else if (stripos($position, "Second") !== false || $position == 2) {
				return 2;
			}
			else if (stripos($position, "Lead") !== false || $position == 1) {
				return 1;
			}
			else if (stripos($position, "Skip") !== false) {
				$this->unsure_of_position = true;
				$this->calls_game = true;
				return 4;
			}
			else {
				echo "\n********Error: No valid position entered************\n";
				return 4;
			}
		}
		
		public function print_player() {
			echo "\nName: " . $this->first_name . " " . $this->last_name . "\t";
			$this->print_stats();
		}
	}
?>