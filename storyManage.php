<!DOCTYPE html>
<html>
  <head>
    <title>User add and delete story page</title>
  </head>
  <body>
    <p>Would you like to delete any of your stories </p>
    <form action='deleteStory.php' method='post'>
    <input type="hidden" name="token" value="<?php session_start(); echo $_SESSION['token'];?>" />
    <?php
      require 'database.php';

      if(!isset($_SESSION)){
        session_start();
      }

      $user_id = $_SESSION['user_id'];
      $stmt = $mysqli->prepare("select story_link, title, description, story_id from
      stories where stories.user_id=?");
      if(!$stmt){
      	printf("Query Prep Failed: %s\n", $mysqli->error);
      	exit;
      }
      $stmt->bind_param('i', $user_id);
      $stmt->execute();

      $result = $stmt->get_result();
      while($row = $result->fetch_assoc()){
      	printf("%s <input type='radio' value=%s name=name>", $row['title'], $row['story_id']);
        printf("<input type='submit' value='Delete'><br>");
        printf("<input type='hidden' name='token' value='%s' /> ", $_SESSION['token']);

      }
      $stmt->close();
  ?>

  </form>
  <p>Would you like to edit your stories</p>
  <form action='editStory.php' method='post'>
  <input type="hidden" name="token" value="<?php session_start(); echo $_SESSION['token'];?>" />
  <?php
    require 'database.php';
    if(!isset($_SESSION)){
      session_start();
    }
    $user_id = $_SESSION['user_id'];
    $stmt = $mysqli->prepare("select story_link, title, description, story_id from
    stories where stories.user_id=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
      printf("%s <input type='radio' value=%s name=name>", $row['title'], $row['story_id']);
      printf("<input type='submit' value='Edit'><br>");
      printf("<input type='hidden' name='token' value='%s' />", $_SESSION['token']);

    }
    $stmt->close();
?>

</form>
  <p>Would you like to add any stories </p>
  <form action='addStory.php' method='post'>
    Title: <input type='text' style='width:400px' name='storyTitle'><br>
    Link: <input type='text' style='width:400px' name='storyLink'><br>
    Enter a short story description: <br/>
    <textarea name='storyDescription' style='height:200px;width:300px'></textarea><br>
   Select story from existing category <br>
      <select name="category">
        <option value="Add new category" name='category'>Add new category</option>
        <?php
        require 'database.php';
        $cat =$mysqli->prepare("select category from stories order by category");
        if(!$cat){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
        }
        $cat->execute();
        $resultcat = $cat->get_result();
        while($catrow = $resultcat->fetch_assoc()){
          printf("<option value='%s' name='category'> %s </option>", $catrow['category'], $catrow['category']);

        }
        $cat->close();
        ?>

      </select></br>
      Or enter new category <input type="text" name="addOption">
    </select><br>
    <input type='Submit' name='submit' value='Add story'>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
  </form>
  <form><input type="button" value="Back" onClick="history.go(-1);return true;"></form>
  </body>
</html>
