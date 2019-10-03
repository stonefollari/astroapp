<!DOCTYPE html>
<html>
<head>
	<title>Create Account</title>
	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>
	<div class="createAccountContainer">
	<img src="../../public/img/logo.png" class="logo" alt="astro-logo">
	<form action="../../src/Controller/CreateAccountController.php" class="createAccountForm" method="post">
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

	<form action="../../src/Controller/HomeController.php" class="login-form">
			<div>
				<input class="createAccountButton" type="submit" value="Go Back">
			</div>
		</form>
	</div>
</body>
</html>