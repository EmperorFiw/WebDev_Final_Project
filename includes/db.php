<?php

class db {
    private $hostname = 'localhost';
    private $dbName = 'fp2025';
    private $username = 'final';
    private $password = 'FP2025';

    public function getConnection(): mysqli
    {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    
}
