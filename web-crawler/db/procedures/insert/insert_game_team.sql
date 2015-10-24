DELIMITER //
DROP FUNCTION IF EXISTS insert_game_team;



CREATE FUNCTION insert_game_team
(game_id_input INT, team_id_input INT, winner_input BIT)
RETURNS INT NOT DETERMINISTIC
BEGIN

	IF EXISTS	(SELECT * 
				 FROM	game_team
				 WHERE	game_id	= game_id_input
				 AND	team_id 	= team_id_input)
	THEN
		return -1;
	ELSE
		INSERT INTO game_team (game_id, team_id, winner)
		VALUES(game_id_input, team_id_input, winner_input);
	END IF;
  
	RETURN 1;
				
END //
DELIMITER ;

