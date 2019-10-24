<?php

/**
 * Description of formParser
 *
 * @author Admin
 */
class formParser {

    public function __construct() {
        
    }

    public function formParser($prams) {
        $searchFor = array("country", "state", "city", "=", "?", "+");
        $replaceWith = array("", "", "", "", "", " ");
        $pieces = str_replace($searchFor, $replaceWith, $prams);
        $pieces = explode("&", $pieces);
        return $pieces;
    }

}
