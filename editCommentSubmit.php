<?php
require 'database.php';
if(!isset($_SESSION)){
  session_start();
}

if(!hash_equals($_SESSION['token'], $_POST['token'])){
   die("Request forgery detected");
}

if (empty($_POST['new_comment'])) {
  header("refresh:2; url=editComment.php");
  echo "Please make sure fields are not empty to succesfully edit story";
  exit;
}else{
	$new_comment = $_POST['new_comment'];
	$comment_id=$_POST['comment_id'];
	$story_id=$_POST['story_id'];
}

$stmt=$mysqli->prepare('update comments set comment=? where comment_id=?');
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('si', $new_comment, $comment_id);
$stmt->execute();
$stmt->close();

header("Location: story.php?id=$story_id");
exit();
 ?>

