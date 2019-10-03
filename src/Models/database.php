<?php
namespace AstroApp\Src\Models;
use Dotenv;
use Mysqli;
// Load composer packages.
require '..\..\vendor\autoload.php';

/**
 * Establishes connection to SQL instance.
 *
 * @author Michael Follari
 *
 * Last updated 10/2/2019
 */
class Database{

	// Path to the root directory, relative to the current dir.
	private $RELATIVE_ROOT = '..\..\\';

	// Default values.
	private $DEFAULT_PORT = 3306;
	private $DEFAULT_LOCALHOST = '127.0.0.1';
	private $DEFAULT_TABLE_NAME = 'data';

	// Enumerate for type of connection to SQL server is extablished.
	private $LOCAL_CONNECTION = 1;
	private $SERVER_CONNECTION = 2;
	private $APP_CONNECTION = 3;

	// Class variables.
	private $conn;
	private $sqlConnection;
	private $sqlDSN;
	private $sqlLocal;
	private $sqlUser;
	private $sqlPassword;
	private $sqlPort;
	private $dbName;
	private $dbTable;
	private $connectionType;

	/**
	 * Class constructor.
	 */
	public function __construct() {

		// Load the environment variables.
		$this->loadEnvVariables();

		// Set default values for class variables.
		$this->conn = null;
		$this->sqlConnection = null;
		$this->sqlDSN = $_ENV['MYSQL_DSN'];
		$this->sqlUser = $_ENV['MYSQL_USER'];
		$this->sqlPassword = $_ENV['MYSQL_PASSWORD'];
		$this->sqlLocal = $this->DEFAULT_LOCALHOST;
		$this->sqlPort = $this->DEFAULT_PORT;
		$this->dbName = $this->DEFAULT_TABLE_NAME;
		$this->connectionType = $this->LOCAL_CONNECTION;
	}

	public function createTable($_tableName){

		$this->connect();
		$this->dbTable = $_tableName;
		$sql = "CREATE TABLE IF NOT EXISTS $this->dbTable (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			username VARCHAR(32) NOT NULL,
			firstname VARCHAR(32) NOT NULL,
			lastname VARCHAR(32) NOT NULL,
			password VARCHAR(64) NOT NULL,
			email VARCHAR(64) NOT NULL
			)";
		$result = $this->runQuery($sql);
		return $result;

	}

	/**
	 * Runs desired query.
	 */
	public function runQuery($_sqlQuery) {

		// Connect to SQL instance.
		$this->connect();

		// Null/unset check on connection.
		if( !$this->conn ){
			return false;
		}
		// Connection error check.
		if ($this->conn->connect_error) {
			return false;
		}

		// Run query. Return trye/false depending on success
		if ($this->conn->query($_sql) === TRUE) {
			// Close connection.
			$this->close();
			return true;
		} else {
			// Close connection.
			$this->close();
			return false;
		}

	}

	/**
	 * Connects the GCloud App Engine to the SQL Database.
	 */
	private function connectAppToServer() {

		// Connecting to the server SQL Instance via mysqli connection function.
		$mysqli = $this->mysqliConnectTo($this->sqlDSN);

		// If connection successful, set connection type and return mysqli object
		if($mysqli) {
			$this->sqlConnection = $this->APP_CONNECTION;
		}
		return $mysqli;

	}

	/**
	 * Connects to the local SQL Instance.
	 */
	private function connectToLocal() {

		// Connecting to the local SQL Instance via mysqli connection function.
		$mysqli = $this->mysqliConnectTo($this->sqlLocal);

		// If connection successful, set connection type and return mysqli object
		if($mysqli) {
			$this->sqlConnection = $this->LOCAL_CONNECTION;
		}
		return $mysqli;

	}

	/**
	 * Wrapper for connecting with mysqli connect method.
	 */
	public function connect() {

		switch ( $this->sqlConnection) {
			case $this->LOCAL_CONNECTION:
				return $this->connectToLocal();
			case $this->SERVER_CONNECTION:
				return $this->connectToLocal();
			case $this->APP_CONNECTION:
				return $this->connectAppToServer();
			default:
				return false;
		}

	}

	/**
	 * Wrapper for mysqli close.
	 */
	private function close() {
		$this->conn->close();
	}


	private function mysqliConnectTo($_sqlURL){
		try {
			// Connect to SQL instance with mysqli
			$mysqli = new mysqli($_sqlURL, $this->sqlUser, $this->sqlPassword, $this->dbName, $this->sqlPort);
			// Set this connection (conn) to the connection.
			$this->conn = $mysqli;
			return $mysqli;

		}catch(Exception $e) {
			return false;
		}
	}

	/**
	 * Loads the environment variables stored in .env file.
	 */
	public function loadEnvVariables() {

		// Load the environment variables.
		// Accessed with $_ENV['<var_name>']
		$dotenv = Dotenv\Dotenv::create($this->RELATIVE_ROOT);

		$dotenv->load();
	}

//==================GETTERS==================



//==================SETTERS==================

	public function setLocal($_sqlLocal) {
		$this->sqlLocal = $_sqlLocal;
	}

	public function setDSN($_sqlDSN) {
		$this->sqlDSN = $_sqlDSN;
	}

	public function setTable($_dbTable) {
		$this->dbTable = $_dbTable;
	}

	public function setDatabase($_dbName) {
		$this->dbName = $_dbName;
	}
	public function setPort($_sqlPort) {
		$this->sqlPort = $_sqlPort;
	}

	public function setUsername($_sqlUser) {
		$this->sqlUser = $_sqlUser;
	}

	public function setPassword($_sqlPassword) {
		$this->sqlPassword = $_sqlPassword;
	}

	public function setLocalConnection() {
		$this->connectionType = $this->LOCAL_CONNECTION;
	}
	public function setAppConnection() {
		$this->connectionType = $this->APP_CONNECTION;
	}

}
?>