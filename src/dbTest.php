<?php

/* Load the class accessing the DB */
require_once("PersonModel.php");
try {
  /* Access the db with PDO and get one row by its id */
  $person = PersonModel::getPerson(2);
  print "Person id: $person[user_id], name: $person[name]";
} catch (PDOException $exc) {
  /* Each time we access a DB, an exception may occur */
  $msg = $exc->getMessage();
  $code = $exc->getCode();
  print "$msg (error code $code)";
}

