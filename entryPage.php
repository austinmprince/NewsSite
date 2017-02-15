<!DOCTYPE html>
<html>
  <head>
    <title>Login page</title>
  </head>
  <body>
    <h1>Welcome to Generic News Site Generator version2.1.4.3.x</h1>
    <h3>If you are a registered user please login below</h3>
    <form action="registeredLogin.php" method="post" autocomplete="off">
		Enter username: <input type="text" name="userName"/>
    Enter password: <input type="password" name="password"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>/">
    <input type="submit" name="login">
	</form>
  <h3>If you are an unregistered user click below to see new stories</h3>
  <form action="viewFiles.php">
  <input type="submit" name="Submit">
  </form>
	<h3>Create a new user</h3>
		<form action="addUser.php" method="post">
      <p> Click below to add new user </p>
			<input type="submit" name="login">
		</form>
</body>
</html>
