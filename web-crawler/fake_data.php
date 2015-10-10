<?php 
	//Returns fake event data for testing
	function fake_event_data() {
		$event = new Event(new Location("Edmonton", "Alberta"), mktime(0,0,0,3,1,2015), mktime(0,0,0,3,4,2015), 50000, "CDN", "The Brad Thiessen Classic", MEN, get_fake_teams(), WCT, get_fake_ranking_list(), new Format("Triple Knockout", 8), 4);
		$event->games = get_fake_games();
		return $event;
	}
	
	function get_fake_teams() {
		$teams = array();
		$team = new Team();
		$team->add_player(new Player("Joe", "Blow", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Brad", "Thiessen", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("Tom", "Appelman", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Brad", "Gushue", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player(new Player("Karrick", "Martin", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Brad", "Thiessen", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("Tom", "Appelman", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Brendan", "Bottcher", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player(new Player("Karrick", "Martin", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Brad", "Thiessen", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("Tom", "Appelman", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Brandan", "Bottcher", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player(new Player("Brad Test", "Gushue", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Brad", "Thiessen", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("Blah", "Appelman", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Skip", "Martin", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player(new Player("Blah", "Martin", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Brad", "Thiessen", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("Test", "Third", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Brendan", "Bottcher", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player(new Player("Karrick", "Martin", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Second", "Second", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("Tom", "Appelman", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Brendan", "Bottcher", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);	
		
		$team = new Team();
		$team->add_player(new Player("Mark", "Nichols", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Jacobs", "Brad", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("Tom", "Appelman", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Ryan", "Fry", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player(new Player("DJ", "Neufeld", 1, get_fake_stats(), MEN));
		$team->add_player(new Player("Mike", "Wozniak", 2, get_fake_stats(), MEN));
		$team->add_player(new Player("BJ", "Neufeuld", 3, get_fake_stats(), MEN));
		$team->add_player(new Player("Mike", "Mcewen", 4, get_fake_stats(), MEN));
		$team->gender = MEN;
		array_push($teams, $team);

		
		return $teams;
	}
	
	function get_fake_stats() {
		return new Stats(rand(50,100), rand(12, 20));
	}
	
	function get_fake_ranking_list() {
		$ranking_list = array();
		
		$fake_teams = get_fake_teams();
		
		$rank = 1;
		$money = 15000;
		$points = 12.5;
		
		foreach($fake_teams as $team) {
			array_push($ranking_list, new Event_Team_Points($team, $money, $points, $rank));
			$rank++;
			$money -= 2000;
			$points -= 2;
		}
		
		return $ranking_list;
	}
	
	function get_fake_games() {
		$teams = get_fake_teams();
		$games = array();
		for($i = 0; $i < 20; $i++) {
			$linescore = get_fake_linescore();
			$hammer = rand(0,1);
			$date = date_create("2015-03-01 2:30");
			array_push($games, new Game($teams[rand(0, count($teams) - 1)], $teams[rand(0, count($teams) - 1)], $linescore, $hammer, $date));
		}
		
		return $games;		
	}
	
	function get_fake_linescore() {
		$linescore = new LineScore();
		for($end_number = 1; $end_number <= 8; $end_number++) {
			if (rand(0,1) == 1) {
				$linescore->addEnd(rand(0,5), 0);
			}
			else {
				$linescore->addEnd(0, rand(0,5));
			}		
		}
		return $linescore;
	}


?>