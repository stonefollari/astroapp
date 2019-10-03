<?php
// Relative paths to other directories.
$PUBLIC_DIR = '../public';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Location</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="loginContainer">
	<img src="<?php echo $PUBLIC_DIR;?>/img/logo.png" class="logo" alt="astro-logo">
	<form action="http://localhost/astroapp/src/Controller/LocationController.php" class="loginForm" method="get">
		<div>
			<label></label>
			<input type = "text" name= "country" placeholder="Country">
		</div>
		<div>
			<label></label>
			<input type = "text" name= "state" placeholder="State">
		</div>
		<div>
			<label></label>
			<input type = "text" name= "city" placeholder="City">
		</div>
		<div>
		<input onclick="main.php" type="submit" value="Go!" class="loginButton" method="get">
		</div>
	</form>
</body>
</html>