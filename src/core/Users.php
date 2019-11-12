<?php
namespace AstroApp\Web\Prot\Priv\Reprositories;

use AstroApp\Web\Prot\Priv\Entities;

class Users implements DataObject{

    private $DATA_TYPE = 'users';

    private $id;
    private $uuid;
    private $username;
    private $email;
    private $firstname;
    private $lastname;
    private $phone;
    private $password;
    private $location;
    private $active;
    private $time_delete;
    private $timestamp;
    private $valuePairs;

    private $publicKeys = array();
    private $dontStoreKeys = array();

    public function __construct($_valuePairs){

        // Set the class variables with the input array.
        $this::setValues($_valuePairs);

        // Insert the class variables into the valuePairs array.
        $this::reloadValuePairs();
    }

    public function createTable(){
        $valuePairs = $this::getValuePairs();
        DatabaseAdapter::createTable($valuePairs, $DATA_TYPE);
    }

    public function createObject(){

        // Call the database adapter create function with key value pairs for users.
        $valuePairs = $this::getValuePairs();
        DatabaseAdapter::createObject($valuePairs, $DATA_TYPE);
    }

    public function readObject(){

        // Call the database adapter read function with key value pairs for users.
        $valuePairs = $this::getValuePairs();
        $readObject = DatabaseAdapter::readObject($valuePairs, $DATA_TYPE);

    }

    public function updateObject(){

        // Call the database adapter update function with key value pairs for users.
        $valuePairs = $this::getValuePairs();
        DatabaseAdapter::updateObject($valuePairs, $DATA_TYPE);
    }

    public function destroyObject(){

        // Call the database adapter destroy function with key value pairs for users.
        $valuePairs = $this::getValuePairs();
        DatabaseAdapter::destroyObject($valuePairs, $DATA_TYPE);
    }

    public function restoreObject(){

        // Call the database adapter restore function with key value pairs for users.
        $valuePairs = $this::getValuePairs();
        DatabaseAdapter::restoreObject($valuePairs, $DATA_TYPE);
    }

    public function getValues(){
        return 'WIP, chill ur roll lil bud';
    }


    private function setValuePairs($_valuePairs){
        $this::$valuePairs = $_valuePairs;
    }
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
    private function setValues($_valuePairs){
        $id = $this::extractValue($_valuePairs, 'id');
        $uuid = $this::extractValue($_valuePairs, 'uuid');
        $username = $this::extractValue($_valuePairs, 'username');
        $email = $this::extractValue($_valuePairs, 'email');
        $firstname = $this::extractValue($_valuePairs, 'firstname');
        $lastname = $this::extractValue($_valuePairs, 'lastname');
        $phone = $this::extractValue($_valuePairs, 'phone');
        $password = $this::extractValue($_valuePairs, 'password');
        $location = $this::extractValue($_valuePairs, 'location');
        $active = $this::extractValue($_valuePairs, 'active');
        $time_delete = $this::extractValue($_valuePairs, 'time_delete');
        $timestamp = $this::extractValue($_valuePairs, 'timestamp');
    }

    private function extractValue($_valuePair, $_key){
        return $_valuePairs[$_key];
    }
}
