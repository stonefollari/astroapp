<?php
// Relative paths to other directories.
$PUBLIC_DIR = '../public';
$CONTROLLER_DIR = '../Controller';

// Paths to specific controllers
$HOME_CONTROLLER_PATH = $CONTROLLER_DIR.'/HomeController.php';
$CREATEACCOUNT_CONTROLLER_PATH = $CONTROLLER_DIR.'/createAccountController.php';
$LOGIN_CONTROLLER_PATH = $CONTROLLER_DIR.'/LoginController.php';
// Path to stylesheet
$STYLE_PATH = $PUBLIC_DIR.'/css/style.css';
?>

<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $STYLE_PATH;?>">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
	<div class="loginContainer">
		<img src="<?php echo $PUBLIC_DIR;?>/img/logo.png" class="logo" alt="astro-logo">

		<!-- Form for user login. -->
		<form action="<?php echo $LOGIN_CONTROLLER_PATH;?>" class="loginForm" method="post">
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
		<form action="<?php echo $CREATEACCOUNT_CONTROLLER_PATH;?>" class="login-form">
			<div>
				<input class="createAccountButton" type="submit" value="Create Account">
			</div>
		</form>

		<!-- Form for guest user access -->
		<form action="<?php echo $HOME_CONTROLLER_PATH;?>">
			<input id="guest" type="submit" value="Guest User">
		</form>
	</div>
</body>
</html>
