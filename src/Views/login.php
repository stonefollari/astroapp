<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="loginContainer">
		<img src="../../public/img/logo.png" class="logo" alt="astro-logo">

		<!-- Form for user login. -->
		<form action="../../src/Controller/LoginController.php" class="loginForm" method="post">
			<div>
				<label></label>
				<input type = "text" name= "userName" placeholder="Email">
			</div>
			<div>
				<label></label>
				<input type = "password" name= "password" placeholder="Password">
			</div>
			<div>
			<input type="submit" value="Login" class="loginButton">
			</div>
		</form>

		<!-- Form for user account creation -->
		<form action="../../src/Controller/createAccountController.php" class="login-form">
			<div>
				<input class="createAccountButton" type="submit" value="Create Account">
			</div>
		</form>

		<!-- Form for guest user access -->
		<form action="../../src/Controller/HomeController.php">
			<input id="guest" type="submit" value="Guest User">
		</form>
	</div>
</body>
</html>
