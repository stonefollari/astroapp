<?php

/**
 * This is the controller for the main JavaScrip engine that renders the
 * constellation's display.
 * This model contains the methods related to the main display.
 * To declare the model in this class:
 * -----------------------------------
 * $this->model('modelName');
 * -----------------------------------
 * To declare the view related to the method:
 * -----------------------------------
 * $this->view('\viewFolder\viewFile', []);
 * $this->view->render();
 * 
 * @author Gabriel H.C.O.
 * 
 * Last updated: 11/19/2019
 */
class homeController extends Controller {

    public function viewStars() {
        $this->view('\home\ViewStars');
        $this->view->render();
    }

    public function display($_lat, $_long) {
        $this->model('Coordinates');
        echo $this->model->acquireAllCoordinates(urldecode($_lat), urldecode($_long));
    }

}
