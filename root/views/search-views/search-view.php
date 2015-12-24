<?php

	include_once "/db/db_search.php";
	include_once "search-item.php";
	
	$search_results = \search\get_search_results($_GET['q']);
	echo '<div id="search-results-number">' . count($search_results) . ' Results Found</div>';
	foreach($search_results as $search_item) {
		$search_item['description'] = get_description($search_item['id'], $search_item['type']);
		output_search_item($search_item['id'], $search_item['type'], $search_item['name'], $search_item['image'], $search_item['description']);
	}

?>