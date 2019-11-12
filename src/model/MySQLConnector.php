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
class MySQLConnector implements Database{

	// Path to the root directory, relative to the current dir.
	private $RELATIVE_ROOT = '..\..\\';

	// Default values.
	private $DEFAULT_DSN = 'localhost';
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
		$this->sqlDSN = $DEFAULT_DSN;
		$this->sqlUser = $_ENV['MYSQL_USER'];
		$this->sqlPassword = $_ENV['MYSQL_PASSWORD'];
		$this->sqlPort = $this->DEFAULT_PORT;
		$this->dbName = $this->DEFAULT_TABLE_NAME;
	}

	/**
	 * Creates an instance of object and inserts it into the database.
	 */
	public function createObject($_data, $_dbTable) {

		// Generate a unique identifier.
		$uuid = uniqid();

		// Hardcoded field and value for testing purposes.
		$fields = $this::extractKeys($_data);
		$values = $this::extractValues($_data);
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


	private function extractKeys($_data){
		return "(uuid, username, password)";
	}

	private function extractValues($_data){
		return '("test","test","test")';
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
}
?>