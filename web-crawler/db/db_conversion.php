<?php
//This file is used for converting values to fit in with the DB if need.  Or vice versa

	//Converts a gender string to binary (1 or 0)
	function gender_to_db($gender) {
		if ($gender == MEN) {
			return 0;
		}
		else if ($gender == WOMEN) {
			return 1;
		}
		else {
			echo "****Error: No gender found.  Assuming male.  db_conversion.php****";
			return 0;
		}
	}
	
	function boolean_to_db($boolean) {
		if ($boolean == true) {
			return 1;
		}
		else {
			return 0;
		}
	}


?>