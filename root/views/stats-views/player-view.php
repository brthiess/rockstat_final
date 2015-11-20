<?php

	include_once "/db/db_stats.php";
	
	$stats = get_player_stats($_GET["player"]);
	?>
	<div class="section">
		<div class="section-title">Games</div>		
		<span class="number"><?php echo $stats["games"]?></span>
	</div>
