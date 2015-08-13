DROP TABLE IF EXISTS game_team;
DROP TABLE IF EXISTS end;
DROP TABLE IF EXISTS end_game;
DROP TABLE IF EXISTS game;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS player_team;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS player;


CREATE TABLE player (
	player_id INT NOT NULL PRIMARY KEY,
	first_name varchar(25),
	last_name varchar(25),
	gender TINYINT(1)
);

CREATE TABLE team (
	team_id INT NOT NULL PRIMARY KEY,
	gender TINYINT(1)
);

CREATE TABLE player_team (
	player_id INT NOT NULL,
	team_id INT NOT NULL,
	position TINYINT(1),
	FOREIGN KEY (player_id) REFERENCES player(player_id),
	FOREIGN KEY (team_id) REFERENCES team(team_id)
);

CREATE TABLE event (
	event_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50),
	type TINYINT,
	location VARCHAR(50),
	start_date DATE,
	end_date DATE,
	purse INT
);

CREATE TABLE game (
	game_id INT NOT NULL PRIMARY KEY,
	date DATE
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


DROP PROCEDURE IF EXISTS get_games;
DELIMITER //
CREATE PROCEDURE get_games(IN player_id INT)
BEGIN
  SELECT COUNT(*) 
  FROM player_team
  INNER JOIN game_team
  ON player_team.team_id=game_team.team_id
  WHERE player_team.player_id = player_id;
END //
DELIMITER ;



