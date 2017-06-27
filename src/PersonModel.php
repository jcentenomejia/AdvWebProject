<?php

require_once("connection.php");

/** Access to the person table.
 * Put here the methods like getBySomeCriteriaSEarch */
class PersonModel {

    /** Get person data for id $personId
     * (here demo with a SQL request about an existing table)
     * @param int $personId id of the quizz to be retrieved
     * @return associative_array table row
     */
	
    public static function getPerson($personId) {
        $db = Connection::getConnection();
        $sql = "select * from user where user_id= :person_id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":person_id", $personId);
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