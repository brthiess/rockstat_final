DELIMITER //
DROP FUNCTION IF EXISTS update_ranks;



CREATE FUNCTION update_ranks
()
RETURNS INT NOT DETERMINISTIC
BEGIN

-- ----------------------------------------
-- Updates the rankings of every table
-- ----------------------------------------
  DECLARE stat_type_var VARCHAR(10);
  DECLARE number_of_stat_types INT DEFAULT 3;
  DECLARE i INT DEFAULT 0;
  DECLARE current_season_start DATE;
  
  
WHILE i < number_of_stat_types DO
	IF (i = 0)
	THEN
		SET stat_type_var = 'all';
	ELSEIF (i = 1)
	THEN
		SET stat_type_var = 'with';
	ELSE
		SET stat_type_var = 'without';
	END IF;
	
	
	 -- -----------Games Rank--------------
	UPDATE player_stats_derived p
	INNER JOIN 
	(SELECT player_id, rank FROM
	( 
	SELECT
	  player_stats_derived.player_id,
	  player_stats_derived.games,
	  @prev := @curr,
	  @curr := games,
	  @rank := IF(@prev = @curr, @rank, @rank + @i) AS rank,
	  IF(@prev <> games, @i:=1, @i:=@i+1) AS counter
	FROM
	  player_stats_derived,
	  (SELECT @curr := null, @prev := null, @rank := 0, @i := 0) tmp_tbl
	WHERE stat_type = stat_type_var
	ORDER BY
	  player_stats_derived.games DESC) AA) A
	  ON p.player_id = A.player_id
	  SET p.games_rank = A.rank + 1
	  WHERE p.stat_type = stat_type_var;  
	  
	  -- -----------Wins Rank--------------
	UPDATE player_stats_derived p
	INNER JOIN 
	(SELECT player_id, rank FROM
	( 
	SELECT
	  player_stats_derived.player_id,
	  player_stats_derived.wins,
	  @prev := @curr,
	  @curr := wins,
	  @rank := IF(@prev = @curr, @rank, @rank + @i) AS rank,
	  IF(@prev <> wins, @i:=1, @i:=@i+1) AS counter
	FROM
	  player_stats_derived,
	  (SELECT @curr := null, @prev := null, @rank := 0, @i := 0) tmp_tbl
	WHERE stat_type = stat_type_var
	ORDER BY
	  player_stats_derived.wins DESC) AA) A
	  ON p.player_id = A.player_id
	  SET p.wins_rank = A.rank + 1
	  WHERE p.stat_type = stat_type_var; 
	
	
	   -- -----------Losses Rank--------------
	UPDATE player_stats_derived p
	INNER JOIN 
	(SELECT player_id, rank FROM
	( 
	SELECT
	  player_stats_derived.player_id,
	  player_stats_derived.losses,
	  @prev := @curr,
	  @curr := losses,
	  @rank := IF(@prev = @curr, @rank, @rank + @i) AS rank,
	  IF(@prev <> losses, @i:=1, @i:=@i+1) AS counter
	FROM
	  player_stats_derived,
	  (SELECT @curr := null, @prev := null, @rank := 0, @i := 0) tmp_tbl
	WHERE stat_type = stat_type_var
	ORDER BY
	  player_stats_derived.losses DESC) AA) A
	  ON p.player_id = A.player_id
	  SET p.losses_rank = A.rank + 1
	  WHERE p.stat_type = stat_type_var; 
  
	-- -----------Win Percentage Rank--------------
	UPDATE player_stats_derived p
	INNER JOIN 
	(SELECT player_id, rank FROM
	( 
	SELECT
	  player_stats_derived.player_id,
	  player_stats_derived.win_percentage,
	  @prev := @curr,
	  @curr := win_percentage,
	  @rank := IF(@prev = @curr, @rank, @rank + @i) AS rank,
	  IF(@prev <> win_percentage, @i:=1, @i:=@i+1) AS counter
	FROM
	  player_stats_derived,
	  (SELECT @curr := null, @prev := null, @rank := 0, @i := 0) tmp_tbl
	WHERE stat_type = stat_type_var
	ORDER BY
	  player_stats_derived.win_percentage DESC) AA) A
	  ON p.player_id = A.player_id
	  SET p.win_percentage_rank = A.rank + 1
	  WHERE p.stat_type = stat_type_var; 
	  
	  
	  
	  
	-- -----------Loss Percentage Rank--------------

	UPDATE player_stats_derived p
	INNER JOIN 
	(SELECT player_id, rank FROM
	( 
	SELECT
	  player_stats_derived.player_id,
	  player_stats_derived.loss_percentage,
	  @prev := @curr,
	  @curr := loss_percentage,
	  @rank := IF(@prev = @curr, @rank, @rank + @i) AS rank,
	  IF(@prev <> loss_percentage, @i:=1, @i:=@i+1) AS counter
	FROM
	  player_stats_derived,
	  (SELECT @curr := null, @prev := null, @rank := 0, @i := 0) tmp_tbl
	WHERE stat_type = stat_type_var
	ORDER BY
	  player_stats_derived.loss_percentage DESC) AA) A
	  ON p.player_id = A.player_id
	  SET p.loss_percentage_rank = A.rank + 1
	  WHERE p.stat_type = stat_type_var; 	  
	  
	
    SET i=i+1;
END WHILE;
  
  
  -- ------------ Money Earned Rank-------------------------
UPDATE 	player_money_derived
SET 	money_earned = 0
WHERE 	money_earned IS NULL;

SET current_season_start =  MAKEDATE(YEAR(NOW()), 213);
WHILE (FLOOR(DATEDIFF(current_season_start, DATE(CURDATE()))/365) > -11) DO
	
	UPDATE player_money_derived p
	INNER JOIN 
	(SELECT player_id, rank FROM
	( 
	SELECT
	  player_money_derived.player_id,
	  player_money_derived.money_earned,
	  @prev := @curr,
	  @curr := money_earned,
	  @rank := IF(@prev = @curr, @rank, @rank + @i) AS rank,
	  IF(@prev <> money_earned, @i:=1, @i:=@i+1) AS counter
	FROM
	  player_money_derived,
	  (SELECT @curr := null, @prev := null, @rank := 0, @i := 0) tmp_tbl
	WHERE season_start = current_season_start
	ORDER BY
	  player_money_derived.money_earned DESC) AA) A
	  ON p.player_id = A.player_id
	  SET p.money_earned_rank = A.rank + 1
	  WHERE p.season_start = current_season_start;
	  
	  
	SET current_season_start = DATE_ADD(current_season_start, INTERVAL '-1'  YEAR);

END WHILE;

	UPDATE player_money_derived p
	INNER JOIN 
	(SELECT player_id, rank FROM
	( 
	SELECT
	  player_money_derived.player_id,
	  player_money_derived.money_earned,
	  @prev := @curr,
	  @curr := money_earned,
	  @rank := IF(@prev = @curr, @rank, @rank + @i) AS rank,
	  IF(@prev <> money_earned, @i:=1, @i:=@i+1) AS counter
	FROM
	  player_money_derived,
	  (SELECT @curr := null, @prev := null, @rank := 0, @i := 0) tmp_tbl
	WHERE season_start IS NULL
	ORDER BY
	  player_money_derived.money_earned DESC) AA) A
	  ON p.player_id = A.player_id
	  SET p.money_earned_rank = A.rank + 1
	  WHERE p.season_start IS NULL;
  
  RETURN 1;
				
END //
DELIMITER ;

