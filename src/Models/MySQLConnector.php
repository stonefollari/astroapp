<?php
namespace Astroapp\Src\Models;
use Mysqli;
use Dotenv;
// Load composer packages.
require '..\..\vendor\autoload.php';
/**
 * Establishes connection to SQL instance.
 *
 * @author Michael Follari
 *
 * Last updated 10/17/2019
 */
class MySQLConnector{

	// Path to the root directory, relative to the current dir.
	private $RELATIVE_ROOT = '..\..\\';

	// Default values.
	private $DEFAULT_PORT = 3306;
	private $DEFAULT_TABLE_NAME = 'data';

	// Class variables.
	private $conn;
	private $sqlConnection;
	private $sqlDSN;
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
		$this->sqlDSN = $_ENV['MYSQL_DSN'];
		$this->sqlUser = $_ENV['MYSQL_USER'];
		$this->sqlPassword = $_ENV['MYSQL_PASSWORD'];
		$this->sqlPort = $this->DEFAULT_PORT;
		$this->dbName = $this->DEFAULT_TABLE_NAME;
	}

	/**
	 * Creates the users table if it does not exist.
	 */
	public function createUserTable() {

		// Connect to the SQL server
		$this->connect();

		// Construct query for creating the users table if does not exist.
		// This will come in handy if things are ever ported.
		$tableName = "users";
		$sql = "CREATE TABLE IF NOT EXISTS $tableName (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			uuid VARCHAR(64) NOT NULL,
			username VARCHAR(32) NOT NULL,
			firstname VARCHAR(32) NOT NULL,
			lastname VARCHAR(32) NOT NULL,
			password VARCHAR(64) NOT NULL,
			email VARCHAR(64) NOT NULL,
			active INT(1) NOT NULL,
			delete_date INT(11) NOT NULL,
			timestamp INT(11) NOT NULL,
			)";

		// Run the query and return the result.
		$result = $this->runQuery($sql);
		return $result;
	}

	/**
	 * Creates an instance of object and inserts it into the database.
	 */
	public function createObject($_data, $_dbTable) {

		// Generate a unique identifier.
		$uuid = uniqid();

		// Hardcoded field and value for testing purposes.
		$fields = "(uuid, username, password)";
		$values = "($uuid, $username, $password)";
		$formattedValuePairs = "$fields VALUES $values";

		// Construct the query string.
		$insertQuery = "INSERT INTO $_dbTable $formattedValuePairs";

		// Execute the insert query.
		return $this->runQuery($insertQuery);
	}

	public function readObject($_data, $_dbTable) {

		// Hardcoded field and value for testing purposes.
		$fields = "uuid";
		$values = "$uuid";
		$valuePairs = "$fields = $uuid";
		$formattedValuePairs = "*";

		// Construct the select string
		$readQuery = "SELECT $selectValues FROM $_dbTable WHERE $formattedValuePairs";

		// Execute the run query.
		$result = $this->runQuery($insertQuery);
		return \mysqli_fetch_assoc($result);
	}

	public function updateObject($_data, $_dbTable) {

	}

	public function destroyObject() {

	}


	/**
	 * Runs passed query and returns the result.
	 * Wrapper for mysqli->query() functtion.
	 */
	public function runQuery($_query) {

		// Connect to SQL instance.
		$this->connect();

		// Null/unset check on connection.
		if( !$this->conn ) {
			return false;
		}
		// Connection error check.
		if ($this->conn->connect_error) {
			return false;
		}

		// Run the query, close the connection, and return.
		$result = $this->conn->query($_query);
		$this->close();
		return $result;
	}

	/**
	 * Connects the GCloud App Engine to the SQL Database.
	 */
	public function connect() {

		try {
			// Connect to SQL instance with mysqli
			$mysqli = new mysqli($sqlDSN, $this->sqlUser, $this->sqlPassword, $this->dbName, $this->sqlPort);

			// Set this connection (conn) to the connection.
			$this->conn = $mysqli;
			return $mysqli;

		}catch(Exception $e) {
			throw $e;
		}

	}

	/**
	 * Wrapper for mysqli close.
	 */
	private function close() {
		$this->conn->close();
	}


	/**
	 * Loads the environment variables stored in .env file.
	 */
	public function loadEnvVariables() {

		// Load the environment variables.
		// Accessed with $_ENV['<var_name>']
		$dotenv = Dotenv\Dotenv::create( $this->RELATIVE_ROOT);

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