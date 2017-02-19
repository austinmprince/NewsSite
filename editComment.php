<!DOCTYPE html>
<html>
<head>
	<title>Edit Comment</title>
</head>
<body>
	<form action='editCommentSubmit.php' method='post'>

	<?php 
		require 'database.php';
	  	session_start();
	  	if(!hash_equals($_SESSION['token'], $_POST['token'])){
		   	die("Request forgery detected");
	  	}
	  	$comment_id = $_POST['comment_id'];
	  	$stmt=$mysqli->prepare('select comment from comments where comment_id=?');
	  	$stmt->bind_param('i',$comment_id);
	  	$stmt->execute();
	  	$stmt->bind_result($comment);
	  	$stmt->fetch();
	  	$stmt->close();
	 ?>
	Comment: <br/>
    <textarea name='new_comment' style='height:200px;width:300px'><?php printf(trim(htmlspecialchars($comment)));?></textarea><br>
    <input type='Submit' name='submit' value='Post Comment'>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="hidden" name="comment_id" value="<?php echo $comment_id;?>"/>
  </form>

</body>
</html>
