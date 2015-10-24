DELIMITER //
DROP FUNCTION IF EXISTS insert_rankings;

CREATE FUNCTION insert_rankings
(team_id_input INT, event_id_input INT, amount_won_input INT, points_won_input FLOAT)
RETURNS INT DETERMINISTIC
BEGIN
  
	IF NOT EXISTS  (SELECT 	* 
					FROM 	event_team
					WHERE 	team_id = team_id_input
					AND		event_id = event_id_input)
	THEN
		INSERT INTO event_team (team_id, event_id, amount_won, points_won)
		VALUES	(team_id_input, event_id_input, amount_won_input, points_won_input);
	END IF;
	
	RETURN 1;
	
END //
DELIMITER ;