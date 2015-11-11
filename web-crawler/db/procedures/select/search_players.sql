DELIMITER //
DROP PROCEDURE IF EXISTS search_players;

CREATE PROCEDURE search_players
(IN search_term VARCHAR(500))
BEGIN
	
SELECT 	player_id, first_name, last_name, gender, levenshtein(search_term, first_name) AS first_name_relevancy, levenshtein(search_term, last_name) AS last_name_relevancy
FROM  	player
HAVING 	first_name_relevancy < 2
OR		last_name_relevancy < 2;	


END //
DELIMITER ;