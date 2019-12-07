<?php

/**
 * Class to bridge the connection between application and Database connection.
 *
 * @author Michael Follari
 * Last Updated: 11/11/2019
 */
class DatabaseAdapter implements Adapter {

    private static $connection; //= new MySQLConnector();

    /**
     * Establish connection the the SQL database. This cannot be done when
     * DatabaseAdapter->connection is defined as PHP does not allow it.
     * (Static variables must be initialized to constant / literal values)
     */
    private static function connect() {
        DatabaseAdapter::$connection = new MySQLConnector();
    }

    /**
     * Calls the SQL connections's createObject function.
     */
    public static function createObject($_data, $_dbTable) {

        DatabaseAdapter::connect();
        // Call connection's createObject function and return the result.
        return DatabaseAdapter::$connection->createObject($_data, $_dbTable);

    }

    /**
     * Calls the SQL connections's readObject function.
     */
    public static function readObject($_data, $_dbTable, $_cond=null) {

        DatabaseAdapter::connect();
        // Call connection's readObject function and return the result.
        return DatabaseAdapter::$connection->readObject($_data, $_dbTable, $_cond);

    }

    /**
     * Calls the SQL connections's updateObject function.
     */
    public static function updateObject($_data, $_dbTable) {

        DatabaseAdapter::connect();
        // Call connection's updateObject function and return the result.
        return DatabaseAdapter::$connection->updateObject($_data, $_dbTable);

    }

    /**
     * Calls the SQL connections's destroyObject function.
     */
    public static function destroyObject($_data, $_dbTable) {

        DatabaseAdapter::connect();
        // Call connection's destroyObject function and return the result.
        return DatabaseAdapter::$connection->destroyObject($_data, $_dbTable);
    }
}
?>