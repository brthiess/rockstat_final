DELIMITER //
DROP PROCEDURE IF EXISTS search_player_by_team;

CREATE PROCEDURE search_player_by_team
(IN team_id_input INT)
BEGIN
	
SELECT *
FROM player_team pt
INNER JOIN player p 		ON p.player_id = pt.player_id
WHERE team_id = team_id_input
ORDER BY team_id, position DESC;
	
	
END //
DELIMITER ;