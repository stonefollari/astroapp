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
	private $DEFAULT_DATABASE = 'astrodata';
	private $SQL_NULL = "NULL";
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
		$this->sqlDSN = $this->DEFAULT_DSN;
		$this->sqlUser = $_ENV['MYSQL_USERNAME'];
		$this->sqlPassword = $_ENV['MYSQL_PASSWORD'];
		$this->sqlPort = $this->DEFAULT_PORT;
		$this->dbName = $this->DEFAULT_DATABASE;

		$this->initializeConfiguration();
	}

	/**
	 * Inserts object with values $_data into the table $_dbTable.
	 * @param $_data - (Associative Array) - Array with key, value pairs for object.
	 * @param $_dbTable - (String) - name of the table ot insert the object into.
	 * @return Boolean - true on successful insert, false otherwise.
	 */
	public function createObject($_data, $_dbTable) {

		// Generate fields and values strings.
		$fields = $this->generateInsertFields($_data);
		$values = $this->generateInsertValues($_data);

		// Construct the INSERT string.
		$insertQuery = "INSERT INTO $_dbTable $fields VALUES $values;";

		// Execute the INSERT query.
		$res = $this->runQuery($insertQuery);

	}

	/**
	 * Returns an associative array of the object's data.
	 */
	public function readObject($_data, $_dbTable, $_conditionValPairs=null) {
		// String specifying which fields to select (All for now).
		$selectFields = '*';

		// Construct the conditionValPairs if not exist.
		// Defaults condition to UUID of _data.
		if( is_null($_conditionValPairs) ){
			$field = 'uuid';
			$value = $this->getUUID($_data);
			$_conditionValPairs = array($field=>$value);
		}
		// Genearte condition string.
		$condition = $this->generateCondition($_conditionValPairs);

		// Construct the SELECT string.
		$readQuery = "SELECT $selectFields FROM $_dbTable WHERE $condition;";
		
		// Execute the SELECT query.
		$result = $this->runQuery($readQuery);
		
		if($result) {
			return mysqli_fetch_assoc($result);
		}else{
			return null;
		}
	}

	/**
	 * Updates object.
	 */
	public function updateObject($_data, $_dbTable) {

		// Construct the condition string.
		$uuidField = 'uuid';
		$uuid = $this->getFieldValue($_data, $uuidField);
		$condition = "$uuidField = $uuid";

		// Construct the update value pairs string.
		$updatePairs = $this->generateUpdatePairs($_data);

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
	public function runQuery($_query, $_debug=false) {

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

		$_debug = true;
		$this->error($_debug);

		$this->close();
		return $result;
	}

	/**
	 * Connects the GCloud App Engine to the SQL Database.
	 */
	private function connect() {

		try {
			// Connect to SQL instance with mysqli
			$mysqli = new mysqli($this->sqlDSN, $this->sqlUser, $this->sqlPassword, $this->dbName, $this->sqlPort);
			// Set this connection (conn) to the connection.
			$this->conn = $mysqli;

			// Check if connection error, if so print the error number and exit.
			if ($this->conn->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_error);
				exit();
			}

			return $mysqli;

		}catch(Exception $e) {
			throw $e;
		}

	}

	/**
	 * Wrapper for mysqli error.
	 */
	private function error($_debug=false){

		$err = $this->conn->error;
		if( $_debug && $err ){
			printf("SQL Error: %s\n", $err);
		}

		return $this->conn->error;
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
	 * Returns the UUID of the data.
	 */
	private function getUUID($_data){
		$uuid =  $this->getFieldValue($_data, 'uuid');
		return $uuid;
	}

	/**
	 * Extracts the keys and formats for SQL query.
	 */
	private function generateInsertFields($_data) {
		$keys = $this->formatKeys(array_keys($_data));

		$keyStr = implode(', ', $keys);
		return '('.$keyStr.')';
	}

	/**
	* Extracts the values and formats for SQL query.
	*/
	private function generateInsertValues($_data) {

		$_data = $this->formatValues($_data);
		$vals = implode(', ', array_values($_data));
		return '('.$vals.')';
	}

	private function generateUpdatePairs($_data) {
		$stmtArray = array();
		foreach( $_data as $key => $val ){
			$stmtArray[] = "`$key`='$val'";
		}
		$stmtString = implode(', ', $stmtArray);
		return $stmtString;
	}

	private function generateCondition($_data) {
        
		$stmtArray = array();
		foreach( $_data as $key => $val ){
			// If value is a string, add single quotes.
			if(is_string($val)){
				$val = "'".$val."'";
			}
			$stmtArray[] = "`$key`=$val";
		}
		$stmtString = implode(' AND ', $stmtArray);
		return $stmtString;
    }

	/**
	 * Format SQL values.
	 * If null value, repalce with NULL string.
	 * if others, add quotes.
	 */
	private function formatValues($_data) {
		// Loop through the values array and replace instances of null with NULL
		foreach( $_data as $key => $val ){
			$_data[$key] = $this->formatValue($val);
		}
		return $_data;
	}

	/**
	 * Formats a single SQL value.
	 */
	private function formatValue($_value) {
		if( $_value === null ) {
			return $this->SQL_NULL;
		}else{
			return $this->addQuotes($_value, "'");
		}
	}

	/**
	 * Add quotes to each key of the keys array.
	 */
	private function formatKeys($_keyArray){
		// Loop through the keys array and add quotes to each string key.
		for( $i=0; $i<count($_keyArray); $i++ ){
			$_keyArray[$i] = $this->addQuotes($_keyArray[$i]);
		}
		return $_keyArray;
	}

	/**
	 * Adds quotes to SQL key / value and returns.
	 */
	private function addQuotes($_data, $_quote="`") {
		return $_quote . "$_data" . $_quote;
	}

	/**
	 * Loads the environment variables stored in .env file.
	 */
	private function loadEnvVariables() {
		// Load the environment variables.
		// Access environment variables with getenv('varname') or $_ENV['varname']
		LoadEnvironment::loadEvironmentVariables();
	}

	/**
	 * Configures the SQL for initial connection.
	 * Generates database and subsequent tables if they do not exist.
	 */
	private function initializeConfiguration() {

		// Create the database being used (If not exists).
		$this->createDatabase($this->DEFAULT_DATABASE);

		// Create the tables (users)
		$this->createTables();
	}

	/**
	 * Creates database if it does not exist.
	 */
	private function createDatabase($_databaseName) {

		// Create the passed database if it does not exist.
		$sql = "CREATE DATABASE IF NOT EXISTS $_databaseName";
		$mysqli = new mysqli($this->sqlDSN, $this->sqlUser, $this->sqlPassword);
		$result = $mysqli->query($sql);
		$mysqli->close();
	}

	/**
	 * Creates the tables needed in the SQL database.
	 */
	private function createTables() {

		$userTable = User::getDataType();
		$userTableSQL =
			"CREATE TABLE IF NOT EXISTS $userTable (
			`id` INT NOT NULL AUTO_INCREMENT,
			PRIMARY KEY(id),
			`uuid` VARCHAR(255) NOT NULL,
			`username` VARCHAR(32) NOT NULL,
			`email` VARCHAR(64),
			`firstname` VARCHAR(32),
			`lastname` VARCHAR(32),
			`phone` VARCHAR(32),
			`location` VARCHAR(255),
			`password` VARCHAR(255) NOT NULL,
			`active` BOOLEAN NULL DEFAULT '0',
			`deleted` INT(11) NULL DEFAULT '0',
			`timestamp` VARCHAR(32) NULL DEFAULT 'unix_timestamp()'
			);";
		$this->runQuery( $userTableSQL );
	}

}

?>