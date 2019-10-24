<?php

/**
 * Description of loginController
 *
 * @author Gabriel
 */
class loginController extends Controller {

    public function login() {
        $this->view('\login\login', []);
        $this->view->render();
    }

    public function checkUserActive() {
        $_userName = $_POST['username'];
        $_password = $_POST['password'];
        $this->model('account');
        if ($this->model->isUserActive($_userName, $_password)) {
            $this->view('\home\3dTestBed');
            $this->view->render();
        } else {
            $this->view('\login\badLogin');
            $this->view->render();
        }
    }

}
