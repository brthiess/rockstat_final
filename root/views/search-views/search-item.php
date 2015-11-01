<?php
	function output_search_item($type, $name, $image, $description) {
	?>
		<div class="search-item">
			<div class="search-type-img">
				<?php echo "<img src='/images/search-icons/$image.png'/>";?>
			</div>
			<div class="search-type">
				<?php echo $type?>
			</div>
			<div class="search-name"><?php echo $name?></div>
			<div class="search-description"><?php echo $description?></div>
		</div>
	<?php
	}
	
	//Returns the description of the given search item
	function get_description($id=null, $type=null) {
		$description = "";
		if ($type == "Team") {
			if ($id != null){
				$players = \search\get_players_by_team_id($id);
				foreach($players as $player) {
					$description .= "<p>" . $player['first_name'] . " " . $player['last_name'];
					if ($player !== end($players)){
						$description .= '<p class="divider">|</p>';
					}
				}
			}
		}
		return $description;
	}
	
	?>
	