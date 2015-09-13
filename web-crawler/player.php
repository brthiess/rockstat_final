<?php

	class Player {
		public $first_name;
		public $last_name;
		public $position;
		
		public function __construct($first_name, $last_name, $position) {
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->position = $position;
		}
	}
?>