<?php

/* Load the class accessing the DB */
require_once("AnswerModel.php");
require_once("TestModel.php");
session_start();

$test_id = 1;
$result = null;
$user_id = 0;

if (isset($_POST["eval_id"])){
	
	$test_id = $_POST["eval_id"];
	$user_id = $_SESSION["user_id"];
	$message = TestModel::insertTest($test_id,$user_id);
	echo "$message user id: $user_id test: $test_id";
	
}

function do_get($test_id){

  try {
    /* Access the db with PDO and get one row by its id */
	
    //$result = AnswerModel::getAnswers($test_id, $user_id);
	
    //return $result;

  } catch (PDOException $exc) {
    /* Each time we access a DB, an exception may occur */
    $msg = $exc->getMessage();
    $code = $exc->getCode();
    print "$msg (error code $code)";
    //return null;
  }
}

$result = do_get($test_id);
$size = sizeOf($result);

for($i =0; $i ++; $i < $size){
	echo "$result[question_text]";
}
//require("QuestionView.php");
?>
