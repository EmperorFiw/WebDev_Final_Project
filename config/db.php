<?php

class db {
    function getConnection():mysqli
    {
        $hostname = 'localhost';
        $dbName = 'fp2025';
        $username = 'final';
        $password = 'FP2025';
        $conn = new mysqli($hostname, $username, $password, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}
