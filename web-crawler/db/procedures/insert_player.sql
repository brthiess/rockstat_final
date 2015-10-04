DELIMITER //
DROP FUNCTION IF EXISTS insert_player;

CREATE FUNCTION insert_player
(first_name_fucker VARCHAR(25), last_name_fucker VARCHAR(25), gender TINYINT(1))
RETURNS INT DETERMINISTIC
BEGIN
  
	DECLARE 	player_id_fucker	INT DEFAULT -1;
	
	SELECT 		player_id INTO player_id_fucker
	FROM 		player 
	WHERE		first_name LIKE first_name_fucker
	AND			last_name LIKE last_name_fucker;
	
	IF (player_id_fucker = -1) 
	THEN
		INSERT INTO player (first_name, last_name, gender) VALUES (first_name_fucker, last_name_fucker, gender);
		SET player_id_fucker = LAST_INSERT_ID();
	END IF;  
	
	RETURN player_id_fucker;

END //
DELIMITER ;