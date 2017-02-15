<!DOCTYPE html>
<html>
  <head>
    <title>Login page</title>
  </head>
  <body>
    <h1>Welcome to Generic News Site Generator version2.1.4.3.x</h1>
    <h3>If you are a registered user please login below</h3>
    <form action="registeredLogin.php" method="post">
		Enter username: <input type="text" name="userName">
		<input type="submit" name="login">
    Enter password: <input type="text" name="password">
    <input type="submit" name="login">
	</form>
  <h3>If you are an unregistered user click below to see new stories</h3>
  <form action="viewFiles.php">
	<h6>Create a new user</h6>
		<form action="addUser.php" method="get">
			Enter new username: <input type="text" name="newUser">
			<input type="submit" name="login">
		</form>
</body>
</html>
