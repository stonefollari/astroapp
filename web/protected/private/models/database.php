<?php

// Path to the root directory, relative to the current dir.
$REL_ROOT = '..\\..\\..\\..\\';

// Require composer packages.
require $REL_ROOT.'vendor/autoload.php';

// Load the environment variables.
// Accessed with $_ENV['<var_name>']
$dotenv = Dotenv\Dotenv::create($REL_ROOT);

// Trying to load environment variables.
try{
	$dotenv->load();

	// Setting sql parameters from ENV (or otherwise).
	$dbName = 'data';
	$sqlDSN = '127.0.0.1';
	$sqlUser = $_ENV['MYSQL_USER'];
	$sqlPass = $_ENV['MYSQL_PASSWORD'];
	$sqlPort = 3306;

	// Connect to the SQL server.
	connectToSQL($sqlDSN, $sqlUser, $sqlPass, $sqlPort, $dbName );
}catch( Exception $e){
	echo $e;
	echo "Not loading .env file. Make sure to create and populate it.";
}

// Global variable for SQL defined.
$mysqli;
function connectToSQL($_sqlDSN, $_sqlUser, $_sqlPass, $_sqlPort, $_dbName) {

	try{
		$mysqli = new mysqli( $_sqlDSN, $_sqlUser, $_sqlPass, $_dbName, $_sqlPort);
		// Print variable information to test proper connnection to SQL server.
		//var_dump($mysqli);
	}catch( Exception $e){
		echo "Connection to server failed. Ensure proxy is setup and running/connected.";
	}
}
die();





?>