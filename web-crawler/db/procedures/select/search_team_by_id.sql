DELIMITER //
DROP PROCEDURE IF EXISTS search_team_by_id;

CREATE PROCEDURE search_team_by_id
(IN team_id_input INT)
BEGIN
	
SELECT *
FROM team
WHERE team_id = team_id_input;
	
	
END //
DELIMITER ;