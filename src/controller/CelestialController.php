<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of celestialController
 *
 * @author Admin
 */
class celestialController extends Controller {

    public function getConstellation() {
        $this->model('Coordinates');
        return var_dump($this->model->acquireAllCoordinates(0, 0));
    }

}
