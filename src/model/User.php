<?php

/**
 * User class.
 * Used in creating new users, updating a users values, and inserting into database via DatabaseAdapter.
 */
class User extends DataObject {

    protected $DATA_TYPE = 'users';
    private static $TABLE_NAME = 'users';

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
     * Checks if a user with username already exists.
     */
    public function usernameExists() {
        $cond = "`username` = '$this->username'";
        $result = $this->readObject($cond);
        
        if( $result ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Checks to see if all nessecary parameters and present and legal.
     */
    public function legalParams() {
        $username = $this->username !== null;
        $pass = $this->password !== null;
        if( $username && $pass) {
            return true;
        }else{
            return false;
        }
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
     * Sets the values for each class variable.
     */
    private function setValues($_valuePairs) {

        $this->id = $this->extractValue($_valuePairs, 'id');
        $this->uuid = $this->extractValue($_valuePairs, 'uuid');
        $this->active = $this->extractValue($_valuePairs, 'active');
        $this->deleted = $this->extractValue($_valuePairs, 'deleted');
        $this->timestamp = $this->extractValue($_valuePairs, 'timestamp');

        $this->username = $this->extractValue($_valuePairs, 'username');
        $this->email = $this->extractValue($_valuePairs, 'email');
        $this->firstname = $this->extractValue($_valuePairs, 'firstname');
        $this->lastname = $this->extractValue($_valuePairs, 'lastname');
        $this->phone = $this->extractValue($_valuePairs, 'phone');
        $this->password = $this->extractValue($_valuePairs, 'password');
        $this->location = $this->extractValue($_valuePairs, 'location');
    }

    /**
     * Returns the key value if set, null otherwise.
     */
    private function extractValue($_valuePairs, $_key) {
        
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

    //=================GETTERS===============
    
    /**
     * Returns the key,value pairs for the object.
     */
    public function getValues() {
        return 'WIP, chill ur roll lil bud';
    }

    public function getDataType() {
        return User::$TABLE_NAME;
    }

}
