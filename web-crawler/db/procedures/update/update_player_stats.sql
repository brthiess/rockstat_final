DELIMITER //
DROP PROCEDURE IF EXISTS update_player_stats;

CREATE PROCEDURE update_player_stats()

BEGIN
  
  DECLARE finished INT DEFAULT FALSE;
  DECLARE player_id_cursor INT;
  
  DECLARE games INT DEFAULT 0;
  DECLARE wins	INT DEFAULT 0;
  DECLARE losses	INT DEFAULT 0;
  DECLARE win_percentage INT DEFAULT 0;
  DECLARE loss_percentage INT DEFAULT 100;
  
  DECLARE cur1 CURSOR FOR SELECT player_id FROM player p;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
  
  
  OPEN cur1;

  read_loop: LOOP
    FETCH cur1 INTO player_id_cursor;
    IF finished THEN
      LEAVE read_loop;
    END IF;
	

	-- ------------------Games-----------------
	SELECT		COUNT(*)
	INTO		games
	FROM 		player p
	INNER JOIN  player_team pt
		ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt
	ON			pt.team_id = gt.team_id
	WHERE 		p.player_id = player_id_cursor;
	
	-- --------------Wins-----------------
	SELECT 		COUNT(*)
	INTO		wins
	FROM		player p
	INNER JOIN 	player_team pt
		ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt
	ON			pt.team_id = gt.team_id
	WHERE		winner = TRUE 
	AND			p.player_id = player_id_cursor;
	
	-- ---------------Losses-------------------
	SET losses = games - wins;
	SET win_percentage = wins / games * 100;
	SET loss_percentage = losses / games * 100;
	
	IF NOT EXISTS (SELECT 	*	 
				   FROM 	player_stats_derived
			       WHERE	player_id = player_id_cursor)
	THEN
		INSERT INTO player_stats_derived (player_id)
		VALUES		(player_id_cursor);
	END IF;
	
	UPDATE		player_stats_derived
	SET			games = games, wins = wins, losses = losses, win_percentage = win_percentage, loss_percentage = loss_percentage
	WHERE		player_id = player_id_cursor;

    
	
  END LOOP;

  CLOSE cur1;
  
  SELECT update_ranks();
	
	
END //
DELIMITER ;