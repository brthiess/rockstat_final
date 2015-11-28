<?php

	include_once "/includes/get_player_stats.php";
	
	$stats = get_player_stats($_GET["player"]);
	echo "<script>var stats = " . json_encode($stats) . ";</script>";

?>
	
	<!--Data for Charts-->
	<script>
	var chartsData = new Array();
	chartsData["win-data"] = [
		{
			value: <?php echo $stats["all"]["win-percentage"]?>,
			color:"#F7464A",
			highlight: "#FF5A5E",
			label: "Win Percentage"
		},
		{
			value: <?php echo $stats["all"]["losing-percentage"]?>,
			color: "#46BFBD",
			highlight: "#5AD3D1",
			label: "Losing Percentage"
		}
	];
	</script>

	<?php include "sections/games-view.php";?>
