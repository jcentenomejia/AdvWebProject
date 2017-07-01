<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuizApp - login</title>
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
  <div class="signin-form">
     <div class="container">
           <form class="form-signin" form action="LoginController.php" method="post" id="login_form">

            <h2 class="form-signin-heading">Log in to QuizApp.</h2>
            </br>
            <?php
            if(isset($_GET['wmsg'])){
              echo "<div class='alert alert-warning'>
                <strong>Warning ! </strong>". $_GET["wmsg"] ."</div>";
            }
            if(isset($_GET['logoutmsg'])){
                  echo "<div class='alert alert-success'>
                    <strong>Success ! </strong>". $_GET["logoutmsg"] ."</div>";
            }
            ?>

            <div class="form-group">
              <input name="user_email" id="user_email" type="email" class="form-control" placeholder="Email address" required="required"/>
              <span id="check-e"></span>
            </div>

            <div class="form-group">
              <input name="user_pwd" id="user_pwd" type="password" class="form-control" placeholder="Password" />
            </div>

          <hr />

            <div class="form-group">
                <button name="login_button" id="login_button" type="submit" class="btn btn-primary active"><span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In</button>
            </div>

          </form>

        </div>

  </div>
</body>
</html>
