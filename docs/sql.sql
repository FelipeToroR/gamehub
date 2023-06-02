SET sql_mode = '';

SELECT 

   DISTINCT(u00.id) AS usuario_id,
   
   TRIM(CONCAT(u00.name, " ", COALESCE(u00.first_surname, ""), " ", COALESCE(u00.second_surname, "") )) AS nombre,
   
   gi00.name AS tipo,
   
   u00.gender AS gender,

    # Cuenta eventos de inicio
   (SELECT COUNT(*) FROM game_exercises AS ge01 
       JOIN user_experiments AS ue01 ON ge01.game_instance_id = ue01.game_instance_id
       WHERE ge01.event = 1 AND ge01.user_id = u00.id AND ue01.experiment_id = 28 
   ) AS it00cnt_start_event,

    # Cuenta eventos de término
   (SELECT COUNT(*) FROM game_exercises AS ge02
    JOIN user_experiments AS ue02 ON ge02.game_instance_id = ue02.game_instance_id
    WHERE ge02.event = 3 AND ge02.user_id = u00.id AND ue02.experiment_id = 28 
   ) AS it00cnt_end_event, 

    # Cuenta los ejercicios realizados
   (SELECT COUNT(*) FROM game_exercises AS ge03 
       JOIN user_experiments AS ue03 ON ge03.game_instance_id = ue03.game_instance_id AND ue03.user_id = ge03.user_id
       WHERE ge03.event = 2 AND ge03.user_id = u00.id AND ue03.experiment_id = 28 ) 
    AS qexer,

    
   (SELECT COUNT(*) FROM game_exercises AS ge04  
       JOIN user_experiments AS ue04 ON ge04.game_instance_id = ue04.game_instance_id AND ue04.user_id = ge04.user_id
       WHERE ge04.event = 2 AND ge04.user_id = u00.id AND ( ge04.user_response = ge04.response ) AND ue04.experiment_id = 28 ) 
   AS cant_ejercicios_buenos,

   (SELECT COUNT(*) FROM game_exercises AS ge05  
       JOIN user_experiments AS ue05 ON ge05.game_instance_id = ue05.game_instance_id AND ue05.user_id = ge05.user_id
       WHERE ge05.event = 2 AND ge05.user_id = u00.id AND ( ge05.user_response != ge05.response AND ge05.user_response != 0) AND ue05.experiment_id = 28 ) 
   AS cant_ejercicios_malos,

   (SELECT COUNT(*) FROM game_exercises AS ge06
       JOIN user_experiments AS ue06 ON ge06.game_instance_id = ue06.game_instance_id AND ue06.user_id = ge06.user_id
       WHERE ge06.event = 2 AND ge06.user_id = u00.id AND ( ge06.user_response != ge06.response AND ge06.user_response = 0 ) AND  ue06.experiment_id = 28 ) 
   AS cant_ejercicios_omitidos,

    # Cantidad de ejercicios distintos
  (SELECT COUNT(DISTINCT(ge07.exercise)) FROM game_exercises AS ge07
       JOIN user_experiments AS ue07 ON ge07.game_instance_id = ue07.game_instance_id AND ue07.user_id = ge07.user_id
       WHERE ge07.event = 2 AND ge07.user_id = u00.id AND ue07.experiment_id = 28)
   AS qdistinctexer,

    tb11sumbb,
   
    tb11summm,
   
    tb11sumbm,
   
	tb11summb,
   
	(tb11summb - tb11sumbm) as qenhacement

   from `game_exercises` as `ge00` 
	
	inner join `user_experiments` as `ue00` on ue00.user_id = ge00.user_id 
	
	inner join `game_instances` as `gi00` on gi00.id = ue00.game_instance_id 
	
	inner join `users` as `u00` on u00.id = ge00.user_id 
	
	INNER JOIN

	(
	
	    SELECT tb10.u10id AS u11id, tb10.u10name AS u11name, SUM(tb10bb) AS tb11sumbb, SUM(tb10mm) AS tb11summm, SUM(tb10mb) AS tb11summb, SUM(tb10bm) AS tb11sumbm 
		 FROM (
		  
			  SELECT 
			   u10.id AS u10id, u10.name AS u10name, gi10.name AS gi10name, ge10.exercise AS ge10exercise,
			   (GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 'O', IF(ge10.user_response = ge10.response, 'B', 'M')))) AS tb10seq,
			   LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 AND  
			   RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 
			   AS tb10bb,
			   LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 AND  
			   RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 
			   AS tb10mm,
			   LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 AND  
			   RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 
			   AS tb10bm,
			   LEFT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 1, IF(ge10.user_response = ge10.response, 0, 1))),1) = 1 AND  
			   RIGHT(GROUP_CONCAT(IF(ge10.user_response <> ge10.response AND ge10.user_response = 0, 0, IF(ge10.user_response = ge10.response, 1, 0))),1) = 1 
			   AS tb10mb
			  FROM game_exercises AS ge10 
			  LEFT JOIN user_experiments AS ue10 ON ue10.user_id = ge10.user_id
			  LEFT JOIN game_instances AS gi10 ON gi10.id = ue10.game_instance_id
			  LEFT JOIN users AS u10 ON u10.id = ge10.user_id
			  WHERE ue10.game_instance_id IS NOT NULL 
			   AND ue10.experiment_id = 28
			   AND ge10.event = 2
			  GROUP BY u10.id asc, ge10.exercise ASC
		  
	    ) tb10 GROUP BY tb10.u10id
	
	) as j01

 	on j01.u11id = u00.id 
	
	where `ue00`.`game_instance_id` is not null 
		and `ue00`.`experiment_id` = 28 
		and `ge00`.`event` = 2 
	
	group by u00.id order by u00.id asc