DELIMITER //
DROP FUNCTION IF EXISTS insert_team;

CREATE FUNCTION insert_team
(lead_id INT, second_id INT, third_id INT, skip_id INT, gender INT)
RETURNS INT DETERMINISTIC
BEGIN
  
	DECLARE 	team_id		INT;
	DECLARE 	team_count 	INT;
	DECLARE 	team_name	VARCHAR(30);
	
	SELECT 	MAX(team_count), team_id
			INTO team_count, team_id
	FROM
		(SELECT		COUNT(*) AS team_count,
					team_id
		FROM 		player_team
		WHERE		player_id = lead_id
		OR 			player_id = second_id
		OR 			player_id = third_id
		OR			player_id = skip_id
		GROUP BY	team_id) AS number_of_teammates;
	
	IF (team_count <> 4)	
	THEN
		SELECT 	last_name INTO team_name	
		FROM	player
		WHERE	player_id = skip_id;
		INSERT 	INTO team (gender, team_name) VALUES (gender, team_name);
		SET 	team_id = LAST_INSERT_ID();
		INSERT 	INTO player_team (player_id, team_id, position) VALUES (lead_id, team_id, 1);
		INSERT 	INTO player_team (player_id, team_id, position) VALUES (second_id, team_id, 2);
		INSERT 	INTO player_team (player_id, team_id, position) VALUES (third_id, team_id, 3);
		INSERT 	INTO player_team (player_id, team_id, position) VALUES (skip_id, team_id, 4);
	END IF;	
	
	RETURN team_id;
END //
DELIMITER ;