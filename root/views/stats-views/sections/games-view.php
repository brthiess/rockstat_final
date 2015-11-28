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
			<span class="sub-fact">
				<span class="number" data-type="number" data-stat="games"><p><?php echo $stats["all"]["games"]?></p></span>
			</span>
			<span class="sub-fact">
				<span class="graph">
					<canvas data-type="graph" data-graph-type="pie" data-source="win-data" id="win-chart" data-stats="win-percentage losing-percentage"></canvas>
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
				<span class="section-rank" data-type="number" data-stat="games-rank"><?php echo $stats["all"]["games-rank"]?></span><sup class="suffix">th</sup><span class="right"># of Games</span>
			</div>
			<div class="section-rank-item">
				<span class="section-rank" data-type="number" data-stat="win-percentage-rank"><?php echo $stats["all"]["win-percentage-rank"]?></span><sup class="suffix">st</sup><span class="right">Win %</span>
			</div>
		</div>		
	</div>