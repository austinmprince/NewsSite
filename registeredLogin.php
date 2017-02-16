<?php
  require 'database.php';
  if (isset($_POST['userName']) && isset($_POST['password'])) {
    // Much of the following code is taken from the course wiki and modified slightly
    $stmt = $mysqli->prepare("SELECT COUNT(*), username, password, user_id FROM users WHERE username=?");
    if(!$stmt){
  	  printf("Query Prep Failed: %s\n", $mysqli->error);
  	  exit;
    }
    $user = $_POST['userName'];
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $stmt->bind_result($cnt, $username, $pwd_hash, $user_id);
    $stmt->fetch();

    $pwd_guess = $_POST['password'];

    if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	     // Login succeeded!
        session_start();
	      $_SESSION['username'] = $username;
        $_SESSION['token'] = substr(md5(rand()), 0, 10);
        $_SESSION['user_id'] = $user_id;
        header("refresh: 1; url=viewFiles.php");
        echo "Login succesful";
        exit;

    }
    else{


       header("refresh: 5; url=entryPage.php");
       echo "Login failed";
       exit;
    }


  }
  else {
  	header("refresh: 5; url=entryPage.php");
    echo "Username or password is not set";
    exit;
  }
?>
