<!DOCTYPE html>
<html>
<head>
	<title>Create Account</title>
	<link rel="stylesheet" type ="text/css" href="style.css">
</head>
<body>
	<div class="createAccountContainer">
	<img src="img/logo.png" class="logo" alt = "astro-logo">
	<form action="http://localhost/astroapp/src/Controller/CreateAccountController.php" class="createAccountForm" method="post">
		<div>
			<label></label>
			<input type = "text" name= "firstName" placeholder="First Name">
		</div>
		<div>
			<label></label>
			<input type = "text" name= "lastName" placeholder="Last Name">
		</div>
		<div>
			<label></label>
			<input type = "text" name= "email" placeholder="Email">
		</div>
		<div>
			<label></label>
			<input type = "password" name= "password1" placeholder="Password">
		</div>
		<div>
			<label></label>
			<input type = "password" name= "password2" placeholder="Re-enter Password">
		</div>
		<br>
		<input type="submit" value="Create Account" class="createAccountButton">
	</form>
	</div>
</body>
</html>