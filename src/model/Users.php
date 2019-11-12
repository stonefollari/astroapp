<?php
class Users extends DataObject {

    private $DATA_TYPE = 'users';

    private $username;
    private $email;
    private $firstname;
    private $lastname;
    private $phone;
    private $password;
    private $location;

    // Possible future implementaion for conditional sharing / storing of certain fields.
    private $privateKeys = array('password');
    private $dontStoreKeys = array();

    public function __construct($_valuePairs){

        // Set the class variables with the input array.
        $this::setValues($_valuePairs);

        // If uuid is not set, set one.
        if( $this->uuid == null){
            $this->uuid = uniqid();
        }

        // Insert the class variables into the valuePairs array.
        $this::reloadValuePairs();
    }

    /**
     * Returns the key,value pairs for the object.
     */
    public function getValues(){
        return 'WIP, chill ur roll lil bud';
    }

    /**
     * Sets the value of valuePairs array.
     * Should contain all key, value pairs; such as array returnred from database call.
     */
    private function setValuePairs($_valuePairs){
        $this::$valuePairs = $_valuePairs;
    }

    /**
     * Reloads the values from the class variables into the valuePairs array.
     */
    private function reloadValuePairs(){
        $valuePairs = array(
            'id'=>$this::$id,
            'uuid'=>$this::$uuid,
            'username'=>$this::$username,
            'email'=>$this::$email,
            'firstname'=>$this::$firstname,
            'lastname'=>$this::$lastname,
            'phone'=>$this::$phone,
            'password'=>$this::$password,
            'location'=>$this::$location,
            'active'=>$this::$active,
            'time_delete'=>$this::$time_delete,
            'timestamp'=>$this::$timestamp
        );
    }

    /**
     * Sets the values for each class variable.
     */
    private function setValues($_valuePairs){
        $this->id = $this::extractValue($_valuePairs, 'id');
        $this->uuid = $this::extractValue($_valuePairs, 'uuid');
        $this->username = $this::extractValue($_valuePairs, 'username');
        $this->email = $this::extractValue($_valuePairs, 'email');
        $this->firstname = $this::extractValue($_valuePairs, 'firstname');
        $this->lastname = $this::extractValue($_valuePairs, 'lastname');
        $this->phone = $this::extractValue($_valuePairs, 'phone');
        $this->password = $this::extractValue($_valuePairs, 'password');
        $this->location = $this::extractValue($_valuePairs, 'location');
        $this->active = $this::extractValue($_valuePairs, 'active');
        $this->time_delete = $this::extractValue($_valuePairs, 'time_delete');
        $this->timestamp = $this::extractValue($_valuePairs, 'timestamp');
    }

    /**
     * Returns the key value if set, null otherwise.
     */
    private function extractValue($_valuePair, $_key){
        
        // If value exists, return it.
        if( isset($_valuePairs[$_key]) ){
            return $_valuePairs[$_key];
        
            // If key value pair is not set, return null.
        }else{
            return null;
        }
    }
}
