<?php

	include_once "/db/db_stats.php";
	
	$stats = get_player_stats($_GET["player"]);
	?>
	<div class="section">
		<div class="section-title">Games</div>		
		<span class="ghost-button">With Hammer</span><span class="ghost-button right">Without Hammer</span>
		<div class="section-subtitle"># of Games</div>
		<div class="section-fact subsection">
			<span class="number"><?php echo $stats["games"]?></span>
		</div>
		<div class="section-subtitle">Rank</div>
		<div class="section-rank subsection">
			<div class="section-rank-item">
				<span class="section-rank">4<sup>th</sup></span><span class="right"># of Games</span>
			</div>
			<div class="section-rank-item">
				<span class="section-rank">1<sup>st</sup></span><span class="right">Win %</span>
			</div>
		</div>
		
	</div>
