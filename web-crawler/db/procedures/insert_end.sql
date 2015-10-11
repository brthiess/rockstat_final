DELIMITER //
DROP FUNCTION IF EXISTS insert_end;



CREATE FUNCTION insert_end
(end_id_input INT, team_id_input INT, score_input TINYINT, differential_input TINYINT, hammer_input BIT)
RETURNS INT NOT DETERMINISTIC
BEGIN

	IF EXISTS	(SELECT * 
				 FROM	end
				 WHERE	end_id	= end_id_input
				 AND	team_id 	= team_id_input)
	THEN
		return -1;
	ELSE
		INSERT INTO end (end_id, team_id, score, differential, hammer)
		VALUES(end_id_input, team_id_input, score_input, differential_input, hammer_input);
	END IF;
  
	RETURN 1;
				
END //
DELIMITER ;

