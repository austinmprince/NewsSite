<?php
  session_start();
  session_destroy();
  header("refresh: 5; url=entryPage.php");
  echo "Logout succesful";
  exit;
?>
