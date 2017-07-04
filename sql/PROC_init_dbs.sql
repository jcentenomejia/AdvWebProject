use DELIMITER $$

CREATE PROCEDURE init_dbs()

BEGIN

 SET FOREIGN_KEY_CHECKS = 0;
 TRUNCATE TABLE class;
 TRUNCATE TABLE user;
 TRUNCATE TABLE trainer;
 TRUNCATE TABLE class_member;
 TRUNCATE TABLE evaluation;
 TRUNCATE TABLE test;
 TRUNCATE TABLE quiz;
 TRUNCATE TABLE sql_question;
 TRUNCATE TABLE sql_answer;
 TRUNCATE TABLE quiz_question;
 SET FOREIGN_KEY_CHECKS = 1;
 
 BEGIN
    -- Recuperation en cas d'exception
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
      -- Annuler la transaction
      ROLLBACK;
      SHOW ERRORS;
    END;
    START TRANSACTION;
    
    
    #classes
	 INSERT INTO class (class_id, name) VALUES 
		(1, 'SE Spring 2017'),
		(2, 'SS Spring 2016'); 
	 
	 #users, trainers
	 INSERT INTO user (user_id, email, pwd, name, first_name) VALUES 
		(1, 'karel.kk@gmail.com', '1234','Mracek', 'Karel'),
		(2, 'bbbb@gmail.com', '5678','Brown', 'Barbsina');
	 
	 #trainer = user-evaluation relation
	 INSERT INTO trainer (user_id) VALUES 
		(1),
		(2);
	 
	 #users, students
	 INSERT INTO user (user_id, email, pwd, name, first_name) VALUES 
		(3,  'annak@outlook.com', 'abcd','Pavkova', 'Anna'),
		(4,  'centaj@gmail.com', '1234','Centa', 'Juan'),
		(5,  'love.me.tender@gmail.com', '1234','Juan', 'Don'),
		(6,  'vagararar@gmail.com', '1234','Prassad', 'Vagarandra'),
		(7,  'l.maupa@seznam.cz', '5678','Bobes', 'Loraine'),
		(8,  'ninoska.chuettek@gmail.com', '1234','Chuette', 'Ninoska');
	 
	 #class-user relation = class members
	 INSERT INTO class_member (user_id, class_id) VALUES 
		(3,1),
		(4,1),
		(5,1),
		(6,2),
		(7,2),
		(8,2);
	 
	 #quiz
	 INSERT INTO quiz (quiz_id, title, db_name, diagram_path, creation_script_path) VALUES 
		(1, 'Basic syntax', 'TEST_DBS','C:\path\syntax.png', 'C:\path\TEST_DBS'),
		(2, 'Triggers, procedures and functions', 'TEST_DBS','C:\path\trigs.png', 'C:\path\TEST_DBS');
     
     #evaluation
	 INSERT INTO evaluation (evaluation_id,scheduled_at, ending_at, nb_minutes, class_id, trainer_id, quiz_id, completed_at)  VALUES 
		(1,'2017-06-25 16:03:34','2018-06-30 18:03:34',60, 1, 1, 1, '2018-06-30 22:03:34'), 
		(2,'2017-06-15 16:03:34','2018-06-20 18:03:34',60, 1, 1, 2,  '2018-06-21 16:03:34');
        
	 #test = user-evaluation
	 INSERT INTO test (student_id, evaluation_id, started_at, completed_at, validated_at) VALUES
		(3,1,'2017-06-26 16:03:34','2018-06-26 17:02:34','2018-06-27 16:03:34'),
		(6,1,'2017-06-26 16:04:15','2018-06-26 16:32:34','2018-06-27 16:13:34'),
		(7,1,'2017-06-26 16:03:34','2018-06-26 17:15:34','2018-06-27 16:23:34');
	 

	 
	 #sql-question
	INSERT INTO sql_question (question_id, question_text, correct_answer) VALUES 
		(1,  'Pilots with a bonus','SELECT * FROM pilot WHERE bonus IS NOT NULL;'),
		(2,  'Pilots whose salary + bonus is between 6500 et 7000 € (limits included)', 'SELECT * FROM pilot WHERE salary + bonus BETWEEN 6500 AND 7000;'),
		(3, 'Pilots whose name contains a u (in uppercase ou lowercase)', 'SELECT * FROM pilot WHERE lower(name) LIKE "%u%"'),
		(4, 'Total number of pilots, and number of pilots with a bonus (in a single query)', 'SELECT COUNT(pilot_id) AS pilot_nb, COUNT(bonus) AS bonus_nb FROM pilot;'),
		(5, 'Number of flights by departure day (dd-mm-yyy) and hour (hh:mn) (GROUP BY)', 'SELECT date_format(leaving_at, ''%d-%m-%Y'') AS day, date_format(leaving_at, ''%H:%i'') AS hour, COUNT(*) AS flight_nb FROM flight GROUP BY day, hour;'),
		(6, 'Pilot name, plane model, departure date, departure and arrival airport id, sorted by pilot name and plane model (both in alphabetical order)',
		'SELECT name, model, leaving_at, from_airport_id, to_airport_id FROM flight f INNER JOIN pilot p ON f.pilot_id = p.pilot_id INNER JOIN plane pl ON f.plane_id = pl.plane_id ORDER BY name, model;'),
		(7, 'Departure and arrival city name, and departure date sorted by departure city name and arrival city name (both in alphabetical order)', 'SELECT name, model, leaving_at, from_airport_id, to_airport_id
		FROM flight f INNER JOIN pilot p ON f.pilot_id = p.pilot_id INNER JOIN plane pl ON f.plane_id = pl.plane_id ORDER BY name, model;'),
		(8, 'Pilots having the greatest salary (nested 1 value)', 'SELECT * FROM pilot WHERE salary = ( SELECT MAX(salary) FROM pilot );'),
		(9, 'Flights occuring at 12/04/2015 (nested query)', 'SELECT * FROM flight WHERE flight_id IN (SELECT flight_id FROM flight WHERE date(leaving_at) = "2015-04-12" );'),
		(10, 'Pilots having flown the same plane from the same airport as Mathieu Lenormand, including himself (nested queries)', 
		'SELECT * FROM pilot WHERE pilot_id IN (SELECT pilot_id FROM flight WHERE (from_airport_id, plane_id) IN (SELECT from_airport_id, plane_id FROM flight WHERE pilot_id IN 
        (SELECT pilot_id FROM pilot WHERE first_name="Mathieu" AND name="Lenormand")));'),
		(11,'Name and salary of pilots flying a A380 (nested query)', 'SELECT name, salary FROM pilot WHERE pilot_id IN 
        (SELECT pilot_id FROM flight WHERE plane_id IN ( SELECT plane_id FROM plane WHERE model="A380"));'),
        (12, 'Id, name and flight hour total number per pilot, those without flight excluded',
		'SELECT p.pilot_id, name, ROUND(SUM(TIMESTAMPDIFF(MINUTE, leaving_at, arriving_at))/60) AS nb_heures FROM pilot p
		INNER JOIN flight ON p.pilot_id = flight.pilot_id GROUP BY p.pilot_id, name;'),
		(13, 'City name, and number of flights leaving from it, including when there is none',
		'SELECT city.name, count(flight_id) as nb_flights FROM city INNER JOIN airport a ON city.city_id = a.city_id LEFT OUTER JOIN flight f
		ON f.from_airport_id = a.airport_id GROUP BY city.name;'),
		(14, 'Name and id of pilots having used at least 2 planes', 'SELECT p.pilot_id, name, COUNT(DISTINCT plane_id) AS nb_planes
		FROM pilot p INNER JOIN flight f ON p.pilot_id = f.pilot_id GROUP BY p.pilot_id, name HAVING nb_planes >= 2;'),
		(15, 'Id and name of pilots without flight (with HAVING)', 'SELECT p.pilot_id, name, COUNT(flight_id) AS nb_flights FROM pilot p
		LEFT OUTER JOIN flight f ON p.pilot_id = f.pilot_id GROUP BY p.pilot_id, name HAVING nb_flights = 0;');
	 
	 #quiz-question relation
	  INSERT INTO quiz_question (question_id, quiz_id, rank) VALUES 
		(1, 1, 1),
		(2, 1, 2),
		(3, 1, 3),
		(4, 1, 4),
		(5, 1, 5),
		(6, 2, 1),
		(7, 2, 2),
		(8, 2, 3),
		(9, 2, 4),
		(10, 2, 5);
	 
	  #quiz-question relation
	  INSERT INTO sql_answer (question_id, student_id, evaluation_id, query, is_validated, gives_correct_result) VALUES 
		(1, 3, 1, 'SELECT * from pilots', true, true),
		(2, 3, 1, '', true, true),
		(3, 3, 1, '', true, true),
		(4, 3, 1,  '', true, true),
		(5, 3, 1, '', true, true),
		(6, 3, 1, '', true, true),
		(7, 3, 1, '', true, true),
		(8, 3, 1, '', true, true),
		(9, 3, 1, '', true, true),
		(10, 3, 1, '', true, true),
		
		(1, 6, 1, '', true, true),
		(2, 6, 1, '', true, true),
		(3, 6, 1, '', true, true),
		(4, 6, 1, '', true, true),
		(5, 6, 1, '', true, true),
		(6, 6, 1, '', true, true),
		(7, 6, 1, '', true, true),
		(8, 6, 1, '', true, true),
		(9, 6, 1, '', true, true),
		(10, 6, 1, '', true, true),
		
		(1, 7, 1, '', true, true),
		(2, 7, 1, '', true, true),
		(3, 7, 1, '', true, true),
		(4, 7, 1, '', true, true),
		(5, 7, 1, '', true, true),
		(6, 7, 1, '', true, true),
		(7, 7, 1, '', true, true),
		(8, 7, 1, '', true, true),
		(9, 7, 1, '', true, true),
		(10, 7, 1, '', true, true);
 
	
	COMMIT;
    END;
END  $$