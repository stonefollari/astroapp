<?php

/**
 * This class extends Controller
 * It has two methods [createAccount() and login()]
 * These methods addresses the respective views.
 *
 * @author Gabriel
 */
class accountController extends Controller {

    public function createAccount() {
        $this->view('\account\createAccount', []);
        $this->view->render();
    }

    public function login() {
        $this->view('home\login', []);
        $this->view->render();
    }

}
