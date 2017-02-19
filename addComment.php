<?php 
require 'database.php';
session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
   die("Request forgery detected");
}

if(isset($_POST['comment'])){
	$user_id = $_SESSION['user_id'];
	$comment = $_POST['comment'];
	$story_id = $_POST['story_id'];
  echo $user_id;
  echo $comment;
  echo $story_id;
	$stmt = $mysqli->prepare("insert into comments (comment, story_id, user_id) values (?, ?, ?)");
	if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
      	exit;
    }

    $stmt->bind_param('sii', $comment, $story_id, $user_id);
    $stmt->execute();
    $stmt->close();
}
header("Location: story.php?id=$story_id");
exit();

 ?>