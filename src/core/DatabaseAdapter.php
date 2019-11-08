<?php
namespace Astroapp\Src\Controller;
use AstroApp\Src\Models as model;
use Dotenv;

require_once '..\Models\MySQLConnector.php';

/**
 * Class to bridge the connection between application and Database connection.
 */
class DatabaseAdapter{

    private $connection;
    private static $RELATIVE_ROOT = '..\..\\';

    /**
     * Establish connection the the SQL database. This cannot be done when
     * DatabaseController->connection is defined as PHP does not allow it.
     * (Static variables must be initialized to constant / literal values)
     */
    private static function connect(){
        DatabaseController::$connection = new model\MySQLConnector();

        // Switch the SQL DSN connection.
        // DatabaseController::$connection->setDSN('127.0.0.1');
    }

    /**
     * Calls the SQL connections's createObject function.
     */
    public static function createObject($_data, $_dbTable) {

        DatabaseController::connect();
        // Call connection's createObject function and return the result.
        return DatabaseController::$connection->createObject($_data, $_dbTable);

    }

    /**
     * Calls the SQL connections's readObject function.
     */
    public static function readObject($_data, $_dbTable) {

        DatabaseController::connect();
        // Call connection's readObject function and return the result.
        return DatabaseController::$connection->readObject($_data, $_dbTable);

    }

    /**
     * Calls the SQL connections's updateObject function.
     */
    public static function updateObject($_data, $_dbTable) {

        DatabaseController::connect();
        // Call connection's updateObject function and return the result.
        return DatabaseController::$connection->updateObject($_data, $_dbTable);

    }

    /**
     * Calls the SQL connections's destroyObject function.
     */
    public static function destroyObject($_data, $_dbTable) {

        DatabaseController::connect();
        // Call connection's destroyObject function and return the result.
        return DatabaseController::$connection->destroyObject($_data, $_dbTable);
    }
}
?>