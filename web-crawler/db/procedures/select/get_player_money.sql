DELIMITER //
DROP PROCEDURE IF EXISTS get_player_money;

CREATE PROCEDURE get_player_money
(IN player_id_input INT)
BEGIN
	
SELECT 	* 
FROM 	player_money_derived 
WHERE	player_id = player_id_input;
	
END //
DELIMITER ;