<?php
  session_start();
  require 'database.php';
  if (isset($_POST['guest'])){
    if (!isset($_SESSION['username'])){
      $_SESSION['username'] = "guest";
    }
  }
  $cat =$mysqli->prepare("select distinct category from stories order by category");
  if(!$cat){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }
  $cat->execute();

  $result = $cat->get_result();
  printf("<h3>News categories</h3><br>");
  while($catrow = $result->fetch_assoc()){
  	printf("<a href='%s?id=%s'> %s </a><br>", 'fileCategory.php',$catrow["category"], $catrow["category"]);

  }
  $cat->close();

  // Code taken from course wiki
  $stmt = $mysqli->prepare("select story_link, title, description, story_id from stories order by story_id");
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }
  $stmt->execute();

  $result = $stmt->get_result();
  printf("<h3>News stories</h3><br>");
  while($row = $result->fetch_assoc()){
    printf("<a href='story.php?id=%s'> %s </a><br>", $row["story_id"], $row["title"]);
    printf("%s<br>", $row["description"]);

  }

  if (isset($_SESSION['username']) && $_SESSION['username'] != "guest") {
    printf("<form action='storyManage.php' method='post'>");
    printf("<input type='submit' value='Manage stories' name='Submit'><br></form>");
    printf("<form action='logout.php' method='post'>");
    printf("<input type='submit' value='Logout' name='Submit'></form>");

  }
  else {
    printf("<form action='addUser.php' method='post'>");
    printf("<br><input type='submit' value='Create Registered User' name='Submit'><br></form>");
    printf("<form action='entryPage.html'>");
    printf("<input type='submit' value='Back to Login Screen' name='Submit'><br></form>");

  }

$stmt->close();
?>
