<!DOCTYPE html>
<html>
<head>
	<title>A Story</title>
</head>
<body>
	<form action="viewStories.php">
  		<input type="submit" value="Back">
  	</form>
<?php 
session_start();
$story_id = $_GET['id'];
require 'database.php';

// get title, description, link from DB to corresponding story id
$stmt = $mysqli->prepare("select title, description, story_link from stories where story_id=$story_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$result = $stmt ->get_result();

// set title, description and link
while($row = $result->fetch_assoc()){
	printf('<h1>%s</h1>', $row['title']);
	printf("<a href=%s>Link</a>", $row['story_link']);
	printf('<p>%s</p>', $row['description']);

}

// get comments for corresponding story id
printf('<h4>Comments</h4>');
$stmt = $mysqli->prepare("select comments.comment, users.username, comments.comment_id from comments join users on (comments.user_id=users.user_id) where story_id=$story_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$result = $stmt ->get_result();

// show comments from usernames for this story
while($row = $result->fetch_assoc()){
	printf('<p>%s:<br>%s</p>', $row['username'], $row['comment']);
	
	// makes it only possible for user who posted it to edit and delete
	if($row['username'] == $_SESSION['username']){
		printf("
		<form action='deleteComment.php' method='post'>
		<input type='Submit' name='submit' value='Delete Comment'>
		<input type='hidden' name='comment_id' value='%s'>
		<input type='hidden' name='token' value='%s'>
		<input type='hidden' name='story_id' value='%s'>
		</form>
		", $row['comment_id'], $_SESSION['token'], $story_id);
	printf("
		<form action='editComment.php' method='post'>
		<input type='Submit' name='submit' value='Edit Comment'>
		<input type='hidden' name='comment_id' value='%s'>
		<input type='hidden' name='token' value='%s'>
		</form>
		", $row['comment_id'], $_SESSION['token']);
	}
}
 ?>

 <!-- comment box to post comments-->
  <form action='addComment.php' method='post'>
	Comment: <br/>
    <textarea name='comment' style='height:200px;width:300px'></textarea><br>
    <input type='Submit' name='submit' value='Post Comment'>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="hidden" name="story_id" value="<?php echo $_GET['id'];?>"/>
  </form>
  </body>
</html>