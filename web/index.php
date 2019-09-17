<?php

// Path to the root directory, relative to the current dir.
$REL_ROOT = '..\\';

// Require packages
require $REL_ROOT.'vendor/autoload.php';

// Load the environment variables.
// Accessed with $_ENV['<var_name>']
$dotenv = Dotenv\Dotenv::create($REL_ROOT);

// Trying to load environment variables.
try{
	$dotenv->load();

	// Setting sql parameters from ENV (or otherwise).
	$dbName = 'sys';
	$dbUser = $_ENV['DB_USERNAME'];
	$dbPass = $_ENV['DB_PASSWORD'];

	// Connect to the SQL server.
	// Must first proxy into the server. Documentation is in README.
	connectToSQL($dbName, $dbUser, $dbPass);
}catch( Exception $e){

	echo "Not loading .env file. Make sure to create and populate it.";
}

// Global variable for SQL defined.
$mysqli;
function connectToSQL($_dbName, $_dbUser, $_dbPass){
	try{
		$mysqli = new mysqli('127.0.0.1', $_dbUser, $_dbPass, $_dbName, 3306);

		// Print variable information to test proper connnection to SQL server.
		//var_dump($mysqli);
	}catch( Exception $e){
		echo "Connection to server failed. Ensure proxy is setup and running/connected.";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>index</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div>
	<img src="img/logo.png" class="logo" alt="astro-logo">
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
