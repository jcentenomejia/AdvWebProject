<?php

/* Load the class accessing the DB */
require_once("TestModel.php");

$id = 1;
$result = null;

if (isset($_GET["eval_id"])){
  $id = $_GET["eval_id"];
}

function do_get($id){
  //die('do get');

  try {
    /* Access the db with PDO and get one row by its id */
    $result = TestModel::getTest($id);
    return $result;

  } catch (PDOException $exc) {
    /* Each time we access a DB, an exception may occur */
    $msg = $exc->getMessage();
    $code = $exc->getCode();
    print "$msg (error code $code)";
    return null;
  }
}

$result = do_get($id);

require("QuestionView.php");
?>
