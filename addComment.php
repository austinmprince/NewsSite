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
	$stmt = $mysqli->prepare("insert into comments (comment, story_id, user_id) values(?, ?, ?)");
	if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
      	exit;
    }

    $stmt->bind_param('sss', $comment, $story_id, $user_id);
    $stmt->execute();
    $stmt->close();
}
header("Location: story.php");
exit();

 ?>