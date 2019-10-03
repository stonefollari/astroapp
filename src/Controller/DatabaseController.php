<?php

namespace Astroapp\Src\Controller;
use AstroApp\Src\Models as model;
require_once '..\Models\database.php';

class DatabaseController{

    public $database;

    public function __construct(){
        $this->database = new model\Database();
    }

    public function connectToLocalSQL(){
        return $this->database->connectToLocal();
    }

    public function connectAppToSQL(){
        return $this->database->connectAppToSQL();
    }



}


?>