DELIMITER //
DROP FUNCTION IF EXISTS insert_game;

CREATE FUNCTION insert_game
(event_id_input INT, date_input DATETIME)
RETURNS INT DETERMINISTIC
BEGIN
	
	DECLARE game_id_var INT DEFAULT -1;

		INSERT INTO game (event_id, date)
		VALUES	(event_id_input, date_input);

	SET game_id_var = LAST_INSERT_ID();
	RETURN game_id_var;
	
END //
DELIMITER ;