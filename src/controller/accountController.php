<?php

/**
 * This class extends Controller
 * 
 * It has two methods [createAccount() and deleteAccount()].
 * These methods addresses the respective views.
 *
 * @author Gabriel
 */
class accountController extends Controller {

    public function createAccount() {
        $this->view('\account\createAccount', []);
        $this->view->render();
    }

    public function deleteAccount() {
        $this->view('\account\deleteAccount', []);
        $this->view->render();
    }

    public function createUserAccount() {
        $_firstName = $_POST['firstName'];
        $_lastName = $_POST['lastName'];
        $_email = $_POST['email'];
        $_password = $_POST['password1'];
        $this->model('account');
        if($this->model->createNewUser($_firstName, $_lastName, $_email, $_password)) {
            $this->view('\login\login');
            $this->view->render();
        }
    }
    
    public function deletUserAccount() {
        $_userName = $_POST['username'];
        $_password = $_POST['password'];
        $this->model('account');
        $this->model->deleteUser($_userName, $_password);
        header("Location: http://localhost/login/login/");
    }
    
}
