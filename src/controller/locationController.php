<?php

//This is the actual Location Controller Class
class locationController extends Controller {

    public function setLocation() {
        $this->model('location');
        $this->view('\location\setLocation', []);
        $this->view->render();
    }
    public function formParser($prams) {
        $this->model('formParser');
        $array = $this->model->formParser($prams); 
        $this->view('\home\3dTestBed');
        $this->view->render();
        return $array; 
    }
    public function getLocationID($arrayLocation) {
        $this->model('location');
        return $this->model->getLocationID($arrayLocation[0], $arrayLocation[1], $arrayLocation[2]);
    }

    public function getLatLong($ID) {
        $this->model('location');
        return $this->model->getLatLong($ID);
    }
}
