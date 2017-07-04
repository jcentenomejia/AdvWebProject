<?php

/* Load the class accessing the DB */
require_once("AnswerModel.php");
require_once("TestModel.php");
session_start();

$test_id = 1;
$answers = null;
$user_id = 0;

if (isset($_POST["eval_id"])){
	
	$test_id = $_POST["eval_id"];
	$user_id = $_SESSION["user_id"];
	$message = TestModel::insertTest($test_id,$user_id);
	
}

try {
    /* Access the db with PDO and get one row by its id */
    $answers = AnswerModel::getAnswers($test_id, $user_id);
    
} catch (PDOException $exc) {
    /* Each time we access a DB, an exception may occur */
    $msg = $exc->getMessage();
    $code = $exc->getCode();
    print "$msg (error code $code)";
}

$questionCount = sizeOf($answers);
/*
function getAnswer($index){
	global $answers;
	return $answers[$index];
}*/

//echo $answers[0]["question_text"];
/*
foreach($answers as $answer) {
    echo "question id: $answer[question_id] text: $answer[question_text] <br>";
}*/

require("QuestionView.php");
?>
