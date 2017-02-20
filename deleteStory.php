<?php
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }
  // Get the name of the file
  $file_name = (String)$_POST['name'];
  // First we delete all the comments that are associated with our given story
  $stmt = $mysqli->prepare("delete from comments where story_id=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('s', $file_name);
  $stmt->execute();
  $stmt->close();
  // Then we delete the actual story itself
  $stmt = $mysqli->prepare("delete from stories where story_id=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('s', $file_name);
  $stmt->execute();
  $stmt->close();
  header("refesh:1; url=viewStories.php");
  exit;
?>
