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


CREATE TABLE player (
	player_id INT NOT NULL PRIMARY KEY,
	first_name varchar(25),
	last_name varchar(25),
	gender TINYINT(1),
	CONSTRAINT unique_name UNIQUE(first_name, last_name)
);

CREATE TABLE team (
	team_id INT NOT NULL PRIMARY KEY,
	gender TINYINT(1),
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
	event_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50),
	type VARCHAR(25),
	fgz INT,
	category VARCHAR(30),
	location VARCHAR(50),
	start_date DATE,
	end_date DATE,
	purse INT,
	gender TINYINT(1)
);

CREATE TABLE event_team (
	team_id INT NOT NULL,
	event_id INT NOT NULL,
	event_rank INT,
	amount_won INT,
	points_won FLOAT,
	FOREIGN KEY (team_id) REFERENCES team(team_id),
	FOREIGN KEY (event_id) REFERENCES event(event_id)
);

CREATE TABLE game (
	game_id INT NOT NULL PRIMARY KEY,
	event_id INT NOT NULL,
	FOREIGN KEY (event_id) REFERENCES event(event_id),
	date DATE
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
	end_id INT NOT NULL PRIMARY KEY,
	end_number TINYINT(1),
	game_id INT NOT NULL,
	FOREIGN KEY (game_id) REFERENCES game(game_id)
);

CREATE TABLE end (
	end_id INT NOT NULL,
	team_id INT NOT NULL,
	score TINYINT,
	differential TINYINT,	
	hammer BOOLEAN,			
	PRIMARY KEY(end_id, team_id),
	FOREIGN KEY (end_id) REFERENCES end_game(end_id),
	FOREIGN KEY (team_id) REFERENCES team(team_id)
);

CREATE TABLE game_team (
	game_id INT NOT NULL,
	team_id INT NOT NULL,
	winner BOOLEAN,		
	FOREIGN KEY (game_id) REFERENCES game(game_id),
	FOREIGN KEY (team_id) REFERENCES team(team_id)
);





