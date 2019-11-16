<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adapter
 *
 * @author Gabriel
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
