<?php
require_once("PersonModel.php");
session_start();

// login = user's email
//if (isset($_SESSION["user_email"])) {
//  print "Your are logged as  $_SESSION[user_first_name] $_SESSION[user_name].";

//}
//else {
    //POST method by default
    if(isset($_POST['login_button']))
    {
      $login = trim($_POST['user_email']);
      $pwd = trim($_POST['user_pwd']);
    }
  		try {
  		  /* Access the db with PDO and get login and password*/
  		  $session_user = PersonModel::authenticate($login,$pwd);
        //check if authenticated
        if(empty($session_user))
        {
          echo "<p>Authentication failed. Unknown user.</p>";
          $msg = urlencode("Authentication failed. Unknown user.");
          header("Location:index.php?wmsg=".$msg);
          die("Redirecting to: index.php");

        }
        else {
          $_SESSION["user_first_name"] = $session_user["first_name"];
          $_SESSION["user_name"] = $session_user["name"];
          $_SESSION["user_email"] = $session_user["email"];
          $_SESSION["user_id"] = $session_user["user_id"];

          echo "<p>User $_SESSION[user_first_name] $_SESSION[user_name] has successfully logged in.</p>";
          header("Location:main.php");
          die("Redirecting to: main.php");
        }
  		} catch (PDOException $exc) {
  		  /* Each time we access a DB, an exception may occur */
  		  $msg = $exc->getMessage();
  		  $code = $exc->getCode();
  		  print "$msg (error code $code)";
  		//}
 }
?>
