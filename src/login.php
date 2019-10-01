<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="loginContainer">
	<img src="img/logo.png" class="logo" alt="astro-logo">
	<form action="http://localhost/astroapp/src/Controller/LoginController.php" class="loginForm" method="post">
		<div>
			<label></label>
			<input type = "text" name= "userName" placeholder="Email">	
		</div>
		<div>
			<label></label>
			<input type = "password" name= "password" placeholder="Password">
		</div>
		<div>
		<input onclick="../HomeController.php" type="submit" value="Login" class="loginButton">
		</div>
	</form>
	
	<form action="createAccount.php" class="login-form">
		<div>
			<input class="createAccountButton" onclick = "createAccount.php" type="submit" value="Create Account">
		</div>
	</form>
	<form action="HomeController.php">
	<input id="guest" type="submit" value="Guest User">
	</form>
</body>
</html>
