<?php

	include_once "/includes/get_player.php";
	
	
	$stats = get_player_stats($_GET["player"]);
	echo "<script>var stats = " . json_encode($stats) . ";</script>";

?>
	
	<!--Data for Charts-->
	<script>
	var chartsData = new Array();
	chartsData["win_data"] = [
		{
			value: <?php echo $stats["all"]["win_percentage"]?>,
			color: "#46BFBD",
			highlight: "#5AD3D1",

			label: "Win Percentage"
		},
		{
			value: <?php echo $stats["all"]["loss_percentage"]?>,
			color:"#F7464A",
			highlight: "#FF5A5E",
			label: "Losing Percentage"
		}
	];
	</script>
	
	<section class="player-name">
	<h1>
		<?php 	$name = get_player_name($_GET["player"]);
				echo $name["first_name"] . "<span>&shy;" . $name["last_name"] . "</span>";
		?>
	</h1>
	</section>

	<?php include "sections/player/games-view.php";?>
	
	<?php include "sections/player/money-view.php";?>
