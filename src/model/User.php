<?php

/**
 * This is the Users class.
 * It is used in creating new users, updating a users values, and inserting a user into a database via DatabaseAdapter.
 *
 * @author Michael Follari
 *
 * Last Updated: 12/09/2019
 */
class User extends DataObject {

    protected $DATA_TYPE = 'users';
    private static $TABLE_NAME = 'users';
    private static $USERNAME_MIN_LENGTH = 3;
    private static $PASSWORD_MIN_LENGTH = 6;

    public $id;
    private $uuid;
    private $active;
    private $deleted;
    private $timestamp;

    private $username;
    private $email;
    private $firstname;
    private $lastname;
    private $phone;
    private $password;
    private $location;

    // Protected keys are keys that should be protected from leaks,
    // that is, not returned in all read operations. (This is not implemented.)
    private $protectedKeys = array('password');

    public function __construct($_valuePairs) {

        // Set the class variables with the input array.
        $this::setValues($_valuePairs);

        // If uuid is not set, set one.
        if( $this->uuid == null){
            $this->uuid = $this->generateUUID();
        }

    }

    /**
     * Creates new user.
     */
    public static function createNewUser( $_valuePairs ) {
        $user = new User($_valuePairs);
        $user->createObject();
        return $user;
    }

    /**
     * Logs the user in, adds to the session variables.
     */
    public static function loginUser($_valuePairs) {
        $username = User::extractValue($_valuePairs, 'username');
        $user = User::getUserByUsername($username);

        // Add the user to the session.
        $user->addToSession();

    }

    /**
     * Checks if a user with username already exists.
     */
    public static function usernameExists($_username) {
        // Ensure the username is legal before bothering to check it exists.
        if( !User::legalUsername( $_username ) ) {
            return false;
        }

        // Reference to fieldname (incase it changes).
        $field = 'username';

        // Create a static user with username.
        $staticValuePairs = array($field=>$_username);
        $staticUser = User::staticUser($staticValuePairs);

        $staticConditionValPairs = $staticValuePairs;
        // Read the username from the database.
        $result = $staticUser->readObject($staticConditionValPairs);

        if( $result ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Checks if a supplied password matches the database.
     */
    public static function checkCredentials( $_valuePairs ) {
        // Extract username ans password.
        $username = User::extractValue($_valuePairs, 'username');
        $password = User::extractValue($_valuePairs, 'password');
        // Fetch the password from the database.
        $user = User::getUserByUsername($username);

        // If the passwords match, return true.
        // If user is false, the username does not exist.
        if( $user ) {
            $hashPass = $user->readValue('password');
            return $hashPass === $password;
            //return password_verify( $password, $hashPass );
        }else{
            return false;
        }
    }

    /**
     * Adds class values to the session.
     */
    private function addToSession() {
        $_SESSION['username'] = $this->username;
        $_SESSION['uuid'] = $this->uuid;
    }

    /**
     * Gets the user from the database by username.
     */
    private static function getUserByUsername($_username){
        // Reference to fieldname (incase it changes).
        $field = 'username';

        // Create a static user with username.
        $staticValuePairs = array($field=>$_username);
        $staticUser = User::staticUser($staticValuePairs);

        $staticConditionValPairs = $staticValuePairs;
        // Read the username from the database.
        $result = $staticUser->readObject($staticConditionValPairs);

        $user = new User($result);
        return $user;
    }


    /**
     * Creates and returns a static user for use in static functions calls.
     */
    private static function staticUser($_valuePairs=[]) {
        return new User($_valuePairs);
    }

    /**
     * Checks to see if all nessecary parameters and present and legal.
     */
    public static function legalParams($_valuePairs) {
        $legalUsername = User::legalUsername($_valuePairs['username']);
        $legalPassword = User::legalPassword($_valuePairs['password']);
        if( $legalUsername && $legalPassword) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Returns the value of the passed field, stored in the database.
     */
    public function readValue($_field){
        $readData = $this->readObject();
        return User::extractValue($readData, $_field);
    }

    /**
     * Constructs an associative array of the values from the class variables.
     */
    public function dataArray() {
        $valuePairs = array(
            'id'=>$this->id,
            'uuid'=>$this->uuid,
            'active'=>$this->active,
            'deleted'=>$this->deleted,
            'timestamp'=>$this->timestamp,

            'username'=>$this->username,
            'email'=>$this->email,
            'firstname'=>$this->firstname,
            'lastname'=>$this->lastname,
            'phone'=>$this->phone,
            'password'=>$this->password,
            'location'=>$this->location
        );
        return $valuePairs;
    }

    /**
     * Checks to see if the passed username is legal.
     * Must not contain any illegal characters, be longer than the minimum length,
     * and must not be null.
     */
    private static function legalUsername($_username) {

        $u = User::scrubInput($_username);
        if( $u !== $_username ){
            return false;
        }else if( $u === null ) {
            return false;
        }else if( strlen($u) < User::$USERNAME_MIN_LENGTH  ) {
            return false;
        }
        return true;
    }

    /**
     * Checks to see if the passed password is legal.
     * Must not contain any illegal characters, be longer than the minimum length,
     * and must not be null.
     */
    private static function legalPassword($_password) {
        $p = User::sanitizeInput($_password);

        if( $p !== $_password ){
            return false;
        }else if( $p === null ) {
            return false;
        }else if( strlen($p) < User::$PASSWORD_MIN_LENGTH  ) {
            return false;
        }
        return true;
    }

    /**
     * Wrapper for password_hash.
     */
    private static function hashPass( $_pass ) {
       return password_hash( $_pass, PASSWORD_DEFAULT );
    }

    /**
     * Cleans the input data.
     * Removes special chars
     */
    private static function cleanInput($_data) {
        // Trim the input before processing.
        $_data = trim($_data);
        if( is_string($_data)) {
            return filter_var ( $_data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }else{
            return $_data;
        }
    }

    /**
     * Sanatizes the  input data.
     * Simply calls cleanInput as of now.
     */
    private static function sanitizeInput($_data){
        return User::cleanInput($_data);
    }

    private function scrubInput($_data) {
        return User::sanitizeInput(User::cleanInput($_data));
    }

    /**
     * Sets the values for each class variable.
     */
    private function setValues($_valuePairs) {

        $this->id = User::extractValue($_valuePairs, 'id');
        $this->uuid = User::extractValue($_valuePairs, 'uuid');
        $this->active = User::extractValue($_valuePairs, 'active');
        $this->deleted = User::extractValue($_valuePairs, 'deleted');
        $this->timestamp = User::extractValue($_valuePairs, 'timestamp');

        $this->username = User::extractValue($_valuePairs, 'username');
        $this->email = User::extractValue($_valuePairs, 'email');
        $this->firstname = User::extractValue($_valuePairs, 'firstname');
        $this->lastname = User::extractValue($_valuePairs, 'lastname');
        $this->phone = User::extractValue($_valuePairs, 'phone');
        $this->password = User::extractValue($_valuePairs, 'password');
        $this->location = User::extractValue($_valuePairs, 'location');
    }

    /**
     * Returns the key value if set, null otherwise.
     */
    private static function extractValue($_valuePairs, $_key) {

        // If value exists, return it.
        if( isset($_valuePairs[$_key]) ){
            return $_valuePairs[$_key];

        // If key value pair is not set, return null.
        }else{
            return null;
        }
    }

    /**
     * Generates a UUID for the user.
     */
    private function generateUUID() {
        $uuid = uniqid();
        return $uuid;
    }

    //==============================GETTERS==============================

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function getFullName($_delim=" ") {
        return $this->getFirstName() . $_delim . $this->getLastName();
    }

    public function getValues() {
        return array();
    }

    public function getDataType() {
        return User::$TABLE_NAME;
    }

    //==============================SETTERS==============================

    // Setting values for Users is done via the updateObject method.

}
