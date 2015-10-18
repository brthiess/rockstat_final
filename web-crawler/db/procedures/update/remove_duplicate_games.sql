DELIMITER //
DROP PROCEDURE IF EXISTS remove_duplicate_games;



CREATE PROCEDURE remove_duplicate_games

BEGIN
	CREATE TEMPORARY TABLE IF NOT EXISTS game_ids 
	AS
		(SELECT game_id
		FROM game
		WHERE game_id IN 
					(SELECT 	  game.game_id
					FROM	game
					INNER JOIN game_team on game_team.game_id = game.game_id
					GROUP BY date, team_id
					HAVING	count(*) > 1));
	
	
 	
				
END //
DELIMITER ;

