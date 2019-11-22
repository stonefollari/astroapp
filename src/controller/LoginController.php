<?php

/*
 * This is the login controller.
 * All user-side actions will be dealt with using this class.
 * This class should make use of the model named 'login'.
 * This model contains the methods related to account inputs.
 * To declare the model in this class:
 * -----------------------------------
 * $this->model('modelName');
 * -----------------------------------
 * To declare the view related to the method:
 * -----------------------------------
 * $this->view('\viewFolder\viewFile', []);
 * $this->view->render();
 * 
 * @author: Gabriel H.C.O.
 * 
 * Last updated: 10/19/2019
 */
class LoginController extends Controller {

    public function login() {
        $this->view('\login\login', []);
        $this->view->render();
    }

    public function checkUserActive() {
        $_userName = $_POST['username'];
        $_password = $_POST['password'];
        $this->model('account');
        if ($this->model->checkCredentials($_userName, $_password)) {
            $this->view('\home\3dTestBed');
            $this->view->render();
        } else {
            $this->view('\login\badLogin');
            $this->view->render();
        }
    }

}
