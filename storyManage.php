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
      stories where stories.user_id=$user_id");
      if(!$stmt){
      	printf("Query Prep Failed: %s\n", $mysqli->error);
      	exit;
      }
      $stmt->execute();

      $result = $stmt->get_result();
      while($row = $result->fetch_assoc()){
      	printf("%s <input type='radio' value=%s name=name>", $row['title'], $row['story_id']);
        printf("<input type='submit' value='Delete'><br>");



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
      <select id="mySelect">
        <?php
        require 'database.php';
        echo "In php doc";
        $cat =$mysqli->prepare("select category from stories order by category");
        if(!$cat){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
        }
        echo "In sedal;dfsjkl;lecgt";
        $cat->execute();
        $resultcat = $cat->get_result();
        while($catrow = $resultcat->fetch_assoc()){
          printf("<option value='%s' name='category'> %s </option>", $catrow['category'], $catrow['category']);

        }
        $cat->close();
        ?>
      </select></br>
      <p>Click the button to add a new category</p>
      <button type="button" onclick="myFunction()">Insert option</button>
      <input type="text" name="addOption">
      <script>
      function myFunction() {
          var x = document.getElementById("mySelect");
          var option = document.createElement("option");
          <?php
          $_GET['addOption'];
          ?>
          option.text = "addOption";
          x.add(option);
      }
      </script>
    </select><br>
    <input type='Submit' name='submit' value='Add story'>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
  </form>
  <form><input type="button" value="Back" onClick="history.go(-1);return true;"></form>
  </body>
</html>
