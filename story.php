<!DOCTYPE html>
<html>
<head>
	<title>A Story</title>
</head>
<body>



</body>
</html>

<?php 
session_start();
$story_id = $_GET['id'];
require 'database.php';
$stmt = $mysqli->prepare("select title, description from stories where story_id=$story_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$result = $stmt ->get_result();
while($row = $result->fetch_assoc()){
	printf('<h1>%s</h1>', $row['title']);
	printf('<p>%s</p>', $row['description']);

}

printf('<h4>Comments</h4>');
$stmt = $mysqli->prepare("select comments.comment, users.username, comments.comment_id from comments join users on (comments.user_id=users.user_id) where story_id=$story_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$result = $stmt ->get_result();
while($row = $result->fetch_assoc()){
	$return[] = $row;
	printf('<p>%s:<br>%s</p>', $row['username'], $row['comment']);
	//add something that makes it only possible for user who posted it
	printf("
		<form action='deleteComment.php' method='post'>
		<input type='Submit' name='submit' value='Delete Comment'>
		<input type='hidden' name='comment_id' value='%s'>
		<input type='hidden' name='token' value='%s'>
		<input type='hidden' name='story_id' value='%s'>
		</form>
		", $row['comment_id'], $_SESSION['token'], $story_id);
}
 ?>

  <form action='addComment.php' method='post'>
	Comment: <br/>
    <textarea name='comment' style='height:200px;width:300px'></textarea><br>
    <input type='Submit' name='submit' value='Post Comment'>
    <input type="hidden" name="token" value="<?php session_start(); echo $_SESSION['token'];?>" />
    <input type="hidden" name="story_id" value="<?php echo $_GET['id'];?>"/>
  </form>
  </body>
</html>