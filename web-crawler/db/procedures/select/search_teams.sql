DELIMITER //
DROP PROCEDURE IF EXISTS search_teams;

CREATE PROCEDURE search_teams
(IN search_term VARCHAR(500))
BEGIN
	
SELECT team_id AS id, gender, team_name AS name, location AS image, 'Team' AS type, '<p class="search-description-name">Sven Michel</p> <p class="divider">|</p> <p class="search-description-name">Kevin Martin</p> <p class="divider">|</p> <p class="search-description-name">Charley Thomas</p> <p class="divider">|</p> <p class="search-description-name">Brock Virtue</p>' AS description
FROM team
WHERE team_name LIKE CONCAT('%', search_term, '%');
	
	
END //
DELIMITER ;