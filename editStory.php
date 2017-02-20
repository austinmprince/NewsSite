<!DOCTYPE html>
  <html>
    <head>
      <title>Edit story page</title>
    </head>
    <body>
    <form action="editStorySubmit.php" method="post">
    <?php
    require 'database.php';
    if(!isset($_SESSION)){
      session_start();
    }
    // Recieve token from and validate
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
       die("Request forgery detected");
    }
    $stid_number = (int)$_POST['name'];
    $stmt = $mysqli->prepare("select story_link, title, description, story_id, category from
    stories where stories.story_id=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    // Bind parameters of the story that already exists so that we can prefill the
    $stmt->bind_param('i',  $stid_number);
    $stmt->execute();
    $stmt->bind_result($story_link, $title, $description, $story_id, $category);
    $stmt->fetch();
    $stmt->close();
    ?>

    Title: <input type='text' style='width:400px' name='storyTitle' value='<?php printf(htmlspecialchars($title));?>'><br>
    Link: <input type='text' style='width:400px' name='storyLink' value='<?php printf(htmlspecialchars($story_link));?>'><br>
    Enter a short story description: <br/>
    <textarea name='storyDescription' style='height:200px;width:300px'><?php printf(trim(htmlspecialchars($description)));?></textarea><br>
    Select story from existing category <br>
        <select name="category">
          <?php
          require 'database.php';
          $cat =$mysqli->prepare("select distinct category from stories order by category");
          if(!$cat){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
          }
          $cat->execute();
          $resultcat = $cat->get_result();
          while($catrow = $resultcat->fetch_assoc()){
            if ($catrow['category'] == $category) {
              printf("<option value='%s' name='category' selected='selected'> %s </option>", $catrow['category'], $catrow['category']);

            }
            else {
              printf("<option value='%s' name='category'> %s </option>", $catrow['category'], $catrow['category']);
            }
          }
          $cat->close();
          ?>
          <option value="Add new category" name='category'>Add new category</option>
        </select></br>
        Or enter new category <input type="text" name="addOption">
      </select><br>
      <input type='Submit' name='submit' value='Submit Edits'>
      <input type="hidden" name="stid" value=<?php echo $stid_number;?> />
      <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form><br>
    <form action='viewStories.php'>
    <input type='submit' value='Back to Story Screen' name='Submit'><br></form>
  </body>
</html>
