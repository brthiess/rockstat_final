<?php

include_once "../db/db_search.php";



if (isset($_GET['search'])) {
	$array = \search\get_search_results($_GET['search']);
}

if(isset ($_GET['callback']))
{
    header("Content-Type: application/json");
    echo $_GET['callback']."(".json_encode($array).")";
}
?>