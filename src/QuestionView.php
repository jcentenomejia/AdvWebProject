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
  <ul class="pagination pagination-lg">
   <li><a href="#">&laquo;</a></li>
  <?php
  $questionCount = 20;
  for ($i=1 ; $i <= $questionCount ; $i++) {
  	print "<li><a href='#question$i'>$i</a></li>";
  }
  ?>
    <li><a href="#">&raquo;</a></li>
  </ul>
  <form class="form-signin" action="AnswerController.php" method="post" id="question_form">
      <h2 class="form-signin-heading">Question</h2>
      </br>

     <div class="form-group">
       <label for="question" class="control-label">Text of the question</label>
       <textarea name="answer_text" id="answer_text" type="text" class="form-control" placeholder="Your answer..." required="required"/></textarea>
     </div>
     <div class="form-group">
         <button name="question_button" id="question_button" type="submit" class="btn btn-primary active">Validate</button>
     </div>
  </form>
</body>
</html>
