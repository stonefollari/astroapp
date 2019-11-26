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

    /**
     * Attemps account creation with post values.
     * Checks password matching, legal user/pass, and that username is not taken.
     */
    public function createUserAccount() {

        // Check if the page was accessed with a POST.
        if (isset($_POST)) {
            // Postfield input data from the user form.
            $_username = $_POST["username"];
            $_firstName = $_POST['firstName'];
            $_lastName = $_POST['lastName'];
            $_email = $_POST['email'];
            $_password = $_POST['password'];
            $_passwordConfirm = $_POST['passwordConfirm'];
        }else{
            $this->view('\account\createAccount')->render();
        }

        // Must clean all of this, still.
        $dataArray = array(
            'username' => $_username,
            'firstname' => $_firstName,
            'lastname' => $_lastName,
            'email' => $_email,
            'password' => $_password,
        );

        // Check bad signs, and return proper view. If all is valid, create the object and render the login screen.
        if ($_password !== $_passwordConfirm) {
            $this->view('\account\createAccount', array('error' => "Supplied passwords do not match."))->render();
        } else if (User::usernameExists($dataArray['username'])) {
            $this->view('\account\createAccount', array('error' => "This username is already taken."))->render();
        } else if (!User::legalParams($dataArray)) {
            $this->view('\account\createAccount', array('error' => "Invalid username/password."))->render();
        } else {
            // Create a user object (insert into database).
            User::createNewUser($dataArray);
            // Render the login view.
            $this->view('\login\login')->render();
        }

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
