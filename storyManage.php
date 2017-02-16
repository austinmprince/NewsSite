<?php
  require 'database.php';
  session_start();
  $user_id = $_SESSION['user_id'];
  $stmt = $mysqli->prepare("select story_link, title, description, story_id from
  stories join users where stories.user_id=$user_id");
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }
  $stmt->execute();

  $result = $stmt->get_result();
  echo "<ul>\n";
  while($row = $result->fetch_assoc()){
    printf("<form action='deleteStory.php method='post'>");
  	printf("%s <input type='radio' name=name">, $row['title']);
    printf("<input type='submit' value='submit'>");

    //printf("%s", $row["description"]);
  }

?>
