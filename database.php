<?php

$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'mod3');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
