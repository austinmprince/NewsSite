<?php 
echo 'hello';
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }

  $stmt->prepare("delete from comments where comment_id = $comment_id");
  $stmt->execute();
  $stmt->close();
 ?>