
<?php
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }

  if (isset($_POST['storyLink']) && isset($_POST['storyDescription']) && isset($_POST['storyTitle'])) {
    $user_id = $_SESSION['user_id'];
    $storyLink = $_POST['storyLink'];
    $storyTitle = $_POST['storyTitle'];
    $storyDescription = $_POST['storyDescription'];
    $stmt = $mysqli->prepare("insert into stories (user_id, story_link, title, description) values (?, ?, ?, ?)");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('ssss', $user_id, $storyLink, $storyTitle, $storyDescription);
    $stmt->execute();
    $stmt->close();
  }
  header("Location: storyManage.php");
  exit;
  
 ?>
