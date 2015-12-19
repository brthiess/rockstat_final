DELIMITER //
DROP PROCEDURE IF EXISTS update_player_stats;

CREATE PROCEDURE update_player_stats()

BEGIN
  
  DECLARE finished INT DEFAULT FALSE;
  DECLARE player_id_cursor INT;
  
  -- Money
  DECLARE current_season_start DATE;
  DECLARE current_season_end DATE;
  DECLARE amount_won_var INT;
  
  
  -- Games
  DECLARE games 		INT DEFAULT 0;
  DECLARE games_with 	INT DEFAULT 0;
  DECLARE games_without INT DEFAULT 0;
  DECLARE wins			INT DEFAULT 0;
  DECLARE wins_with		INT DEFAULT 0;
  DECLARE wins_without	INT DEFAULT 0;
  DECLARE losses		INT DEFAULT 0;
  DECLARE losses_with	INT DEFAULT 0;
  DECLARE losses_without  		INT DEFAULT 0;
  DECLARE win_percentage  		INT DEFAULT 0;
  DECLARE win_percentage_with  	INT DEFAULT 0;
  DECLARE win_percentage_without  INT DEFAULT 0;
  DECLARE loss_percentage 	INT DEFAULT 100;
  DECLARE loss_percentage_with 	INT DEFAULT 100;
  DECLARE loss_percentage_without INT DEFAULT 100;
  
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
	
	-- ------------------Games with Hammer-----------------
	SELECT		COUNT(*)
	INTO		games_with
	FROM		player p
	INNER JOIN 	player_team pt	ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt	ON	pt.team_id = gt.team_id
	INNER JOIN 	end_game eg		ON  eg.game_id = gt.game_id
	INNER JOIN	end	e			ON	e.end_id = eg.end_id
	WHERE		e.team_id = gt.team_id
	AND 		eg.end_number = 1
	AND			e.hammer = TRUE
	AND			p.player_id = player_id_cursor;
	
	-- ------------------Games without Hammer-----------------
	SELECT		COUNT(*)
	INTO		games_without
	FROM		player p
	INNER JOIN 	player_team pt	ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt	ON	pt.team_id = gt.team_id
	INNER JOIN 	end_game eg		ON  eg.game_id = gt.game_id
	INNER JOIN	end	e			ON	e.end_id = eg.end_id
	WHERE		e.team_id = gt.team_id
	AND 		eg.end_number = 1
	AND			e.hammer = FALSE
	AND			p.player_id = player_id_cursor;
	
	
	
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
	
	-- ---------------Wins With Hammer-------------
	SELECT		COUNT(*)
	INTO		wins_with
	FROM		player p
	INNER JOIN 	player_team pt	ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt	ON	pt.team_id = gt.team_id
	INNER JOIN 	end_game eg		ON  eg.game_id = gt.game_id
	INNER JOIN	end	e			ON	e.end_id = eg.end_id
	WHERE		winner = TRUE 
	AND			e.team_id = gt.team_id
	AND 		eg.end_number = 1
	AND			e.hammer = TRUE
	AND			p.player_id = player_id_cursor;
	
	-- ---------------Wins Without Hammer-------------
	SELECT		COUNT(*)
	INTO		wins_without
	FROM		player p
	INNER JOIN 	player_team pt
		ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt	ON	pt.team_id = gt.team_id
	INNER JOIN 	end_game eg		ON  eg.game_id = gt.game_id
	INNER JOIN	end	e			ON	e.end_id = eg.end_id
	WHERE		winner = TRUE 
	AND			e.team_id = gt.team_id
	AND 		eg.end_number = 1
	AND			e.hammer = FALSE
	AND			p.player_id = player_id_cursor;
	
	-- ---------------Losses-------------------
	SET losses = games - wins;
	
	-- ---------------Losses With Hammer-------------
	SELECT		COUNT(*)
	INTO		losses_with
	FROM		player p
	INNER JOIN 	player_team pt
		ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt	ON	pt.team_id = gt.team_id
	INNER JOIN 	end_game eg		ON  eg.game_id = gt.game_id
	INNER JOIN	end	e			ON	e.end_id = eg.end_id
	WHERE		winner = FALSE 
	AND			e.team_id = gt.team_id
	AND 		eg.end_number = 1
	AND			e.hammer = TRUE
	AND			p.player_id = player_id_cursor;
	
    -- ---------------Losses Without Hammer-------------
	SELECT		COUNT(*)
	INTO		losses_without
	FROM		player p
	INNER JOIN 	player_team pt
		ON		p.player_id = pt.player_id
	INNER JOIN	game_team gt	ON	pt.team_id = gt.team_id
	INNER JOIN 	end_game eg		ON  eg.game_id = gt.game_id
	INNER JOIN	end	e			ON	e.end_id = eg.end_id
	WHERE		winner = FALSE 
	AND			e.team_id = gt.team_id
	AND 		eg.end_number = 1
	AND			e.hammer = FALSE
	AND			p.player_id = player_id_cursor;
	
	-- ----------Win Percentage------------
	SET win_percentage = wins / games * 100;
	SET win_percentage_with = wins_with / games_with * 100;
	SET win_percentage_without = wins_without / games_without * 100;
	
	SET loss_percentage = losses / games * 100;
	SET loss_percentage_with = losses_with / games_with * 100;
	SET loss_percentage_without = losses_without / games_without * 100;
	
	-- ----------Stat Type = All--------------------
	IF NOT EXISTS (SELECT 	*	 
				   FROM 	player_stats_derived
			       WHERE	player_id = player_id_cursor
				   AND		stat_type = 'all')
	THEN
		INSERT INTO player_stats_derived (player_id, stat_type)
		VALUES		(player_id_cursor, 'all');
	END IF;
	
	UPDATE		player_stats_derived
	SET			games = games, 
				wins = wins, 
				losses = losses, 
				win_percentage = win_percentage, 
				loss_percentage = loss_percentage
	WHERE		player_id = player_id_cursor
	AND			stat_type = 'all';
	
	
	-- --------------Stat Type = With--------------
	IF NOT EXISTS (SELECT 	*	 
				   FROM 	player_stats_derived
			       WHERE	player_id = player_id_cursor
				   AND		stat_type = 'with')
	THEN
		INSERT INTO player_stats_derived (player_id, stat_type)
		VALUES		(player_id_cursor, 'with');
	END IF;
	
	UPDATE		player_stats_derived
	SET			games = games_with, 
				wins = wins_with, 
				losses = losses_with, 
				win_percentage = win_percentage_with, 
				loss_percentage = loss_percentage_with
	WHERE		player_id = player_id_cursor
	AND			stat_type = 'with';
	
	
	-- -------------------Stat Type = Without---------------------
	IF NOT EXISTS (SELECT 	*	 
				   FROM 	player_stats_derived
			       WHERE	player_id = player_id_cursor
				   AND		stat_type = 'without')
	THEN
		INSERT INTO player_stats_derived (player_id, stat_type)
		VALUES		(player_id_cursor, 'without');
	END IF;
	
	UPDATE		player_stats_derived
	SET			games = games_without, 
				wins = wins_without, 
				losses = losses_without, 
				win_percentage = win_percentage_without, 
				loss_percentage = loss_percentage_without
	WHERE		player_id = player_id_cursor
	AND			stat_type = 'without';

	-- ---------------------Money Earned----------------------------
	
	-- Get money earned all time
	SELECT 	SUM(amount_won) 
	INTO 	amount_won_var
	FROM	event_team et
	INNER JOIN player_team pt ON pt.team_id = et.team_id
	INNER JOIN event e ON e.event_id = et.event_id
	WHERE 	player_id = player_id_cursor;
	
	-- Check if the record does not exist in the table
	IF NOT EXISTS (SELECT 	*	 
				   FROM 	player_money_derived
				   WHERE	player_id = player_id_cursor
				   AND		season_start IS NULL)
	THEN
		INSERT INTO player_money_derived (player_id, season_start, season_end)
		VALUES		(player_id_cursor, NULL, NULL);
	END IF;
	
	UPDATE		player_money_derived
	SET			money_earned = amount_won_var
	WHERE		player_id = player_id_cursor
	AND			season_start IS NULL
	AND			season_end IS NULL;
	
	
	-- Get current season
	SET current_season_start =  MAKEDATE(YEAR(NOW()), 213);
	
	-- Get Money won for current player for each year
	year_loop: LOOP		
		-- Only check up to 10 years back
		IF (FLOOR(DATEDIFF(current_season_start, DATE(CURDATE()))/365) < -10)   THEN
		  LEAVE year_loop;
		END IF;
		
		SET current_season_end = DATE_ADD(current_season_start, INTERVAL 1 YEAR);	
		
		SELECT 	SUM(amount_won) 
		INTO 	amount_won_var
		FROM	event_team et
		INNER JOIN player_team pt ON pt.team_id = et.team_id
		INNER JOIN event e ON e.event_id = et.event_id
		WHERE 	player_id = player_id_cursor
		AND		e.start_date BETWEEN 	current_season_start
								AND		current_season_end;
		
		-- Check if the record does not exist in the table
		IF NOT EXISTS (SELECT 	*	 
					   FROM 	player_money_derived
					   WHERE	player_id = player_id_cursor
					   AND		season_start = current_season_start)
		THEN
			INSERT INTO player_money_derived (player_id, season_start, season_end)
			VALUES		(player_id_cursor, current_season_start, current_season_end);
		END IF;
		
		UPDATE		player_money_derived
		SET			money_earned = amount_won_var
		WHERE		player_id = player_id_cursor
		AND			season_start = current_season_start
		AND			season_end = current_season_end;
		
		SET current_season_start = DATE_ADD(current_season_start, INTERVAL '-1'  YEAR);
	END LOOP;
	
  END LOOP;

  CLOSE cur1;
  
  SELECT update_ranks();
	
	
END //
DELIMITER ;