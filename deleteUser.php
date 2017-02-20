<?php
require 'database.php';
if(!isset($_SESSION)){
  session_start();
}

// makes sure right user
if(!hash_equals($_SESSION['token'], $_POST['token'])){
   die("Request forgery detected");
}

// get input from form
$user_id=(int)$_POST['user_id'];

//delete comments associated with this user
$stmt = $mysqli->prepare("delete from comments where user_id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->close();

//delete stories associated with this user
$stmt = $mysqli->prepare("delete from stories where user_id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}
$stmt->bind_param('i', $user_id);
$stmt->execute();

// delete user
$stmt = $mysqli->prepare("delete from users where user_id=?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->close();

session_destroy();
header("Location: entryPage.html");
exit();

?>
