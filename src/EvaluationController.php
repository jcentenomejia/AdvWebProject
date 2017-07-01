<?php
/* Load the class accessing the DB */

require_once("EvaluationModel.php");


$id = 1; //default evaluation
$eval = null;

if (isset($_GET["eval_id"])){
  $id = $_GET["eval_id"];
  //do_isEmpty();
}

function do_get($id){
  //die('do get');

  try {
    /* Access the db with PDO and get one row by its id */
    $eval = EvaluationModel::getEvaluation($id);
    return $eval;

  } catch (PDOException $exc) {
    /* Each time we access a DB, an exception may occur */
    $msg = $exc->getMessage();
    $code = $exc->getCode();
    print "$msg (error code $code)";
    return null;
  }

}

$eval = do_get($id);

require("evaluationView.php");
?>
