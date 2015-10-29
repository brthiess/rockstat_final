DELIMITER //
DROP PROCEDURE IF EXISTS search_teams;

CREATE PROCEDURE search_teams
(IN search_term VARCHAR(500))
BEGIN
	
SELECT * FROM team
WHERE team_name LIKE CONCAT('%', search_term, '%');
	
	
END //
DELIMITER ;