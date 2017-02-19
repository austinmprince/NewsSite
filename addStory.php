
<?php
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }


  if (empty($_POST['storyLink']) || empty($_POST['storyDescription']) || empty($_POST['storyTitle'])) {
    header("refresh:2; url=viewStories.php");
    echo "Please input all fields to add a story to the feed";
    exit;
  }
  else {
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
    header("Location: storyManage.php");
    exit;
  }



 ?>
