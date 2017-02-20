<?php
require 'database.php';
if(!isset($_SESSION)){
  session_start();
}

// makes sure right user
if(!hash_equals($_SESSION['token'], $_POST['token'])){
   die("Request forgery detected");
}

// if there's no text in text box, go back to edits page
if (empty($_POST['new_comment'])) {
  header("refresh:2; url=editComment.php");
  echo "Please make sure fields are not empty to succesfully edit story";
  exit;
}else{
	// get edited comment and it's comment_id and story_id
	$new_comment = (String) $_POST['new_comment'];
	$comment_id= (int) $_POST['comment_id'];
	$story_id= (int) $_POST['story_id'];
}

// update database at specified comment_id with new comment
$stmt=$mysqli->prepare('update comments set comment=? where comment_id=?');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('si', $new_comment, $comment_id);
$stmt->execute();
$stmt->close();

// send user back to story with edited comment
header("Location: story.php?id=$story_id");
exit();
 ?>

