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
    <input type="submit" name="login">
	</form>
  <h3>If you are an unregistered user click below to see new stories</h3>
  <form action="viewFiles.php" method="post">
  <input type="submit" name="Submit">
  <input type="hidden" name="guest" value="guest">
  </form>
	<h3>Create a new user</h3>
		<form action="addUser.php" method="post">
      <p> Click below to add new user </p>
			<input type="submit" name="login">
		</form>
</body>
</html>
