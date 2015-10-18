<?php

function mod($a, $n) {
    return ($a % $n) + ($a < 0 ? $n : 0);
}

/**
 *
 * @Find position of Nth occurance of search string
 *
 * @param string $search The search string
 *
 * @param string $string The string to seach
 *
 * @param int $offset The Nth occurance of string
 *
 * @return int or false if not found
 *
 */
function strposOffset($search, $string, $offset)
{
    /*** explode the string ***/
    $arr = explode($search, $string);
    /*** check the search is not out of bounds ***/
    switch( $offset )
    {
        case $offset == 0:
        return false;
        break;
    
        case $offset > max(array_keys($arr)):
        return false;
        break;

        default:
        return strlen(implode($search, array_slice($arr, 0, $offset)));
    }
}
function pause($string) {
	echo "\n" . $string . "\n";
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
}

function get_team_from_name($last_name, $first_name, $teams) {
	foreach($teams as $team) {
		if (last_name_is_skip($last_name, $team)) {
			return $team;
		}
		if (whole_name_is_on_team($last_name, $first_name, $team)) {
			return $team;
		}
	}
}

//Returns true if the last name is the skip of the team
function last_name_is_skip($last_name, $team) {
	$skip = $team->get_player(4);
	$vice = $team->get_player(3);
	if (trim($skip->last_name) == trim($last_name) || trim($vice->last_name) == trim($last_name)) {
		return true;
	}
	else {
		return false;
	}
}

function whole_name_is_on_team($last_name, $first_name, $team) {
	for($i = 1; $i <= 4; $i++) {
		$player = $team->get_player($i);
		if (trim($player->last_name) == trim($last_name) && trim($player->first_name) == trim($first_name)) {
			return true;
		}
	}
	return false;
}

?>