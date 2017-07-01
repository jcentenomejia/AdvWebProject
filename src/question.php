<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuizApp - question</title>
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
  <h1>Hovnoooooo</h1>
  <?php

	/* Load the class accessing the DB */
  require_once("TestModel.php");

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
		  $eval = TestModel::getTest($id);

		} catch (PDOException $exc) {
		  /* Each time we access a DB, an exception may occur */
		  $msg = $exc->getMessage();
		  $code = $exc->getCode();
		  print "$msg (error code $code)";
		}
  }
		?>

</body>
</html>
