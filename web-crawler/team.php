<?php
	include_once 'curling.php';
	class Team {
		public $players;
		public $gender;
		public $name;
		public $location;
		public $team_id; //Used for DB
		
		
		public function __construct($name = "default", $location = "Canada") {
			$this->players = array();
			$this->name = $name;
			$this->parse_location($location);
		}
		
		public function add_player($player) {
			array_push($this->players, $player);
			if ($this->number_of_players() > 4) {
				echo "ERROR: More than 4 players";
			}
			$this->manage_positions(); //Check to see if multiple players are at the same position
		}
		
		private function parse_location($location){
			$regions = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming', "BC", "Alberta", "British Columbia", "Saskatchewan", "Manitoba", "Ontario", "Quebec", "New Brunswick", "Scotland", "Newfoundland", "PEI", "Prince Edward Island", "Nova Scotia", "Northwest Territories", "NWT", "Nunavut", "Yukon", "Great Britain", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
			foreach($regions as $region) {
				if (stripos($location, $region) !== false) {
					$this->location = $region;
					break;
				}
			}			
		}
		
		//Checks to see if multiple players are playing the same position
		private function manage_positions() {
			for($i = 1; $i <= 4; $i++) {
				if ($this->collision_at_position($i) == true) {
					echo "\n\n**ERROR: Team with multiple players at same position**\n";
					$players = $this->get_players_at_position($i);
					$this->switch_positions($players);
					$this->print_team();
					//pause("");
				}
			}
		}
		
		//Is given an array of players with conflicting positions and switches them around
		private function switch_positions($players) {
			foreach($players as $player) {
				if ($player->unsure_of_position == true) {
					$player->position = $this->get_best_position();
				}
			}
		}
		
		//Returns true if there is more than one person at a given position on the same team
		private function collision_at_position($position) {
			$count = 0;
			foreach($this->players as $player) {
				if ($player->position == $position) $count++;
			}
			if ($count >= 2) {
				return true;
			}
			else {
				return false;
			}
		}
		
		//Gets the best position for the player
		private function get_best_position() {			
			for($i = 1; $i <= 4; $i++){
				if (!$this->position_is_occupied($i)) {
					return $i;
				}
			}
			echo "\n\n****ERROR: No suitable position found. in get_best_position in team.php****\n";
			//pause("");
			return 1;
		}
		
		//Returns true if a player on this team is playing the given position
		private function position_is_occupied($position) {
			foreach($this->players as $player) {
				if ($player->position == $position) return true;
			}
			return false;
		}
		
		public function get_player($position){
			foreach($this->players as $player) {
				if ($player->position == $position) return $player;
			}
			return new Player("First Name", "Last Name", 4);
		}
		
		public function get_players_at_position($position) {
			$players = array();
			foreach($this->players as $player) {
				if ($player->position == $position) array_push($players, $player);
			}
			return $players;
		}
		
		public function number_of_players() {
			return count($this->players);
		}
		
		//Returns the name of the position specified
		public function get_position($position) {
			foreach($this->players as $player) {
				if ($player->position == $position) return $player->first_name . " " . $player->last_name;
			}
		}
		
		public function print_team() {
			echo "\n";
			foreach($this->players as $player) {
				echo $player->position;
				echo ': ';
				echo $player->first_name;
				echo ' ';
				echo $player->last_name;
				echo "\t";
				if (strlen($player->last_name . $player->first_name) < 12) echo "\t";		//Add extra tab if player has short name
				echo $player->print_stats();
				echo "\xA";				
			}
			echo "Location: " . $this->location;
		}
		
		public function print_team_with_ids() {
			foreach($this->players as $player) {
				echo $player->position;
				echo ': ';
				echo $player->first_name;
				echo ' ';
				echo $player->last_name;
				echo "\t";
				if (strlen($player->last_name . $player->first_name) < 12) echo "\t";		//Add extra tab if player has short name
				echo "ID: " . $player->player_id . "\t";
				echo $player->print_stats();
				echo "\xA";				
			}
		}
		
		public function print_position($position) {
			if ($position == "Skip") {
				foreach($this->players as $player) {
					if ($player->position == "Skip"  || $player->position == 4) {
						echo $player->first_name . " " . $player->last_name;
					}
				}
			}
		}

	}
?>