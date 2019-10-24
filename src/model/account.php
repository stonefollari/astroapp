<?php

class account {

    protected $firstName = "";
    protected $lastName = "";
    protected $userName = "";
    protected $password;
    protected $uuid;
    protected $status = false;
    protected static $dataFile;

    public function __construct() {
        self::$dataFile = DATA . 'account.csv';
    }

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

    public function uploadUserToDB() {
        $line = array($this->firstName, $this->lastName, $this->userName, $this->password, $this->uuid, $this->status);
        $handle = fopen(DATA . 'account.csv', "a");
        fputcsv($handle, $line);
        fclose($handle);
    }

    public function deleteUser($_username, $_password) {
        if (($handle = fopen(DATA . 'account.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($data[2] == $_username && $data[3] == $_password) {
                    $data[5] = false;
                    return true;
                }
            }
            fclose($handle);
        }
    }
    
    public function isUserActive($_username, $_password) {
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

}
