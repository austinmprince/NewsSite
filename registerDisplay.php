<?php
  session_start();
  echo "Welcome " . $_SESSION['username'] . " you have some files waiting for you";


  printf("<form action='logout.php' method='post'>");
  printf("Logout <input type='submit' name='Submit'>");


?>
