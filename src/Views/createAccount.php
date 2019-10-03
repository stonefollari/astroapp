<?php
// Relative paths to other directories.
$PUBLIC_DIR = '../public';
$CONTROLLER_DIR = '../Controller';

// Paths to specific controllers
$HOME_CONTROLLER_PATH = $CONTROLLER_DIR.'/HomeController.php';
$CREATEACCOUNT_CONTROLLER_PATH = $CONTROLLER_DIR.'/CreateAccountController.php';
$LOGIN_CONTROLLER_PATH = $CONTROLLER_DIR.'/LoginController.php';
// Path to stylesheet
$STYLE_PATH = $PUBLIC_DIR.'/css/style.css';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Account</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $STYLE_PATH;?>">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>
	<div class="createAccountContainer">
	<img src="<?php echo $PUBLIC_DIR;?>/img/logo.png" class="logo" alt="astro-logo">
	<form action="<?php echo $CREATEACCOUNT_CONTROLLER_PATH;?>" class="createAccountForm" method="post">
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

	<form action="login.php" class="login-form">
			<div>
				<input class="createAccountButton" type="submit" value="Go Back">
			</div>
		</form>
	</div>
</body>
</html>