<!DOCTYPE html>
<html>
  <head>
    <title>Add newUser page</title>
  </head>
  <body>
    <h3>Create a new user for Generic News Site Generator version2.1.4.3.x</h3>
    <form action="addUser.php" method="post" autocomplete="off">
		Enter username: <input type="text" name="userName">
    Enter password: <input type="password" name="password">
    <input type="submit" name="login">
  </form>
  <form action='entryPage.html'>
  <br><input type='submit' value='Back to Login Screen' name='Submit'></form>
</body>
</html>
<?php
  require 'database.php';
  if (isset($_POST['userName']) && isset($_POST['password'])){
    $userName = (String)$_POST['userName'];
    $password = (String)$_POST['password'];
    // Hash the password
    $addPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
    if(!$stmt){
  	  printf("Query Prep Failed: %s\n", $mysqli->error);
  	  exit;
    }
    // Check the userid that was entered to make sure that it is not a duplicate
    $checkUserID = $mysqli->prepare("SELECT username from users WHERE username=?");
    $checkUserID->bind_param('s', $userName);
    $checkUserID->execute();
    $checkUserIDResult=$checkUserID->fetch();
    if ($checkUserIDResult != '') {
      echo "User id exists already.";
    }
    else {
    $stmt->bind_param('ss', $userName, $addPassword);
    $stmt->execute();
    $stmt->close();
    header("Location: entryPage.php");
    exit;

    }
  }
?>
