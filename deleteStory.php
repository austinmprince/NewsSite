<?php
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }
  $file_name = $_POST['value'];
  echo $file_name;
  $stmt->prepare("delete from stories where story_id=value");
  $stmt->execute();
  $stmt->close();

  ?>
