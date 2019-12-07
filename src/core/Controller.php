<?php

/**
 *
 * Controller base class.
 *
 * @author Gabriel
 * Last updated: 09/20/2019
 */
class Controller {

    protected $view;
    protected $model;

    public function view($viewName, $data = []) {
        $this->view = new View($viewName, $data);
        return $this->view;
    }

    public function model($modelName, $data = []) {
        if (file_exists(MODEL . $modelName . '.php')) {
            require MODEL . $modelName . '.php';
            $this->model = new $modelName;
        }
    }

}
