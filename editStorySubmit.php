<?php
require 'database.php';
if(!isset($_SESSION)){
  session_start();
}
if(!hash_equals($_SESSION['token'], $_POST['token'])){
   die("Request forgery detected");
}
if (empty($_POST['storyLink']) || empty($_POST['storyDescription']) || empty($_POST['storyTitle'])) {
  header("refresh:2; url=editStory.php");
  echo "Please make sure fields are not empty to succesfully edit story";
  exit;
}
else {
  $user_id = $_SESSION['user_id'];
  $storyLink = $_POST['storyLink'];
  $storyTitle = $_POST['storyTitle'];
  $stid = $_POST['stid'];
  $storyDescription = $_POST['storyDescription'];
  if ($_POST['category'] == "Add new category") {
    $category = $_POST['addOption'];
    echo "Add new category";
    echo $category;
  }
  else {
    $category = $_POST['category'];
    echo "existing category";
    echo $category;
  }
  $stmt = $mysqli->prepare("update stories set story_link=?, title=?, description=?, category=? where story_id=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('ssssi', $storyLink, $storyTitle, $storyDescription, $category, $stid);
  $stmt->execute();
  $stmt->close();
  header("Location: viewStories.php");
  exit;
}



?>
