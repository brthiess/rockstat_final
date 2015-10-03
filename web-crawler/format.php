<?php 

	Class Format {
		public $type;
		public $number_of_qualifiers;
		
		public function __construct($type, $number_of_qualifiers) {			
			$this->type = $this->parse_type($type);
			$this->number_of_qualifiers = intval($number_of_qualifiers);
		}
		
		private function parse_type($type){
			if (stripos($type, "Robin") !== false || stripos($type, "Pool") !== false) {
				return "Round Robin";
			}
			if (stripos($type, "Knockout") !== false && stripos($type, "Triple") !== false) {
				return "Triple Knockout";
			}
			else {
				echo "******************Error: Unknown Event Format******************";
				return "Triple Knockout";
			}
		}
		
	}

?>