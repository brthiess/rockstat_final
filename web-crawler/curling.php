<?php 
	include_once 'game.php';
	include_once 'linescore.php';
	include_once 'team.php';
	include_once 'end.php';
	include_once 'event.php';
	include_once 'player.php';
	include_once 'location.php';
	include_once 'event_team_points.php';
	include_once 'stats.php';
	//Is given the number 1 ... 4 and returns the string for that position (i.e. "Skip" "Third" etc.)
	function number_to_position($number) {
		if ($number == 1) return "Lead";
		if ($number == 2) return "Second";
		if ($number == 3) return "Third";
		if ($number == 4) return "Skip";
		return $number;
	}
?>