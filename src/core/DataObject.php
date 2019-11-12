<?php

/**
 * Defines interface for all data object types.
 * Common functions used in database connectors.
 *
 * @author Michael Follari
 *
 * Last Updated: 11/11/19
 */
class DataObject {

    private $DATA_TYPE;
    
    private $id;
    private $uuid;
    private $active;
    private $deleted;
    private $timestamp;
    private $valuePairs;

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

}

?>