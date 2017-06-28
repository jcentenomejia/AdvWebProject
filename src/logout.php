<?php
    session_start();
    require_once("PersonModel.php");

    unset($_SESSION['user']);
    header("Location: index.php");
    $msg = urlencode("User successfully logged out.");
    header("Location:index.php?logoutmsg=".$msg);
    session_destroy();
    die("Redirecting to: index.php");
?>
