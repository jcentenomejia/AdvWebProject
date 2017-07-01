<?php

require_once("connection.php");
require_once("EvaluationModel.php");

class TestModel {

    public static function getTest($eval_id) {
        $db = Connection::getConnection();
        $sql = "select * from test where evaluation_id= :eval_id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":eval_id", $eval_id);
        $ok = $stmt->execute();
        $result = null;
        if ($ok) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
}

?>
