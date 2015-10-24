DELIMITER //
DROP FUNCTION IF EXISTS game_exists;

CREATE FUNCTION game_exists
(event_id_input INT, date_input DATETIME, team1_id_input INT, team2_id_input INT)
RETURNS INT NOT DETERMINISTIC
BEGIN
	
	DECLARE game_id_var1 INT DEFAULT -1;
	DECLARE game_id_var2 INT DEFAULT -1;
	
	IF EXISTS
			(SELECT g.game_id
			FROM	game g
			INNER JOIN game_team gt
			ON 		gt.game_id = g.game_id
			WHERE	event_id 	= event_id_input
			AND		date		= date_input
			AND		team_id		= team1_id_input)
	THEN 
		 SELECT g.game_id
		 INTO 	game_id_var1
		 FROM	game g
		 INNER JOIN game_team gt
		 ON 		gt.game_id = g.game_id
		 WHERE	event_id 	= event_id_input
		 AND		date		= date_input
		 AND		team_id		= team1_id_input
		 LIMIT 1;
		IF EXISTS
			   (SELECT 	g.game_id
				FROM	game g
				INNER JOIN game_team gt
				ON gt.game_id = g.game_id
				WHERE	event_id 	= event_id_input
				AND		date		= date_input
				AND		team_id		= team1_id_input)
				THEN
					SELECT	g.game_id
					INTO 	game_id_var2
					FROM	game g
					INNER JOIN game_team gt
					ON		gt.game_id = g.game_id
					WHERE 	event_id = event_id_input
					AND		date	= date_input
					AND		team_id = team2_id_input
					LIMIT 1;
					IF (game_id_var1 = game_id_var2)
					THEN
						RETURN 1;
					END IF;
				END IF;
	END IF;
	RETURN 0;
	
	
END //
DELIMITER ;