<?php
// Path to the root directory, relative to the current dir.
$RELATIVE_ROOT = '..\\..\\..\\..\\';

function connectAppToServer($_dbName='data') {
	// Load the .env variables.
	loadEnvVariables();

	// Setting the mysqli connection parameters.
	$sqlDSN = $_ENV['MYSQL_DSN'];
	$sqlUser = $_ENV['MYSQL_USER']; 
	$sqlPass = $_ENV['MYSQL_PASSWORD'];
	$dbName = $_dbName;

	// Connecting to the SQL Instance via mysqli.
	return mysqliConnect($sqlDSN, $sqlUser, $sqlPass, $dbName);
}

function connectToLocal() {
	// Load the .env variables.
	loadEnvVariables();

	// Setting the mysqli connection parameters.
	$sqlDSN = '127.0.0.1';
	$sqlUser = $_ENV['MYSQL_USER']; 
	$sqlPass = $_ENV['MYSQL_PASSWORD'];
	$dbName = $_dbName;
	$sqlPort = 3306;

	// Connecting to the local SQL Instance via mysqli.
	return mysqliConnect($sqlDSN, $sqlUser, $sqlPass, $dbName, $sqlPort);
}

function mysqliConnect($_sqlDSN, $_sqlUser, $_sqlPass, $_dbName, $_sqlPort=3306) {
	try{
		$mysqli = new mysqli($_sqlDSN, $_sqlUser, $_sqlPass, $_dbName, $_sqlPort);
		return $mysqli;
	}catch(Exception $e){
		return false;
	}
}

function loadEnvVariables() {
	// Require composer packages.
	require $RELATIVE_ROOT.'vendor/autoload.php';

	// Load the environment variables.
	// Accessed with $_ENV['<var_name>']
	$dotenv = Dotenv\Dotenv::create($RELATIVE_ROOT);

	$dotenv->load();
}

?>