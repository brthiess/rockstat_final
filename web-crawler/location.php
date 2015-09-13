<?php 

	class Location {
		public $province;
		public $city;
		
		public function __construct($city, $province){
			$this->province = $province;
			$this->city = $city;
		}
	}
?>