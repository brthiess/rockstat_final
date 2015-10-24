DELIMITER //
DROP FUNCTION IF EXISTS insert_player_stats;


CREATE FUNCTION insert_player_stats
(player_id_input INT, game_id_input INT, percentage_input FLOAT, num_shots_input INT)
RETURNS INT NOT DETERMINISTIC
BEGIN
  
	IF EXISTS	(SELECT * 
				 FROM	player_game
				 WHERE	player_id 	= player_id_input
				 AND	game_id 	= game_id_input)
	THEN
		return -1;
	ELSE
		INSERT INTO player_game (player_id, game_id, percentage, num_shots)
		VALUES(player_id_input, game_id_input, percentage_input, num_shots_input);
	END IF;
  
	RETURN 1;
				
END //
DELIMITER ;