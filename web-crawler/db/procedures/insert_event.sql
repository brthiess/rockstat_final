DELIMITER //
DROP FUNCTION IF EXISTS insert_event;

CREATE FUNCTION insert_event
(name_input VARCHAR(50), type_input VARCHAR(25), fgz_input INT, category_input VARCHAR(30), city_input VARCHAR(50), province_input VARCHAR(50), start_date_input DATE, end_date_input DATE, purse_input INT, gender_input TINYINT(1))
RETURNS INT DETERMINISTIC
BEGIN
  
	DECLARE 	event_id_var	INT DEFAULT -1;

	
	SELECT 		event_id 
	INTO		event_id_var
	FROM 		event
	WHERE		name LIKE name_input
	AND 		type = type_input
	AND 		fgz = fgz_input
	AND			category = category_input
	AND			city_input = city_input
	AND			province_input = province_input
	AND 		start_date = start_date_input
	AND			end_date = end_date_input
	AND			gender = gender_input;
		
	IF (event_id_var != -1) THEN
		RETURN event_id_var;
	ELSE
		INSERT INTO event (name, type, fgz, category, city, province, start_date, end_date, gender)
		VALUES		(name_input, type_input, fgz_input, category_input, city_input, province_input, start_date_input, end_date_input, gender_input);
		SET 		event_id_var = LAST_INSERT_ID();
	END IF;
	
	return event_id_var;
				
END //
DELIMITER ;