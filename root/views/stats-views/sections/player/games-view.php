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
			<span class="sub-fact col-6">
				<span class="number" data-type="number" data-stat="games"><p><?php echo $stats["all"]["games"]?></p></span>
			</span>
			<span class="sub-fact col-6">
				<span class="graph">
					<canvas id="win-chart" data-type="graph" data-graph-type="pie" data-source="win_data"  data-stats="win_percentage loss_percentage"></canvas>
					<div class="legend">
						<span class="wins"><span class="number" data-type="number" data-stat="wins"><?php echo $stats["all"]["wins"]?></span> Wins</span>
						<span class="losses"><span class="number" data-type="number" data-stat="losses"><?php echo $stats["all"]["losses"]?></span> Losses</span>
					</div>
				</span>
			</span>
		</div>
		<div class="section-subtitle">Rank</div>
		<div class="section-rank subsection">
			<div class="section-rank-item">
				<span class="section-rank" data-type="number" data-stat="games_rank"><?php echo $stats["all"]["games_rank"]?></span><sup class="suffix">th</sup><span class="right"># of Games</span>
			</div>
			<div class="section-rank-item">
				<span class="section-rank" data-type="number" data-stat="win_percentage_rank"><?php echo $stats["all"]["win_percentage_rank"]?></span><sup class="suffix">st</sup><span class="right">Win %</span>
			</div>
		</div>		
	</div>