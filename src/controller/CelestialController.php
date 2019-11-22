<?php
/**
 * This is just a test controller for the celestial function acquireAllCoordinates(lat, long)
 * 
 * @author Gabriel H.C.O.
 * 
 * Last updated: 10/19/2019
 */
class CelestialController extends Controller {

    public function getConstellation() {
        $this->model('Coordinates');
        return var_dump($this->model->acquireAllCoordinates(0, 0));
    }

}
