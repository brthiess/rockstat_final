<?php

	include_once "/includes/get_team.php";
	
	$id = $_GET["id"];
	$stats = get_team_stats($id);
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
	
	<section class="name">
	<h1>
		<?php 	$name = get_team_name($id);
				echo "Team" . "<span>&shy;" . $name["team_name"] . "</span>";
		?>
	</h1>
	</section>

	<?php include "sections/generic/games-view.php";?>
	
	<?php include "sections/generic/money-view.php";?>
