DELIMITER //
DROP PROCEDURE IF EXISTS search_teams;

CREATE PROCEDURE search_teams
(IN search_term VARCHAR(500))
BEGIN
	
SELECT *
FROM team t
INNER JOIN player_team pt 	ON pt.team_id = t.team_id
INNER JOIN player p 		ON p.player_id = pt.player_id
WHERE team_name LIKE CONCAT('%', search_term, '%')
GROUP BY t.team_id;
	
	
END //
DELIMITER ;