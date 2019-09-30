<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>index</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="loginContainer">
	<img src="img/logo.png" class="logo" alt="astro-logo">
	<form action="main.php" class="login-form">
		<div>
			<label>Username:</label>
			<input type = "text" name= "username" placeholder="Username">	
		</div>
		<div>
			<label>Password:</label>
			<input type = "password" name= "password" placeholder="Password">
		</div>
		<div>
		<input onclick="index.php" type="submit" value="Login" class="login-button">
		</div>
	</form>
	
	<form action="createAccount.php" class="login-form">
		<div>
			<input onclick = "createAccount.php" type="submit" class="createAccount-button" value="Create Account">
		</div>
	</form>
	</div>
</body>
</html>
