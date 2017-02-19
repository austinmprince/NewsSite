<!DOCTYPE html>
  <html>
    <head>
      <title>Edit story page</title>
    </head>
    <body>

    <?php
    require 'database.php';
    if(!isset($_SESSION)){
      session_start();
    }
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
       die("Request forgery detected");
    }
    $user_id = $_SESSION['user_id'];
    $stid_number = $_POST['name'];
    $stmt = $mysqli->prepare("select story_link, title, description, story_id, category from
    stories where stories.story_id=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('i',  $stid_number);
    $stmt->execute();
    $stmt->bind_result($story_link, $title, $description, $story_id, $category);
    $stmt->close();


    ?>
    <
    Title: <input type='text' style='width:400px' name='storyTitle' value=<?php printf($title);?>><br>
    Link: <input type='text' style='width:400px' name='storyLink' value='<?php printf(htmlspecialchars($story_link));?>'><br>
    Enter a short story description: <br/>
    <textarea name='storyDescription' style='height:200px;width:300px' value='<?php printf($description);?>'></textarea><br>
    Select story from existing category <br>
        <select name="category">
          <?php
          require 'database.php';
          echo "In php doc";
          $cat =$mysqli->prepare("select distinct category from stories order by category");
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
          <option value="Add new category" name='category'>Add new category</option>
        </select></br>
        Or enter new category <input type="text" name="addOption">
      </select><br>
      <input type='Submit' name='submit' value='Submit Edits'>
      <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>
  </body>
</html>
