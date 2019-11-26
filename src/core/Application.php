<?php

/**
 * This is the Application class that starts when you first open the site.
 *
 * @author Gabriel
 * 
 * Last updated: 09/20/2019
 */
class Application {

    protected $controller = 'loginController';
    protected $action = 'login';
    protected $prams = [];

    /*
     * This determines the controller that the URL passes in.
     * It is passed as /controller/method in the parsing.
     */

    public function __construct() {

        // Start session.
        Application::startSession();

        $this->parseURL();
        //Determines if the controller exists.
        if (file_exists(CONTROLLER . $this->controller . '.php')) {
            $this->controller = new $this->controller;
            //Determine if the method exists within that controller.
            if (method_exists($this->controller, $this->action)) {
                call_user_func_array([$this->controller, $this->action], $this->prams);
            } else {
                header('Location: http://localhost/');
            }
        } else {
            header('Location: http://localhost/');
        }
    }

    /**
     * Starts the session.
     */
    public static function startSession() {
        session_start();
    }

    /**
     * Ends the session; creates a new one immediately after.
     */
    public static function endSession(){
        // Destroy the current session.
        session_destroy();
        // Restart a new session.
        Application::startSession();
    }

    /*
     * This parses the URL to send it to the right controller.
     */

    protected function parseURL() {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        if (!empty($request)) {
            $url = explode('/', $request);
            $this->controller = isset($url[0]) ? $url[0] . 'Controller' : 'loginController';
            $this->action = isset($url[1]) ? $url[1] : 'login';
            unset($url[0], $url[1]);
            $this->prams = !empty($url) ? array_values($url) : [];
        }
    }

}
