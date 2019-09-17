<?php

// Path to the root directory, relative to the current dir.
$REL_ROOT = '../';

// Require packages
require $REL_ROOT.'vendor/autoload.php';

// Load the environment variables
// Accessed with $_ENV['<var_name>']
// Example: $_ENV['DB_USERNAME']
$dotenv = Dotenv\Dotenv::create($REL_ROOT);
$dotenv->load();


// Connect to the SQL server.
// Must first proxy into the server. Documentation is in README.
$dbName = 'sys';
$dbUser = $_ENV['DB_USERNAME'];
$dbPass = $_ENV['DB_PASSWORD'];
$mysqli = new mysqli('127.0.0.1', $dbUser, $dbPass, $dbName, 3306);

var_dump( $mysqli ); 




?>
<!DOCTYPE html>
<html>
<head>
	<title>index</title>
	<link rel="stylesheet" type "text/css" href="css/style.css">
</head>
<body>
	<div>
	<img src="img/logo.png" class="logo" alt "astro-logo">
	</div>
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
</body>
</html>
