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
  // Display the different categories
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
  // Displays all the stories individually
  $result = $stmt->get_result();
  printf("<h3>News stories</h3><br>");
  while($row = $result->fetch_assoc()){
  	printf("<a href=story.php?id=%s> %s </a><br>", $row['story_id'], $row["title"]);
    printf("%s<br>", $row["description"]);
  }
  // If the username is set give the user the option to add stories
  if (isset($_SESSION['username']) && $_SESSION['username'] != "guest") {
    printf("<form action='storyManage.php' method='post'>");
    printf("<input type='submit' value='Manage stories' name='Submit'><br></form>");
    printf("<form action='logout.php' method='post'>");
    printf("<input type='submit' value='Logout' name='Submit'></form>");

  }
  // If the user is not set display the option to create a registered user
  else {

    printf("<form action='addUser.php' method='post'>");
    printf("<br><input type='submit' value='Create Registered User' name='Submit'><br></form>");
    printf("<form action='entryPage.html'>");
    printf("<input type='submit' value='Back to Login Screen' name='Submit'><br></form>");

  }

  // Allows the user to delete their account
  $username = $_SESSION['username'];

  // get user id of current user
  $stmt = $mysqli->prepare("select user_id from users where username=?");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt ->get_result();
  $row = $result->fetch_assoc();

  // create delete button and pass user_id
  echo "<br>Click below to delete your account";
  printf("
    <form action=deleteUser.php method=post>
      <input type=submit value=Delete Account name=submit<br>
      <input type='hidden' name='token' value='%s'>
      <input type='hidden' name='user_id' value='%s'>
    </form>", $_SESSION['token'], $row['user_id']);

$stmt->close();
?>
