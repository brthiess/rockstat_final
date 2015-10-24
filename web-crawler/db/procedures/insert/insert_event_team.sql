DELIMITER //
DROP FUNCTION IF EXISTS insert_end_game;

CREATE FUNCTION insert_end_game
(end_number_input TINYINT, game_id_input INT)
RETURNS INT NOT DETERMINISTIC
BEGIN
	
	DECLARE 	end_id_var	INT DEFAULT -1;

	SELECT	end_id
	INTO	end_id_var
	FROM	end_game
	WHERE	end_number 	= end_number_input
	AND		game_id 	= game_id_input;
	
	IF (end_id_var = -1)
	THEN
		INSERT INTO end_game (end_number, game_id)
		VALUES(end_number_input, game_id_input);
		SET end_id_var = LAST_INSERT_ID();
	END IF;
	
	RETURN end_id_var;

				
END //
DELIMITER ;