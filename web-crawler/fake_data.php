<?php 
	//Returns fake event data for testing
	function fake_event_data() {
		$event = new Event(new Location("Edmonton", "Alberta"), new DateTime("03/01/2015"), new DateTime("03/05/2015"), "50000", "CDN", "The Brad Thiessen Classic", MEN, get_fake_teams(), WCT, get_fake_ranking_list(), "Triple Knockout")
		$event->games = get_fake_games();
	}
	
	function get_fake_teams() {
		$teams = array();
		$team = new Team();
		$team->add_player("Joe", "Blow", 1, get_fake_stats(), MEN);
		$team->add_player("Brad", "Thiessen", 2, get_fake_stats(), MEN);
		$team->add_player("Tom", "Appelman", 3, get_fake_stats(), MEN);
		$team->add_player("Brendan", "Bottcher", 4, get_fake_stats(), MEN);
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player("Karrick", "Martin", 1, get_fake_stats(), MEN);
		$team->add_player("Brad", "Thiessen", 2, get_fake_stats(), MEN);
		$team->add_player("Tom", "Appelman", 3, get_fake_stats(), MEN);
		$team->add_player("Brendan", "Bottcher", 4, get_fake_stats(), MEN);
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player("Karrick", "Martin", 1, get_fake_stats(), MEN);
		$team->add_player("Brad", "Thiessen", 2, get_fake_stats(), MEN);
		$team->add_player("Tom", "Appelman", 3, get_fake_stats(), MEN);
		$team->add_player("Brandan", "Bottcher", 4, get_fake_stats(), MEN);
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player("Brad Test", "Gushue", 1, get_fake_stats(), MEN);
		$team->add_player("Brad", "Thiessen", 2, get_fake_stats(), MEN);
		$team->add_player("Blah", "Appelman", 3, get_fake_stats(), MEN);
		$team->add_player("Skip", "Martin", 4, get_fake_stats(), MEN);
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player("Blah", "Martin", 1, get_fake_stats(), MEN);
		$team->add_player("Brad", "Thiessen", 2, get_fake_stats(), MEN);
		$team->add_player("Test", "Third", 3, get_fake_stats(), MEN);
		$team->add_player("Brendan", "Bottcher", 4, get_fake_stats(), MEN);
		array_push($teams, $team);
		
		$team = new Team();
		$team->add_player("Karrick", "Martin", 1, get_fake_stats(), MEN);
		$team->add_player("Second", "Second", 2, get_fake_stats(), MEN);
		$team->add_player("Tom", "Appelman", 3, get_fake_stats(), MEN);
		$team->add_player("Brendan", "Bottcher", 4, get_fake_stats(), MEN);
		array_push($teams, $team);		
	}
	
	function get_fake_stats() {
		return new Stats(rand(50,100), rand(12, 20));
	}
	
	function get_fake_ranking_list() {
		$ranking_list = array();
		
		$team = new Team();
		$team->add_player("Joe", "Blow", 1, get_fake_stats(), MEN);
		$team->add_player("Brad", "Thiessen", 2, get_fake_stats(), MEN);
		$team->add_player("Tom", "Appelman", 3, get_fake_stats(), MEN);
		$team->add_player("Brendan", "Bottcher", 4, get_fake_stats(), MEN);
		
		array_push($ranking_list, Event_Team_Points($team, "12000", "5.44", "1"));
		
		$team = new Team();
		$team->add_player("Blah", "Martin", 1, get_fake_stats(), MEN);
		$team->add_player("Brad", "Thiessen", 2, get_fake_stats(), MEN);
		$team->add_player("Test", "Third", 3, get_fake_stats(), MEN);
		$team->add_player("Brendan", "Bottcher", 4, get_fake_stats(), MEN);
		array_push($ranking_list, Event_Team_Points($team, "12000", "3.0", "2"));
		
		$team = new Team();
		$team->add_player("Karrick", "Martin", 1, get_fake_stats(), MEN);
		$team->add_player("Second", "Second", 2, get_fake_stats(), MEN);
		$team->add_player("Mark", "Nichols", 3, get_fake_stats(), MEN);
		$team->add_player("Brad", "Gushue", 4, get_fake_stats(), MEN);
		array_push($ranking_list, Event_Team_Points($team, "12000", "2.5", "3"));
		
		return $ranking_list;
	}
	
	function get_fake_games() {
		$teams = get_fake_teams();
		
		
	}


?>