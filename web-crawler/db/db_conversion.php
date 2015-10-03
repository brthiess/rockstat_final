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
			echo "****Error: No gender found.  Assuming male****";
			return 0;
		}
	}


?>