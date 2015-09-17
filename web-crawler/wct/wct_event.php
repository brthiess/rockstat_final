<?php

function get_event_date_wct($schedule_html, $event_url, $time) {
	$dom_lower = get_event_dom_block_lower_wct($schedule_html, $event_url);
	$date_string = $dom_lower->find("td")[0]->plaintext;
	return mktime(0,0,0,get_month_wct($date_string, $time), get_day_wct($date_string, $time), get_year_wct($schedule_html->find("html body table tbody tr td table tbody tr td font.wctlight b")[0], $date_string));
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
	$dash_position = stripos($date, '-');
	$day = -1;
	$date_string = "";
	if ($time == 'start'){
		$date_string = substr($date, 0, $dash_position);		
	}
	else {		
		$date_string = substr($date, $dash_position + 1);
	}
	$day = intval(preg_replace("/[^0-9]/","",$date_string));
	if ($day < 0) {
		echo "\nDay was -1";
	}
	return $day;
}

function get_year_wct($year_string, $date_string){
	$dash_position = stripos($year_string, '-');
	$year = -1;
	$year_string = substr($year_string, 0, $dash_position);
	$year = intval(preg_replace("/[^0-9]/","",$year_string));
	
	if ($year < 0){
		echo "Year equals -1";
	}
	if(get_month_wct($date_string, "start") <= 6){		
		return $year + 1;
	}
	else {
		return $year;
	}
}

function get_purse_wct($purse_string) {
	$purse = -1;
	$purse = intval(preg_replace("/[^0-9]/","",$purse_string));
	if ($purse == -1) {
		echo "Purse is $-1";
	}	
	return $purse;
}

function get_gender_wct($schedule_html) {
	if (stripos($schedule_html, 'bgcolor="#F2DDDA"') !== false) {
		return WOMEN;
	}
	else if (stripos($schedule_html, 'bgcolor="#CEDFE9"') !== false) {
		return MEN;
	}
	return -1;
}

function get_event_dom_block_upper_wct($schedule_html, $event_url) {
	return $schedule_html->find("a[href=" . $event_url . "]")[0]->parent()->parent()->parent()->parent();
}

function get_event_dom_block_lower_wct($schedule_html, $event_url) {
	return $schedule_html->find("a[href=" . $event_url . "]")[0]->parent()->parent()->parent()->parent()->next_sibling();
}

function get_event_name_wct($schedule_html, $event_url) {
	return $schedule_html->find("a[href=" . $event_url . "]")[0]->plaintext;
}

function get_event_location_wct($schedule_html, $event_url) {
	$dom_block = get_event_dom_block_upper_wct($schedule_html, $event_url);
	$location_string = $dom_block->find("td[align=right]")[0]->plaintext;
	
	$comma_position = 	stripos($location_string, ',');
	$city = substr($location_string, 0, $comma_position);
	$province = substr($location_string, $comma_position + 1);
	
	if (strlen($city) <= 2) {
		echo "\nCity string length less than 2";
	}
	if (strlen($province) <=2) {
		echo "\nProvince string length less than 2";
	}
	return new Location($city, $province);
}

function get_event_purse_wct($schedule_html, $event_url) {
	$dom_lower = get_event_dom_block_lower_wct($schedule_html, $event_url);
	$purse_string = $dom_lower->find("td")[1]->plaintext;
	
	$purse = -1;
	$purse = intval(preg_replace("/[^0-9]/","",$purse_string));
	if ($purse == -1) {
		echo "Purse is $-1";
	}
	return $purse;
}

function get_event_currency_wct($schedule_html, $event_url) {
	$dom_lower = get_event_dom_block_lower_wct($schedule_html, $event_url);
	$purse_string = $dom_lower->find("td")[1]->plaintext;
	$open_bracket_position = stripos($purse_string, "(");
	$closed_bracket_position = stripos($purse_string, ")");
	return substr($purse_string, $open_bracket_position + 1, $closed_bracket_position - $open_bracket_position - 1);
}

?>