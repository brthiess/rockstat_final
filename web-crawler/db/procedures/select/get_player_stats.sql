DELIMITER //
DROP PROCEDURE IF EXISTS get_player_stats;

CREATE PROCEDURE get_player_stats
(IN player_id_input INT, IN stat_type_input VARCHAR(500))
BEGIN
	
SELECT 	* 
FROM 	player_stats_derived 
WHERE	player_id = player_id_input
AND		stat_type = stat_type_input;

	
	
END //
DELIMITER ;