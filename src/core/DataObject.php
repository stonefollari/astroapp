<?php

/**
 * Defines required functions and variables for all data object types.
 * Defines CRUD operations used on DatabaseAdapter.
 *
 * @author Michael Follari
 *
 * Last Updated: 11/19/19
 */
class DataObject {

    protected $DATA_TYPE = 'data';
    private static $TABLE_NAME = 'data';

    public function createObject(){
        // Call the database adapter create function with key value pairs for users.
        DatabaseAdapter::createObject($this->dataArray(), $this->DATA_TYPE);
    }

    public function readObject($_cond=null){
        // Call the database adapter read function with key value pairs for users.
        $readObject = DatabaseAdapter::readObject($this->dataArray(), $this->DATA_TYPE, $_cond);
        return $readObject;
    }

    public function updateObject(){
        // Call the database adapter update function with key value pairs for users.
        DatabaseAdapter::updateObject($this->dataArray(), $this->DATA_TYPE);
    }

    public function destroyObject(){
        // Call the database adapter destroy function with key value pairs for users.
        DatabaseAdapter::destroyObject($this->dataArray(), $this->DATA_TYPE);
    }

    public function restoreObject(){
        // Call the database adapter restore function with key value pairs for users.
        DatabaseAdapter::restoreObject($this->dataArray(), $this->DATA_TYPE);
    }
}
?>