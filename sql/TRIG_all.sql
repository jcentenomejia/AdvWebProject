delimiter $$
drop trigger if exists prevent_soon_start$$
CREATE trigger `prevent_soon_start` 
before insert on sql_quiz.test
for each row
BEGIN
	declare start_time datetime;
    declare end_time datetime;
    declare msg varchar(100);
    
    select scheduled_at into start_time from evaluation where evaluation_id = new.evaluation_id;
    
    if new.started_at < start_time then
		set msg = concat("It is too soon to start the test. Start time: ",start_time);
        signal sqlstate '45000'
        set MESSAGE_TEXT = msg, MYSQL_ERRNO=3001;
    end if;
    
    select ending_at into end_time from evaluation where evaluation_id = new.evaluation_id;
    
    if new.started_at > end_time then
		set msg = concat("It is too late to start the test. End time: ",start_time);
        signal sqlstate '45000'
        set MESSAGE_TEXT = msg, MYSQL_ERRNO=3009;
    end if;
END$$

delimiter $$
drop trigger if exists prevent_soon_ending_of_evaluation_before_update$$
CREATE trigger `prevent_soon_ending_of_evaluation_before_update` 
before update on sql_quiz.evaluation
for each row
BEGIN
	
    declare msg varchar(100);
    
    if TIMESTAMPDIFF(SECOND, new.scheduled_at, new.ending_at) < new.nb_minutes*60 then
		set msg = concat("Try a new ending time for the evaluation, minutes given ",new.nb_minutes);
        signal sqlstate '45000'
        set MESSAGE_TEXT = msg, MYSQL_ERRNO=3002;
    end if;
END$$

delimiter $$
drop trigger if exists prevent_soon_ending_of_evaluation_before_insert$$
CREATE trigger `prevent_soon_ending_of_evaluation_before_insert` 
before insert on sql_quiz.evaluation
for each row
BEGIN
	
    declare msg varchar(100);
    
    if TIMESTAMPDIFF(SECOND, new.scheduled_at, new.ending_at) < new.nb_minutes*60 then
		set msg = concat("Try a new ending time for the evaluation, minutes given ",new.nb_minutes);
        signal sqlstate '45000'
        set MESSAGE_TEXT = msg, MYSQL_ERRNO=3002;
    end if;
END$$

delimiter $$
drop trigger if exists prevent_answer_out_of_evaluation_time$$
CREATE trigger `prevent_answer_out_of_evaluation_time` 
before update on sql_quiz.sql_answer
for each row
BEGIN
	declare start_time datetime;
    declare ending_time datetime;
    declare msg varchar(100);
    
    select scheduled_at into start_time from evaluation where evaluation_id = new.evaluation_id;

    if now() < start_time then
		set msg = concat("It is too soon to answer questions. Start time: ",start_time);
        signal sqlstate '45000'
        set MESSAGE_TEXT = msg, MYSQL_ERRNO=3003;
    end if;
    
    select ending_at into ending_time from evaluation where evaluation_id = new.evaluation_id;
    
    if now() > ending_time then
		set msg = concat("It is too late to answer questions. End time: ",ending_time);
        signal sqlstate '45000'
        set MESSAGE_TEXT = msg, MYSQL_ERRNO=3004;
    end if;
END$$

delimiter $$
drop trigger if exists create_test_empty_answers$$
CREATE trigger `create_test_empty_answers` 
after insert on sql_quiz.test
for each row
BEGIN
    
    insert into sql_answer(question_id,student_id,evaluation_id,query)
		select id, new.student_id, new.evaluation_id, '' 
        from 
        (
			select question_id id 
            from quiz_question 
            where quiz_id = 
			(
				select quiz_id 
                from evaluation 
                where evaluation_id = new.evaluation_id
			)
		) as questions;
    
END$$