<?php
namespace search;
include_once "search/search.php";


	function get_search_results($search_term) {
		$teams = get_matching_teams($search_term);
		return $teams;
	}
	
	function get_matching_teams($search_term) {
		return search_teams($search_term);
	}
?>