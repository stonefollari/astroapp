<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homeController
 *
 * @author Admin
 */
class homeController extends Controller {
    public function viewStars() {
        $this->view('\home\3dTestBed');
        $this->view->render();
    }
}
