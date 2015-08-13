--Gets the number of games for given player
DROP PROCEDURE IF EXISTS get_number_of_games;
DELIMITER //
CREATE PROCEDURE get_number_of_games(IN player_id INT)
BEGIN
  SELECT COUNT(*) 
  FROM player_team
  INNER JOIN game_team
  ON player_team.team_id=game_team.team_id
  WHERE player_team.player_id = player_id;
END //
DELIMITER ;