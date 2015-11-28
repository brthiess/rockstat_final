DELIMITER //
DROP PROCEDURE IF EXISTS get_player_game_stats;

CREATE PROCEDURE get_player_game_stats
(IN player_id INT)
BEGIN
	
SELECT 	*, COUNT(*) AS games
FROM 	player_team pt
INNER JOIN game_team gt 	ON gt.team_id = pt.team_id
GROUP BY player_id
ORDER BY games;
	
	
END //
DELIMITER ;