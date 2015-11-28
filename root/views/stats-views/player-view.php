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
			value: <?php echo 100 - $stats["all"]["win-percentage"]?>,
			color: "#46BFBD",
			highlight: "#5AD3D1",
			label: "Losing Percentage"
		}
	];
	</script>

	<!--View for Games-->
	<div class="section" data-group="games">
		<div class="section-title">Games</div>	
		<div class="button-container">
			<span class="ghost-button" data-stat-type="with">With Hammer</span>
		</div>
		<div class="button-container">
			<span class="ghost-button" data-stat-type="without">Without Hammer</span>
		</div>
		<div class="section-subtitle"># of Games</div>
		<div class="section-fact subsection">
			<span class="number" data-type="number" data-stat="games"><p><?php echo $stats["all"]["games"]?></p></span>
			<span class="graph"><canvas data-type="graph" data-source="win-data" id="win-chart"></canvas></span>
		</div>
		<div class="section-subtitle">Rank</div>
		<div class="section-rank subsection">
			<div class="section-rank-item">
				<span class="section-rank" data-type="number" data-stat="games-rank"><?php echo $stats["all"]["games-rank"]?></span><sup class="suffix">th</sup><span class="right"># of Games</span>
			</div>
			<div class="section-rank-item">
				<span class="section-rank" data-type="number" data-stat="win-percentage-rank"><?php echo $stats["all"]["win-percentage-rank"]?></span><sup class="suffix">st</sup><span class="right">Win %</span>
			</div>
		</div>		
	</div>
