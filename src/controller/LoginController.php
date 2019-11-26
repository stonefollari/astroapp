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
 * @author: Gabriel H.C.O., Michael Follari
 * 
 * Last updated: 11/26/2019
 */
class LoginController extends Controller {

    public function login($_error=false) {

        // If user is already logged in.
        if( isset($_SESSION['uuid']) ){
            $this->progressToNextPage();
            return;
        }

        $this->view('\login\login', [])->render();
    }

    /**
     * Handles POST values for an attempted login.
     * If credentials valid, the user is progressed to the next page.
     */
    public function attemptLogin() {
        if( isset($_POST)){
            $_username = $_POST['username'];
            $_password = $_POST['password'];
        }else{
            $this->login();
            return;
        }

        // Must clean all of this, still.
        $dataArray = array(
            'username' => $_username,
            'password' => $_password,
        );

        // $this->model('user');
        // Check the credentials passed. If crednetials are valid, sign user in.
        if (!User::usernameExists($dataArray['username'])) {
            $this->view('\login\login', array('error' => "This username does not exist."))->render();
            return;
        } else if (!User::checkCredentials($dataArray)) {
            $this->view('\login\login', array('error' => "Invalid username/password."))->render();
            return;
        } else if (User::checkCredentials($dataArray)) {
            // Log in the user and render the next page.
            User::loginUser($dataArray);
            $this->progressToNextPage();
            return;
        } else {
            // Render the login view with unexpected error.
            $this->view('\login\login', array('error'=>'Unexpected error. Please try again.'))->render();
            return;
        }
    }

    /**
     * Logs the user out, ends the session.
     */
    public function logout() {
        Application::endSession();
        $this->login();
    }

    /**
     * Function to render the page progressed to.
     */
    private function progressToNextPage() {
        $this->view('\location\setLocation')->render();
    }
}
