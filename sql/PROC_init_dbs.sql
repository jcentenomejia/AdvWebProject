userDELIMITER $$

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
		(1, 'Select all the pilots in table pilots.', ''),
		(2, '', ''),
		(3, '', ''),
		(4, '', ''),
		(5, '', ''),
		(6, '', ''),
		(7, '', ''),
		(8, '', ''),
		(9, '', ''),
		(10, '', '');
	 
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