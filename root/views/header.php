<?php 
	function print_header($additional_resources = array()) {	
?>
<head>
<title>RockStat</title>
<meta name="viewport" content="width=device-width">
<link rel="shortcut icon" href="/images/favicon.png">
<link rel="stylesheet" href="/css/styles.css">
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery.auto-complete.min.js" async></script>
<script src="/js/main.js" async></script>

<?php
	foreach($additional_resources as $resource) {
		echo $resource;
	}
}
?>
</head>
