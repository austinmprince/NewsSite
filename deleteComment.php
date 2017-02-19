<?php 
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }
  $comment_id = $_POST['comment_id'];
  $story_id = $_POST['story_id'];
  $stmt= $mysqli->prepare("delete from comments where comment_id=?");
  $stmt->bind_param('s', $comment_id);
  $stmt->execute();
  $stmt->close();

  header("Location: story.php?id=$story_id");
  exit();
 ?>