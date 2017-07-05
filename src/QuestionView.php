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

		 li.selected {
			color: green;
			background-color: green;
		}
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript">
		var index = 0;
		var answers = <?php echo json_encode($answers);?>;
		var arrSize = <?php echo $questionCount;?>;

		function submitAnswer(){
			var question_id = answers[index]["question_id"];
			var eval_id = answers[index]["evaluation_id"];
			var user_id = <?php echo $_SESSION["user_id"];?>;
			var query = $("#answer_text").val();
			var action = "update";
			//alert("student id: " + user_id + " \neval id: " + eval_id + "\nquery : " + query + "\nquestion id : " + question_id);
			$.ajax({
					url: "AnswerController.php",
					data: {
						eval_id:eval_id, question_id: question_id, user_id: user_id , action: action, query: query
					},
					type:'POST',
					//dataType: "json",
					success: function(result){

					//alert(result);
				},error: function(x, t, m) {
					alert(t);
				}
			});
		};
		function updateQuestion(id){
			index = id;
			var question_id = answers[id]["question_id"];
			var eval_id = answers[id]["evaluation_id"];
			var user_id = <?php echo $_SESSION["user_id"];?>;
			var action = "get";
			$.ajax({
					url: "AnswerController.php",
					data: {
						eval_id:eval_id, question_id: question_id, user_id: user_id , action: action
					},
					type:'POST',
					dataType: "json",
					success: function(result){

					$("#question_text").text(answers[index]['question_text']) ;
					$("#answer_text").text(result['query']);

				},error: function(x, t, m) {
					alert(t);
				}
			});

		};
		function updateQuestionM(){
			if(index > 0){
				index --;
				updateQuestion(index);
			}
		};
		function updateQuestionP(){
			if(index < arrSize-1){
				index ++;
				updateQuestion(index);
			}
		};
		var $li = $('#nav a').click(function() {
			$li.removeClass('selected');
			$(this).addClass('selected');
		});

	</script>
</head>
<body>
  <div class="container">
      <h2 class="form-signin-heading">Question</h2>
      </br>

     <div class="form-group">
       <label for="question" class="control-label" id="question_text"><?=$answers[0]["question_text"]?></label>
       <textarea name="answer_text" id="answer_text" type="text" class="form-control" placeholder="Your answer..." required="required"/></textarea>
     </div>
     <div class="form-group">
         <button name="question_button" id="question_button" class="btn btn-primary active" onclick="submitAnswer()">Validate</button>
     </div>

	 <div class="tabbable">
	 <ul class="nav nav-tabs" id="nav">
	   <li><a onclick="return updateQuestionM()">&laquo;</a></li>
	  <?php
	  for ($i=0 ; $i < $questionCount ; $i++) {
	  ?>
		<li><a onclick="return updateQuestion(<?=$i?>)"><?=($i+1)?></a></li>
	  <?php
	  }
	  ?>
		<li><a onclick="return updateQuestionP()">&raquo;</a></li>
	  </ul>
	  </div>

  </div>
</body>
</html>
