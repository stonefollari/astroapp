<!DOCTYPE html>
<html>
<head>
	<title>createAccount</title>
	<link rel="stylesheet" type "text/css" href="css/style.css">
</head>
<body>
	<div class="createAccountContainer">
	<img src="img/logo.png" class="logo" alt "astro-logo">
	<form action="index.php" class="createAccount-form">
		<div>
			<label>First Name:</label>
			<input type = "text" name= "firstName" placeholder="First Name">
		</div>
		<div>
			<label>Last Name:</label>
			<input type = "text" name= "lastName" placeholder="Last Name">
		</div>
		<div>
			<label>Email:</label>
			<input type = "text" name= "email" placeholder="Email">
		</div>
		<div>
			<label>Password:</label>
			<input type = "password" name= "password1" placeholder="Password">
		</div>
		<div>
			<label>Re-enter Password:</label>
			<input type = "password" name= "password2" placeholder="Password">
		</div>
		<br>
		<input type="submit" value="Create Account" class="createAccountButton">
	</form>	
	</div>
</body>
</html>