<?php

/**
 * Defines interface for all data object types.
 * Common functions used in database connectors.
 *
 * @author Michael Follari
 *
 * Last Updated: 11/11/19
 */
Interface DataObject{

    public function getValuePairs();

    public function insertObject();

    public function readObject();

    public function updateObject();

    public function destroyObject();

    public function restoreObject();

    public function createTable();

}

?>