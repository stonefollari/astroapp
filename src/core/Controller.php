<?php
/**
 * Description of Controller
 * 
 * Controller base class.
 *
 * @author Gabriel
 */
class Controller {

    protected $view;
    protected $model;

    public function view($viewName, $data = []) {
        $this->view = new View($viewName, $data);
        return $this->view;
    }

}
