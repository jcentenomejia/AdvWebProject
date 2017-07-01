<?php

require_once("connection.php");

/** Access to the test table.
 * Put here the methods like getBySomeCriteriaSEarch */
class AnswerModel {

    
    public static function getAnswers($eval_id, $student_id) {
        $db = Connection::getConnection();
        $sql = "select sql_answer.question_id, evaluation_id,question_text from sql_answer 
		inner join sql_question on sql_answer.question_id = sql_question.question_id
		where student_id = :student_id and evaluation_id = :eval_id ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":eval_id", $eval_id);
		$stmt->bindValue(":student_id", $student_id);
        $ok = $stmt->execute();
        $result = null;
        if ($ok) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
			//echo $result;
        }
        return $result;
    }
	
	public static function updateAnswer($question_id,$student_id,$eval_id,$query) {
        $db = Connection::getConnection();
        $sql = "update sql_answer set query = ':query' where question_id = :question_id and student_id = :student_id and evaluation_id = :eval_id ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":question_id", $question_id);
		$stmt->bindValue(":student_id", $student_id);
		$stmt->bindValue(":eval_id", $eval_id);
		$stmt->bindValue(":query", $query);
        $ok = $stmt->execute();
        $result = null;
        if ($ok) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
			//echo $result;
        }
        return $result;
    }
}

?>