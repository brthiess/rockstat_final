<?php

include_once "../db/search_functions.php";

if (isset($_GET['q'])) {
	$array = \search\get_search_results($_GET['q']);
}

if(isset ($_GET['callback']))
{
    header("Content-Type: application/json");

    echo $_GET['callback']."(".json_encode($array).")";

}
?>