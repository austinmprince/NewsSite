<?php
  session_start();
  session_destroy();
  header("refresh: 2; url=entryPage.html");
  echo "Logout succesful";
  exit;
?>
