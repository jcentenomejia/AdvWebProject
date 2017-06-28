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
  <div><a href="logout.php">Log Out</a></div>
  <?php

	/* Load the class accessing the DB */
	require_once("EvaluationModel.php");

	?>
	
	<?php

	if (isset($_GET["eval_id"])){
		$id = $_GET["eval_id"];
		do_get($id);
	}else{
		do_get(1); //default evaluation
		//do_isEmpty();
	}

	function do_get($id){
		//die('do get');
		
		try {
		  /* Access the db with PDO and get one row by its id */
		  $eval = EvaluationModel::getEvaluation($id);
		  
		} catch (PDOException $exc) {
		  /* Each time we access a DB, an exception may occur */
		  $msg = $exc->getMessage();
		  $code = $exc->getCode();
		  print "$msg (error code $code)";
		}
		
		?>
			
		<p><b>Class : </b><?=$eval["class_name"]?></p> 
		  <p><b>Name of evaluation : </b><?=$eval["title"]?></p> 
		  <p><b>Trainer : </b><?=$eval["trainer"]?></p> 
		  <p><b>Start time : </b><?=$eval["scheduled_at"]?></p> 
		  <p><b>Time in minutes: </b><?=$eval["nb_minutes"]?></p> 
		  <button onclick="location.href='google.com'">Start test</button>       
		</div>

		</body>
	</html>
	
	<?php
	}

	function do_isEmpty(){
		
		?>
		<p>Please select an evaluation</p> 
			</div>

			</body>
		</html>

	<?php
	}

	?>
</body>
</html>
