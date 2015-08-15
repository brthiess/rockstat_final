<?php

if (isset($_GET["search"])) {
	include_once "search.php";
}
else if (isset($_GET["player"])){
	include_once "player.php";
}
else if (isset($_GET["team"])){
	include_once "team.php";
}
else if (isset($_GET["game"])){
	include_once "game.php";
}
else {
	include_once "main.php";
}
?>