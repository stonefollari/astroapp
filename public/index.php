<?php

    // Defines the paths to different directories within the server.
    define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
    define('APP', ROOT . 'src' . DIRECTORY_SEPARATOR);
    define('VIEW', ROOT . 'src' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
    define('MODEL', ROOT . 'src' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR);
    define('DATA', ROOT . 'src' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
    define('CORE', ROOT . 'src' . DIRECTORY_SEPARATOR . 'core'. DIRECTORY_SEPARATOR);
    define('ADAPTER', ROOT. 'src' . DIRECTORY_SEPARATOR . 'adapter' . DIRECTORY_SEPARATOR);
    define('CONTROLLER', ROOT . 'src' . DIRECTORY_SEPARATOR . 'controller'. DIRECTORY_SEPARATOR);
    define('CONSTELLATION', MODEL . DIRECTORY_SEPARATOR . 'Celestial' . DIRECTORY_SEPARATOR);

    $modules = [ROOT,APP,CORE,MODEL,ADAPTER,CONTROLLER,VIEW,DATA,CONSTELLATION];

    // Add the modules to the environment / server variables for access anywhere.
    $_ENV['modules'] = $modules;
    $_SERVER['modules'] = $modules;

    // Add the modules to the include path.
    set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));

    // Call the Autoloader
    spl_autoload_register('custom_autoloader', false);

    /**
     * Custom autoloader finds and requires a class when it is called.
     */
    function custom_autoloader($_class) {

        $mods = $_ENV['modules'];
        for( $i=0; $i < count($mods); $i++) {

            $module = $mods[$i];

            $file = $module . $_class . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    // Begins the application.
    new Application();
