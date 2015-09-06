<?php

function get_date_wct($event_date_html, $time) {
	return mktime(0,0,0,get_month_wct($event_date_html, $time), get_day_wct($event_date_html, $time), get_year_wct($event_date_html));
}

//Parse out the month from a date string.  
//$date is the datestring
//$time is whether you want start or end time
function get_month_wct($date, $time) {
	$MONTHS = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"); 
	//Go through each month and check if it exists in the date string
	$month = -1;
	for($i = 0; $i < count($MONTHS); $i++) {
		//Check each month
		if (stripos($date, $MONTHS[$i]) !== false) {
			if ($time == "start") {
				//If the previous month exists in the string
				if (stripos($date, $MONTHS[mod($i - 1, 12)]) !== false) {
					//This is the correct month
					$month = mod($i - 1, 12);
				}
				else {
					$month = $i;
				}
			}
			else {
				//If the next month exists in the string
				if (stripos($date, $MONTHS[mod($i + 1, 12)]) !== false) {
					$month = mod($i + 1, 12);
				}
				else {
					$month = $i;	
				}
			}
		}
	}
	if ($month == -1) {
		echo "\nMonth was -1";
	}
	return $month + 1;
}

function get_day_wct($date, $time){
	$date = substr($date, 0, stripos($date, ","));
	$dash_position = stripos($date, '-');
	$day = -1;
	$date_string = "";
	if ($time == 'start'){
		$date_string = substr($date, 0, $dash_position);
	}
	else {		
		$date_string = substr($date, $dash_position);
	}
	$day = intval(preg_replace("/[^0-9]/","",$date_string));
	if ($day == -1) {
		echo "\nDay was -1";
	}
	return $day;
}

function get_year_wct($date){
	$comma_position = stripos($date, ',');
	$year = -1;
	$year_string = substr($date, $comma_position);
	$year = intval(preg_replace("/[^0-9]/","",$year_string));
	
	if ($year == -1){
		echo "Year equals -1";
	}
	return $year;
}

function get_purse_wct($purse_string) {
	$purse = -1;
	$purse = intval(preg_replace("/[^0-9]/","",$purse_string));
	if ($purse == -1) {
		echo "Purse is $-1";
	}	
	return $purse;
}

function get_gender_wct($html) {
	$male = 0;
	$female = 0;
	if (stripos($html, "tom") !== false) $male += 1;
	if (stripos($html, "brad") !== false) $male += 1;
	if (stripos($html, "kevin") !== false) $male += 1;
	if (stripos($html, "joe") !== false) $male += 1;
	if (stripos($html, "john") !== false) $male += 1;
	if (stripos($html, "thom") !== false) $male += 1;
	if (stripos($html, "matt") !== false) $male += 1;
	if (stripos($html, "brock") !== false) $male += 1;
	if (stripos($html, "charley") !== false) $male += 1;
	if (stripos($html, "randy") !== false) $male += 1;
	if (stripos($html, "dave") !== false) $male += 1;
	if (stripos($html, "ritvars") !== false) $male += 1;
	if (stripos($html, "Petr") !== false) $male += 1;
	if (stripos($html, "sven") !== false) $male += 1;
	if (stripos($html, "simon") !== false) $male += 1;
	if (stripos($html, "mikel") !== false) $male += 1;
	if (stripos($html, "victor") !== false) $male += 1;
	if (stripos($html, "mark") !== false) $male += 1;
	if (stripos($html, "brett") !== false) $male += 1;
	if (stripos($html, "reid") !== false) $male += 1;
	if (stripos($html, "colin") !== false) $male += 1;
	if (stripos($html, "braeden") !== false) $male += 1;
	if (stripos($html, "derek") !== false) $male += 1;
	if (stripos($html, "tim") !== false) $male += 1;
	if (stripos($html, "brent") !== false) $male += 1;
	if (stripos($html, "ben") !== false) $male += 1;
	if (stripos($html, "patrick") !== false) $male += 1;
	if (stripos($html, "niklas") !== false) $male += 1;
	if (stripos($html, "nic") !== false) $male += 1;
	if (stripos($html, "mike") !== false) $male += 1;
	if (stripos($html, "nic") !== false) $male += 1;
	if (stripos($html, "denni") !== false) $male += 1;
	if (stripos($html, "benoit") !== false) $male += 1;
	if (stripos($html, "peter") !== false) $male += 1;
	if (stripos($html, "scott") !== false) $male += 1;
	if (stripos($html, "david") !== false) $male += 1;
	if (stripos($html, "michael") !== false) $male += 1;
	if (stripos($html, "steve") !== false) $male += 1;
	if (stripos($html, "kirk") !== false) $male += 1;
	if (stripos($html, "glenn") !== false) $male += 1;
	if (stripos($html, "wayne") !== false) $male += 1;
	if (stripos($html, "richard") !== false) $male += 1;
	if (stripos($html, "ryan") !== false) $male += 1;
	if (stripos($html, "adam") !== false) $male += 1;
	if (stripos($html, "rob") !== false) $male += 1;
	if (stripos($html, "todd") !== false) $male += 1;
	if (stripos($html, "brandon") !== false) $male += 1;
	if (stripos($html, "alex") !== false) $male += 1;
	if (stripos($html, "dave") !== false) $male += 1;
	if (stripos($html, "chris") !== false) $male += 1;
	if (stripos($html, "guy") !== false) $male += 1;
	if (stripos($html, "simon") !== false) $male += 1;
	if (stripos($html, "martin") !== false) $male += 1;
	if (stripos($html, "doug") !== false) $male += 1;
	if (stripos($html, "jason") !== false) $male += 1;
	if (stripos($html, "terry") !== false) $male += 1;
	if (stripos($html, "rui") !== false) $male += 1;
	if (stripos($html, "codey") !== false) $male += 1;
	if (stripos($html, "wesley") !== false) $male += 1;
	if (stripos($html, "jake") !== false) $male += 1;
	if (stripos($html, "josh") !== false) $male += 1;
	if (stripos($html, "don") !== false) $male += 1;
	if (stripos($html, "brian") !== false) $male += 1;
	if (stripos($html, "eric") !== false) $male += 1;
	if (stripos($html, "phil") !== false) $male += 1;
	if (stripos($html, "max") !== false) $male += 1;
	if (stripos($html, "will") !== false) $male += 1;
	
	if (stripos($html, "trish") !== false) $female += 1;
	if (stripos($html, "anna") !== false) $female += 1;
	if (stripos($html, "sara") !== false) $female += 1;
	if (stripos($html, "jen") !== false) $female += 1;
	if (stripos($html, "taylor") !== false) $female += 1;
	if (stripos($html, "chelsea") !== false) $female += 1;
	if (stripos($html, "kelsey") !== false) $female += 1;
	if (stripos($html, "laura") !== false) $female += 1;
	if (stripos($html, "amy") !== false) $female += 1;
	if (stripos($html, "courtney") !== false) $female += 1;
	if (stripos($html, "alison") !== false) $female += 1;
	if (stripos($html, "allison") !== false) $female += 1;
	if (stripos($html, "kreviazuk") !== false) $female += 1;
	if (stripos($html, "monica") !== false) $female += 1;
	if (stripos($html, "vicky") !== false) $female += 1;
	if (stripos($html, "val") !== false) $female += 1;
	if (stripos($html, "kait") !== false) $female += 1;
	if (stripos($html, "rachel") !== false) $female += 1;
	if (stripos($html, "dana") !== false) $female += 1;
	if (stripos($html, "emma") !== false) $female += 1;
	if (stripos($html, "jamie") !== false) $female += 1;
	if (stripos($html, "tracy") !== false) $female += 1;
	if (stripos($html, "amanda") !== false) $female += 1;
	if (stripos($html, "jenna") !== false) $female += 1;
	$female +=  substr_count($html, 'la<');
	$female +=  substr_count($html, 'ca<');
	$female +=  substr_count($html, 'ra<');
	$female +=  substr_count($html, 'na<');
	$female +=  substr_count($html, 'y<');


	echo "female" . $female;
	echo "\n" . $male;
	if ($male > $female) {
		return MEN;
	}
	else {
		return WOMEN;
	}
}

function get_currency_wct($html) {
	return substr($html, -3);
}

?>