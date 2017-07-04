<?php

require_once("AnswerModel.php");

if(isset($_POST['action']))
{
  $action = $_POST['action'];
  
  if($action == "get"){
	  $question_id = $_POST['question_id'];
	  $eval_id = $_POST['eval_id'];
	  $user_id = $_POST['user_id'];
	  $question = AnswerModel::getQuestionAnswer($eval_id, $user_id, $question_id);
	  
	  $result = json_encode($question);
	  
	  echo $result;
  }
  if($action == "update"){
	  $question_id = $_POST['question_id'];
	  $eval_id = $_POST['eval_id'];
	  $user_id = $_POST['user_id'];
	  $query = $_POST['query'];
	  
	  
	  AnswerModel::updateAnswer($question_id,$user_id,$eval_id,$query);
	  
	  //echo json_encode($res);
	}
}


?>
