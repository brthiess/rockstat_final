<?php

	include_once "/db/search_functions.php";
	include_once "search-item.php";
	
	$search_results = get_search_results($_GET['search']);
	echo '<div id="search-results-number">' . count($search_results) . ' Results Found</div>';
	foreach($search_results as $search_item) {
		output_search_item($search_item['type'], $search_item['description']);
	}

?>