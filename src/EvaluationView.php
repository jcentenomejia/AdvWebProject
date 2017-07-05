<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuizApp - evaluation</title>
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        body { background: url(assets/bglight.png); }
        .hero-unit { background-color: #fff; }
        .center { display: block; margin: 0 auto; }
    </style>
</head>
<body>
  <div class="container">
  <h1>Evaluation</h1></hr>
  <h3><?php session_start();echo $_SESSION["user_first_name"]?></h3>
  </br>
  <div><a href="logout.php">Log Out</a></div>
  </br>
  <form method="post" action="QuestionController.php"> 
      
	  <p><b>Class : </b><?=$eval["class_name"]?></p>
		<input type="hidden" name="eval_id" value="<?=$eval["evaluation_id"]?>" />
		<input type="hidden" name="eval_min" value="<?=$eval["real_nb_minutes"]?>"/>
		  <p><b>Name of evaluation : </b><?=$eval["title"]?></p>
		  <p><b>Trainer : </b><?=$eval["trainer"]?></p>
		  <p><b>Start time : </b><?=$eval["scheduled_at"]?></p>
		  <p><b>Time in minutes: </b><?=$eval["nb_minutes"]?></p>
		  
      <button type="submit"  id="eval_button" class="btn btn-success active" >Start Test</button>
		
		</form>
		</div>

		</body>
	</html>
</body>
</html>
