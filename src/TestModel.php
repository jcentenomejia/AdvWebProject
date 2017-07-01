<?php

require_once("connection.php");

class TestModel {

    
    public static function getTest($testID, $student_id) {
        $db = Connection::getConnection();
        $sql = "select * from test where evaluation_id = :eval_id and student_id = :student_id ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":eval_id", $testID);
		$stmt->bindValue(":student_id", $student_id);
        $ok = $stmt->execute();
        $result = null;
        if ($ok) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
	
	public static function insertTest($testID,$student_id) {
        $result = "error creating test";
		$db = Connection::getConnection();
        $sql = "insert into test (student_id,evaluation_id,started_at) values( :student_id, :eval_id, now()) ";
		
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":eval_id", $testID);
		$stmt->bindValue(":student_id", $student_id);
        $ok = $stmt->execute();
        $result = null;
        if ($ok) {
            $result = "new test";
			//echo "new test";
        }
		return $result;
    }
}

?>
