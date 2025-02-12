<?php
declare(strict_types=1);

function isOwnerEvent(string $username, int $eID): bool {       
    $db = new db();
    $conn = $db->getConnection();

    $query = "SELECT u.username 
              FROM events e
              JOIN users u ON e.oID = u.ID
              WHERE e.ID = ? AND u.username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $eID, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        return true;
    }

    return false;
}
