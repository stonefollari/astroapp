<!DOCTYPE html>
<html>
<head>
	<title>createAccount</title>
	<link rel="stylesheet" type "text/css" href="css/style.css">
</head>
<body>
<div>
<img src="img/logo.png" class="logo" alt "astro-logo">
</div>
	<form class="createAccount-form">
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
	</form>	
	<form action ="index.php" class="login-form">
		<div>
		<input onclick = "index.php" type="submit" value="Create Account" class="createAccount-button">
		</div>
	</form>
</body>
</html>