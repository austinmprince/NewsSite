<?php 
  require 'database.php';
  session_start();

  // makes sure right user
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
     die("Request forgery detected");
  }

  // if text was entered
  if(isset($_POST['comment'])){
  	// get info passed from form
    $user_id = $_SESSION['user_id'];
  	$comment = (String) $_POST['comment'];
  	$story_id = (int) $_POST['story_id'];

    // add comment into DB
  	$stmt = $mysqli->prepare("insert into comments (comment, story_id, user_id) values (?, ?, ?)");
  	if(!$stmt){
      	printf("Query Prep Failed: %s\n", $mysqli->error);
        	exit;
      }
    $stmt->bind_param('sii', $comment, $story_id, $user_id);
    $stmt->execute();
    $stmt->close();
  }

  // send user back to story with new comment added
  header("Location: story.php?id=$story_id");
  exit();
 ?>