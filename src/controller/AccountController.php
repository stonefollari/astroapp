<?php

/*
 * This is the account controller.
 * All user-side actions will be dealt with using this class.
 * This class should make use of the model named 'account'.
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
 * Last updated: 11/19/2019
 */

class AccountController extends Controller {
    /*
     * This controller function is to be called when the create account view
     * is to be rendered.
     */

    public function createAccount() {
        $this->view('\account\createAccount', []);
        $this->view->render();
    }

    /*
     * This controller function is to be called when the delete account view
     * is to be rendered.
     */

    public function deleteAccount() {
        $this->view('\account\deleteAccount', []);
        $this->view->render();
    }

    /*
     * This controller function will call the model and perform the create user
     * operation in the database. So far the database is a .csv file but it will
     * change to the SQL, so this is a dummy method to test logic components.
     */

    public function createUserAccount() {

        if (isset($_POST)) {
            // Postfiled input data from the user form.
            $_username = $_POST["username"];
            $_firstName = $_POST['firstName'];
            $_lastName = $_POST['lastName'];
            $_email = $_POST['email'];
            $_password = $_POST['password'];
            $_passwordConfirm = $_POST['passwordConfirm'];
        }

        // Must clean all of this, still.
        $dataArray = array(
            'username' => $_username,
            'firstname' => $_firstName,
            'lastname' => $_lastName,
            'email' => $_email,
            'password' => $_password,
        );

        // Create a user object.
        $user = new User($dataArray);

        // Check bad signs, and return proper view. If all is good, create the object and return login screen.
        if (true) {
            echo '';
        }
        if ($_password !== $_passwordConfirm) {
            $this->view('\account\createAccount', array('error' => "Supplied passwords do not match."))->render();
        } else if ($user->usernameExists()) {
            $this->view('\account\createAccount', array('error' => "This username is already taken."))->render();
        } else if (!$user->legalParams()) {
            $this->view('\account\createAccount', array('error' => "Illegal username/password."))->render();
        } else {
            $user->createObject();
            $this->view('\login\login')->render();
        }

        // Render the login view.
        //$this->view('\login\login')->render();
        // if ($_password1 == $_password2 && !$this->model->isUserActive($_email)) {
        //     if ($this->model->createNewUser($_firstName, $_lastName, $_email, $_password1)) {
        //         $this->view('\login\login');
        //         $this->view->render();
        //     }
        // } else {
        //     $this->view('\account\badEmail');
        //         $this->view->render();
        // }
        // $this->model('account');
        // $_firstName = $_POST['firstName'];
        // $_lastName = $_POST['lastName'];
        // $_email = $_POST['email'];
        // $_password1 = $_POST['password1'];
        // $_password2 = $_POST['password2'];
        // if ($_password1 == $_password2 && !$this->model->isUserActive($_email)) {
        //     if ($this->model->createNewUser($_firstName, $_lastName, $_email, $_password1)) {
        //         $this->view('\login\login');
        //         $this->view->render();
        //     }
        // } else {
        //     $this->view('\account\badEmail');
        //         $this->view->render();
        // }
    }

    /*
     * This controller function will call the model and perform the delete user
     * operation in the database. So far the database is a .csv file but it will
     * change to the SQL, so this is a dummy method to test logic components.
     */

    public function deletUserAccount() {
        $_userName = $_POST['username'];
        $_password = $_POST['password'];
        $this->model('account');
        if ($this->model->deleteUser($_userName, $_password)) {
            header("Location: http://localhost/login/login/");
        } else {
            //TODO : Account does not exist.
        }
    }

}
