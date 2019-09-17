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