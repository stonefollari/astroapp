<?php

/*
 * This is the account model.
 * All of the account controller's methods may make use of this class.
 * This model has the follow structure:
 * -----------------------------------
 *  firstName
 *  lastName
 *  userName
 *  password
 *  uuid
 *  active status
 *  dataBase (dataFile)
 * ------------------------------------
 * It also contains the following methods:
 * ------------------------------------
 * createNewUser($_firstName, $_lastName, $_email, $_password)
 * uploadUserToDB()
 * deleteUser($_username, $_password)
 * checkCredentials($_username, $_password)
 * isUserActive($_username)
 * ------------------------------------
 * These methods should be accessible from the account controller.
 * @author Gabriel H.C.O.
 */

class account {

    protected $firstName = "";
    protected $lastName = "";
    protected $userName = "";
    protected $password;
    protected $uuid;
    protected $status = false;
    protected static $dataFile;

    /*
     * Determines the DATA (dataBase) that will be used to store the new account.
     */

    public function __construct() {
        self::$dataFile = DATA . 'account.csv';
    }

    /*
     * This model function creates a new user by passing in the user paramenters.
     * It should also create a uuid, hashed. So far it uses the user email as uuid.
     * It then uploads the user to the database.
     */

    public function createNewUser($_firstName, $_lastName, $_email, $_password) {
        $this->firstName = $_firstName;
        $this->lastName = $_lastName;
        $this->userName = $_email;
        $this->password = $_password;
        $this->uuid = $_email;
        $this->status = true;
        $this->uploadUserToDB();
        return true;
    }

    /*
     * This function will take the model's parameters and upload a new user
     * to the database. So far the dataBase is a .csv file in the data folder.
     */

    public function uploadUserToDB() {
        $line = array($this->firstName, $this->lastName, $this->userName, $this->password, $this->uuid, $this->status);
        $handle = fopen(DATA . 'account.csv', "a");
        fputcsv($handle, $line);
        fclose($handle);
    }

    /*
     * This function, although called delete, simply sets the user active status
     * to false, but maintains the user in the database for future use.
     */

    public function deleteUser($_username, $_password) {
        if (($handle = fopen(DATA . 'account.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[2] == $_username && $data[3] == $_password) {
                    $data[5] = false;
                    return true;
                }
                return false;
            }
            fclose($handle);
        }
    }

    /*
     * This is the function used to login an existent user. It simply looks for
     * the user in the .csv file and return true if the user exists.
     */

    public function checkCredentials($_username, $_password) {
        if (($handle = fopen(DATA . 'account.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[2] == $_username && $data[3] == $_password) {
                    if ($data[5] == true) {
                        return true;
                    }
                    return false;
                }
            }
            fclose($handle);
        }
    }

    /*
     * This function checks to see if the user is currently active (did not delete
     * the account). It looks for the status in the .csv file.
     */

    public function isUserActive($_username) {
        if (($handle = fopen(DATA . 'account.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[2] == $_username) {
                    if ($data[5] == true) {
                        return true;
                    }
                    return false;
                }
            }
            fclose($handle);
        }
    }

    public function validateEmail() {
        if (!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

}
