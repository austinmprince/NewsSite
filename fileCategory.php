<?php
  require 'database.php';
  session_start();
  $category = $_GET['id'];
  $stmt = $mysqli->prepare("select story_link, title, description, story_id from stories where category='$category'
   order by story_id");
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }
  $stmt->execute();

  $result = $stmt->get_result();

  echo "<ul>\n";
  while($row = $result->fetch_assoc()){
  	printf("<a href='%s'> %s </a><br>", $row["story_link"], $row["title"]);
    printf("%s<br>", $row["description"]);

  }
  printf("<form action='viewStories.php' method='post'>");
  printf("<input type='Submit' value='Return to Main' name='Submit'><br>");

  if (isset($_SESSION['username']) && $_SESSION['username'] != "guest") {
    printf("<form action='storyManage.php' method='post'>");
    printf("<input type='submit' value='Manage stories' name='Submit'><br></form>");
    printf("<form action='logout.php' method='post'>");
    printf("<input type='submit' value='Logout' name='Submit'></form>");

  }

$stmt->close();
