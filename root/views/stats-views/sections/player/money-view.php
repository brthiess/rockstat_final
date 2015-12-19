<?php 
	//Gets the year and converts it to the proper string for the select
	function year_to_select($year){
		if ($year == 'all_years') {
			return 'All Years';
		}
		else {
			return intval($year) . '/' . (intval($year) + 1);
		}
	}
	function stat_type_is_year($stat_type){
		if ((preg_match('/^\d{4}$/', $stat_type) && is_numeric($stat_type)) || $stat_type == 'all_years') { //Check to make sure stat type is 4 digits long and a number
			return true;
		}
		else {
			return false;
		}
	}
?>
<div class="section" data-group="money">
	<div class="section-title">Money</div>
	<select>
		<?php 
			foreach($stats as $key => $money_year) {
				if (stat_type_is_year($key)) {
					echo "<option data-stat-type='" . $key . "'>" . year_to_select($key) . "</option>";
				}
			}
		?>
	</select>
	<div class="section-subtitle">Money Earned</div>
	<div class="section-fact subsection">
		<span class="sub-fact col-12">
			<span class="number money"><span class="green">$ </span><p data-type="number" data-stat="money_earned"><?php echo number_format($stats["all_years"]['money_earned'])?></p></span>
		</span>
	</div>
	<div class="section-subtitle">Rank</div>
	<div class="section-rank subsection">
		<div class="section-rank-item">
			<span class="section-rank" data-type="number" data-stat="money_earned_rank"><?php echo $stats['all_years']['money_earned_rank']?></span><sup class="suffix">th</sup><span class="right">Money Earned</span>
		</div>
	</div>
</div>