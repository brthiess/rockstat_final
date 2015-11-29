DELIMITER //
DROP PROCEDURE IF EXISTS search_player_by_id;

CREATE PROCEDURE search_player_by_id
(IN player_id_input INT)
BEGIN
	
SELECT *
FROM player
WHERE player_id = player_id_input;
	
	
END //
DELIMITER ;