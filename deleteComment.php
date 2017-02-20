<?php 
  session_start();
  require 'database.php';
  
  // make sure right user
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
     die("Request forgery detected");
  }

  // get info passed from form
  $comment_id = $_POST['comment_id'];
  $story_id = $_POST['story_id'];

  // delete comment with specificed comment id
  $stmt= $mysqli->prepare("delete from comments where comment_id=?");
  $stmt->bind_param('s', $comment_id);
  $stmt->execute();
  $stmt->close();

  // bring user back to story with deleted comment
  header("Location: story.php?id=$story_id");
  exit();
 ?>