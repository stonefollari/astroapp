<?php
/**
 * Establishes connection to SQL instance.
 *
 * @author Michael Follari
 *
 * Last updated 10/17/2019
 */
class MySQLConnector {

	// Default values.
	private $DEFAULT_DSN = 'localhost';
	private $DEFAULT_PORT = 3306;
	private $DEFAULT_TABLE_NAME = 'data';

	// Class variables.
	private $conn;
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
		$this->sqlUser = $_ENV['MYSQL_USERNAME'];
		$this->sqlPassword = $_ENV['MYSQL_PASSWORD'];
		$this->sqlPort = $this->DEFAULT_PORT;
		$this->dbName = $this->DEFAULT_TABLE_NAME;
	}

	/**
	 * Inserts object with values $_data into the table $_dbTable.
	 * @param $_data - (Associative Array) - Array with key, value pairs for object.
	 * @param $_dbTable - (String) - name of the table ot insert the object into.
	 * @return Boolean - true on successful insert, false otherwise.
	 */
	public function createObject($_data, $_dbTable) {

		// Generate fields and values strings.
		$fields = $this::generateInsertFields($_data);
		$values = $this::generateInsertValues($_data);

		// Construct the INSERT string.
		$insertQuery = "INSERT INTO $_dbTable $fields VALUES $values";

		// Execute the INSERT query.
		return $this->runQuery($insertQuery);
	}

	/**
	 * Returns an associative array of the object's data.
	 */
	public function readObject($_data, $_dbTable) {

		// String specifying which fields to select (All for now).
		$selectFields = '*';

		// Get the object uuid.
		$field = 'uuid';
		$uuid = $this::getFieldValue($_data, $field);
		$condition = "$field = $uuid";

		// Construct the SELECT string.
		$readQuery = "SELECT $selectValues FROM $_dbTable WHERE $condition";

		// Execute the SELECT query.
		$result = $this->runQuery($insertQuery);
		return mysqli_fetch_assoc($result);
	}

	/**
	 * Function top read object only requiring value for uuid as a firsst parameter.
	 */
	public function readObjectByUUID($uuid, $_dbTable) {

		// Constructs a psuedo '$data' array with just uuid set to call readObject.
		$data = array('uuid'=>$uuid);
		return $this::readObject($data, $_dbTable);
	}

	/**
	 * Updates object.
	 */
	public function updateObject($_data, $_dbTable) {

		// Construct the condition string.
		$uuidField = 'uuid';
		$uuid = $this::getFieldValue($_data, $uuidField);
		$condition = "$uuidField = $uuid";

		// Construct the update value pairs string.
		$updatePairs = $this::generateUpdatePairs($_data);

		// Construct the SELECT string.
		$readQuery = "UPDATE $_dbTable SET $updatePairs WHERE $condition";
		
		// Execute the SELECT query.
		$result = $this->runQuery($insertQuery);
		return mysqli_fetch_assoc($result);
	}

	/**
	 * Sets the object active field to false (0).
	 */
	public function destroyObject($_data, $_dbTable) {
		updateObject($_data, $_dbTable);
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
	 * Returns the value of the field
	 */
	private function getFieldValue($_data, $_key) {

        // If value exists, return it.
        if( isset($_data[$_key]) ){
            return $_data[$_key];
        
            // If key value pair is not set, return null.
        }else{
            return null;
        }
	}

	/**
	 * Extracts the keys and formats for SQL query.
	 */
	private function generateInsertFields($_data) {
		$keys = implode(', ', array_keys($_data));
		return '('.$keys.')';
	}
	
	/**
	* Extracts the values and formats for SQL query.
	 */
	private function generateInsertValues($_data) {
		$vals = implode(', ', array_values($_data));
		return '('.$vals.')';
	}

	private function generateUpdatePairs($_data){
		$stmtArray = array();
		foreach( $_data as $key => $val ){
			$stmtArray[] = "`$key`=$val";
		}
		$stmtString = implode(', ', $stmtArray);
		echo $stmtString;
	}

	/**
	 * Loads the environment variables stored in .env file.
	 */
	public function loadEnvVariables() {
		// Load the environment variables.
		// Access environment variables with getenv('varname') or $_ENV['varname']
		LoadEnvironment::loadEvironmentVariables();
	}
}

?>