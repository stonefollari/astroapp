<?php

/**
 * Description of homeController
 *
 * @author Gabriel
 */
class homeController extends Controller {

    public function viewStars() {
        $this->view('\home\3dTestBed');
        $this->view->render();
    }

    public function display($_lat, $_long) {
        $this->model('Coordinates');
        echo $this->model->acquireAllCoordinates(urldecode($_lat), urldecode($_long));
    }

}
