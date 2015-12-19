DROP TABLE IF EXISTS game_team;
DROP TABLE IF EXISTS end;
DROP TABLE IF EXISTS end_game;
DROP TABLE IF EXISTS player_game;
DROP TABLE IF EXISTS game;
DROP TABLE IF EXISTS event_team;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS player_team;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS player;

DROP TABLE IF EXISTS player_stats_derived;
DROP TABLE IF EXISTS player_money_derived;


CREATE TABLE player (
	player_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	first_name varchar(25),
	last_name varchar(25),
	FULLTEXT(first_name, last_name),
	gender TINYINT(1),
	CONSTRAINT unique_name UNIQUE(first_name, last_name)
);

CREATE TABLE team (
	team_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	gender TINYINT(1),
	location varchar(30),	
	team_name varchar(30)
);

CREATE TABLE player_team (
	player_id INT NOT NULL,
	team_id INT NOT NULL,
	position TINYINT(1),
	FOREIGN KEY (player_id) REFERENCES player(player_id),
	FOREIGN KEY (team_id) REFERENCES team(team_id),
	CONSTRAINT unique_player_team UNIQUE(player_id, team_id)
);


CREATE TABLE event (
	event_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(500),
	type VARCHAR(25),
	number_of_qualifiers TINYINT,
	fgz INT,
	category VARCHAR(30),
	city VARCHAR(50),
	province VARCHAR(50),
	start_date DATE,
	end_date DATE,
	purse INT,
	currency VARCHAR(10),
	gender TINYINT(1)
);

CREATE TABLE event_team (
	team_id INT NOT NULL,
	event_id INT NOT NULL,
	amount_won INT,
	points_won FLOAT,
	FOREIGN KEY (team_id) REFERENCES team(team_id),
	FOREIGN KEY (event_id) REFERENCES event(event_id),
	CONSTRAINT unique_event_team UNIQUE(team_id, event_id)
);

CREATE TABLE game (
	game_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	event_id INT NOT NULL,
	FOREIGN KEY (event_id) REFERENCES event(event_id),
	date DATETIME
);

CREATE TABLE player_game (
	player_id INT NOT NULL,
	game_id INT NOT NULL,
	percentage FLOAT,
	num_shots INT,
	FOREIGN KEY (player_id) REFERENCES player(player_id),
	FOREIGN KEY (game_id) REFERENCES game(game_id),
	CONSTRAINT player_and_game UNIQUE (player_id,game_id)
);

CREATE TABLE end_game (
	end_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	end_number TINYINT(2),
	game_id INT NOT NULL,
	FOREIGN KEY (game_id) REFERENCES game(game_id)
);

CREATE TABLE end (
	end_id INT NOT NULL,
	team_id INT NOT NULL,
	score TINYINT,
	differential TINYINT,	
	hammer BIT,			
	PRIMARY KEY(end_id, team_id),
	FOREIGN KEY (end_id) REFERENCES end_game(end_id),
	FOREIGN KEY (team_id) REFERENCES team(team_id)
);

CREATE TABLE game_team (
	game_id INT NOT NULL,
	team_id INT NOT NULL,
	winner BIT,		
	FOREIGN KEY (game_id) REFERENCES game(game_id),
	FOREIGN KEY (team_id) REFERENCES team(team_id)
);




CREATE TABLE player_stats_derived (
	player_id INT NOT NULL,
	stat_type VARCHAR(10),
	games INT,
	games_rank INT,
	wins INT,
	wins_rank INT,
	losses INT,
	losses_rank INT,
	win_percentage INT,
	win_percentage_rank INT,
	loss_percentage INT,
	loss_percentage_rank INT,
	FOREIGN KEY (player_id) REFERENCES player(player_id)
);

CREATE TABLE player_money_derived (
	player_id INT NOT NULL,
	season_start DATE,
	season_end DATE,
	money_earned INT,
	money_earned_rank INT
);






