<?php 

	class Location {
		public $province;  //Might also be a country for some places
		public $city;
		
		public function __construct($city, $province){
			$this->province = $province;
			$this->city = $city;
		}
	}
?>