<?php

/**
 *  This is a generic adapter with general object operations. 
 *
 * @author Gabriel
 * 
 * Last updated: 11/11/2019
 */
interface Adapter {

    /**
     * Calls the SQL connections's createObject function.
     */
    public static function createObject($_data, $_dbTable);

    /**
     * Calls the SQL connections's readObject function.
     */
    public static function readObject($_data, $_dbTable);

    /**
     * Calls the SQL connections's updateObject function.
     */
    public static function updateObject($_data, $_dbTable);

    /**
     * Calls the SQL connections's destroyObject function.
     */
    public static function destroyObject($_data, $_dbTable);
}
