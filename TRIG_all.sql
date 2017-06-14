delimiter $$
drop trigger if exists prevent_soon_start$$
CREATE trigger `prevent_soon_start` 
before insert on sql_quiz.test
for each row
BEGIN
	declare start_time datetime;
    declare msg varchar(100);
    
    select scheduled_at into start_time from evaluation where evaluation_id = new.evaluation_id;
    
    if new.started_at > start_time then
		set msg = concat("It is too soon to start the test. Start time: ",start_time);
        signal sqlstate '45000'
        set MESSAGE_TEXT = msg, MYSQL_ERRNO=3001;
    end if;
END$$

delimiter $$
drop trigger if exists prevent_soon_ending_of_evaluation_before_update$$
CREATE trigger `prevent_soon_ending_of_evaluation_before_update` 
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
