<?php
  session_start();
  session_destroy();
  header("refresh: 2; url=entryPage.php");
  echo "Logout succesful";
  exit;
?>
