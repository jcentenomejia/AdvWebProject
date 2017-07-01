<?php

require_once("connection.php");

/** Access to the evaluation table.
 * Put here the methods like getBySomeCriteriaSEarch */
class EvaluationModel {


    public static function getEvaluation($evaluationId) {
        $db = Connection::getConnection();
        $sql = "select evaluation_id,scheduled_at, nb_minutes, quiz.title,class.name as class_name, concat(user.first_name, ' ',user.name) as trainer from evaluation as eval
		inner join class on eval.class_id = class.class_id
		inner join quiz on eval.quiz_id = quiz.quiz_id
		inner join user on eval.trainer_id = user.user_id where evaluation_id= :eval_id ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":eval_id", $evaluationId);
        $ok = $stmt->execute();
        $result = null;
        if ($ok) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        else {
          return die(404);
        }
    }
}

?>
