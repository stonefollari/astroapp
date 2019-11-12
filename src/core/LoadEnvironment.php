<?php

/**
 * Class to load thje environemnt, including autoloader
 * and loading environment variables.
 * 
 * @author Michael Follari
 * 
 * Last Updated: 11/11/19
 */
class LoadEnvironment {

    // Array of possible .env paths. Order should be from most likely to least (first come, first serve basis).
    private static $envFilePaths = array(
        ROOT . DIRECTORY_SEPARATOR . '.env',
        ROOT . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . '.env',
        ROOT . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . '.env',
        ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . '.env',
        ROOT . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . '.env',
    ); 

    /**
     * Loads the environment variables from the included file into putenv.
     * Access the environment variables with getenv('varname').
     */
    public static function loadEvironmentVariables($_file=null) {

        // If no file is specified, try to find .env file.
        if($_file === null) {
            $_file = LoadEnvironment::findEnvFile();
        }

        // Throw exception if file is not found.
        if ( !file_exists($_file) ) {
            throw new Exception('Environment Variable File not found.');
        }

        // Opening file.
        try {
    
            // Read in the file.
            $envFile = fopen($_file, "r");
            //Throw exception if file not opened.
            if ( !$envFile ) {
                throw new Exception('Environment Variable File failed to open.');
            }  

            // Loop through each line of the file, parsing each line to a new environment variable.
            while( !feof($envFile) ) {

                // Get new line and parse.
                $envLine = fgets($envFile);
                LoadEnvironment::parseEnvVar($envLine);
            }
            // Close the file.
            fclose($envFile);
    
        }catch( Exception $e ) {
            throw $e;
        }       

    }

    /**
     * Parses a single line from the environment variable file into putenv
     */
    private static function parseEnvVar($_line) {
        // Only process the line if it is not empty/null.
        if( $_line !== PHP_EOL && $_line !== null && $_line != '' ) {
           
            // Parse the name and value into seperate variables.
            $name = trim( strtok($_line, '=') );
            $value = trim( strtok(PHP_EOL) );

            // Put the name value pairs into env and $_ENV
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }

    /**
     * Searches pre-defined (anticipated) locations for an .env file.
     * If an .env file is found, the file path is returned.
     */
    private static function findEnvFile(){

        // Loop through array of possible environment file paths.
        foreach( LoadEnvironment::$envFilePaths as $filePath ){

            // If an environment file is found, return the path.
            if ( file_exists($filePath) ) {
                return $filePath;
            }
        }
    }
}

?>