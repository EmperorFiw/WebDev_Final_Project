<?php
declare(strict_types=1);

function getUserIDByName(string $uName): int {       
    $db = new db();
    $conn = $db->getConnection();

    $query = "SELECT uid 
              FROM users
              WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $uName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        return $row['uid'];
    }

    return -1;
}

function getNameByID(int $uID): string {       
    $db = new db();
    $conn = $db->getConnection();

    $query = "SELECT username 
              FROM users
              WHERE uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $uID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        return $row['username'];
    }

    return "NULL";
}

function updateUsersInt(string $column, int $values, int $uid): bool {
    $db = new db();
    $conn = $db->getConnection();
    $query = "UPDATE users SET $column = ? WHERE uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii",$values, $uid);
    return $stmt->execute();
}
