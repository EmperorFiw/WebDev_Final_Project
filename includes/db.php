<?php

class db {
    private $hostname = 'localhost';
    private $dbName = 'fp2025';
    private $username = 'root';
    private $password = '';

    public function getConnection(): mysqli
    {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    
}

require_once DATABASE_DIR. "/users.php";
require_once DATABASE_DIR. "/events.php";
require_once DATABASE_DIR. "/statistics.php";