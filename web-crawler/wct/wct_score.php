<?php

//Is given the html dom .linescorebox for a game and the event category (slam or regular wct).  Returns an array of two teams
function get_teams_wct($linescorebox, $event_category, $gender){ 
	if (stripos($event_category, "WCT") !== false) return get_teams_wct_normal($linescorebox, $gender);
	else if (stripos($event_category, "Slam") !== false) return get_teams_wct_slam($linescorebox, $gender);
	else echo "****No valid event category given*****";
}

function get_teams_wct_normal($linescorebox, $gender) {
	$players_html = $linescorebox->next_sibling();
			while($players_html->tag != 'table') {
				$players_html = $players_html->next_sibling();
				//echo "\nTag: " . $players_html->tag;
			}
			$players_html = $players_html->find("tr td table td table");
			$player_count = 0;
			$team1 = new Team();
			$team2 = new Team();
			foreach($players_html as $player){		
				//Get each player
				$position = trim(str_replace(":", "", $player->find("tr")[0]->plaintext));
				$image = $player->find("tr")[1]->plaintext;
				$name = $player->find("tr")[2]->innertext;
				
				//Parse the name of the player
				$bold_position = strpos($name, "<b>");	
				$br_position = strpos($name, "<br>");
				$bold_end_position = strpos($name, "</b>");
				
				$first_name = substr($name, $bold_position + 3, $br_position - $bold_position - 3);
				$last_name = substr($name, $br_position + 4, $bold_end_position - $br_position - 4);
				
				if ($player_count < 4) {
					$team1->add_player(new Player($first_name, $last_name, $position, null, $gender));
				}
				else if ($player_count < 8) {
					$team2->add_player(new Player($first_name, $last_name, $position, null, $gender));
				}
				else {
					echo "ERROR: More than 8 players";
				}
				$player_count++;
			}
			$team1->gender = $gender;
			$team2->gender = $gender;
			return array($team1, $team2);
}

function get_teams_wct_slam($linescorebox, $gender) {
	$players_html = $linescorebox->next_sibling();
			while($players_html->tag != 'table') {
				$players_html = $players_html->next_sibling();
			}
	$stats_html = $players_html->find(".stats_row");
	$players_html = $players_html->find(".stats_fourthrow");
	$player_count = 0;
	
	$team1 = new Team();
	$team2 = new Team();
	//Go through each player and get their name, position and stats.
	for($i = 0; $i < count($stats_html) / 6; $i++) {
		$position = preg_replace("/[^0-9]/","",$stats_html[$i * 6]);

		$first_name = str_replace("&nbsp;", "", trim(substr($players_html[$i]->plaintext, 0, stripos($players_html[$i]->innertext, " "))));
		$last_name = trim(substr($players_html[$i]->plaintext, stripos($players_html[$i]->innertext, " ")));

		$percentage = preg_replace("/[^0-9]/","",$stats_html[$i * 6 + 5]);
		$number_of_shots = preg_replace("/[^0-9]/","",$stats_html[$i * 6 + 1]);
		
		if ($player_count < 4) {
			$team1->add_player(new Player($first_name, $last_name, $position, new Stats($percentage, $number_of_shots), $gender));
		}
		else if ($player_count < 8) {
			$team2->add_player(new Player($first_name, $last_name, $position, new Stats($percentage, $number_of_shots), $gender));
		}
		else {
			echo "ERROR: More than 8 players";
		}
		$player_count++;

	}
	$team1->gender = $gender;
	$team2->gender = $gender;
	return array($team1, $team2);
		
}
?>