<!DOCTYPE html>
<html>
<head>
	<title>Edit Comment</title>
</head>
<body>
	<form>
		<!-- back button -->
  		<input type="button" value="Back" onClick="history.go(-1);return true;">
  	</form>
  	<!-- form to edit comment -->
	<form action='editCommentSubmit.php' method='post'>

	<?php 
		session_start();
		require 'database.php';

		// make sure right user
	  	if(!hash_equals($_SESSION['token'], $_POST['token'])){
		   	die("Request forgery detected");
	  	}

	  	// get info passed from form
	  	$comment_id = $_POST['comment_id'];

	  	// get specified comment from specified story
	  	$stmt=$mysqli->prepare('select comment, story_id from comments where comment_id=?');
	  	$stmt->bind_param('i',$comment_id);
	  	$stmt->execute();
	  	$stmt->bind_result($comment, $story_id);
	  	$stmt->fetch();
	  	$stmt->close();
	 ?>
	<!-- comment box with text that needs to be edited -->
	Comment: <br/>
    <textarea name='new_comment' style='height:200px;width:300px'><?php printf(trim(htmlspecialchars($comment)));?></textarea><br>
    <input type='Submit' name='submit' value='Post Comment'>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="hidden" name="comment_id" value="<?php echo $comment_id;?>"/>
    <input type="hidden" name="story_id" value="<?php echo $story_id;?>"/>
  </form>
</body>
</html>
