<?php
declare(strict_types=1);
require_once INCLUDES_DIR . "/db.php"; 
require_once DATABASE_DIR. "/users.php";

class Events {
    private $db;
    private $users;
    private $conn;

    public function __construct() {
        $this->db = new DB();
        $this->conn = $this->db->getConnection();
        $this->users = new Users();
    }
    public function isOwnerEvent(string $username, int $eID): bool {       
        $query = "SELECT u.username 
                  FROM events e
                  JOIN users u ON e.oID = u.ID
                  WHERE e.ID = ? AND u.username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('is', $eID, $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $row = $result->fetch_assoc()) {
            return true;
        }
    
        return false;
    }
    
    public function isUserInEvent(string $uName, int $eID): bool {
        $uid = $this->users->getUserIDByName($uName);
        $query = "SELECT 1 FROM history WHERE uid = ? AND eid = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $uid, $eID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    
    
    public function isCheckInOpen(int $eID):bool {
        $query = "SELECT 1 FROM events WHERE checkIn = 1 AND eid = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i",$eID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    
    public function getEventName(int $eID): string {
        $query = "SELECT event_name FROM events WHERE checkIn = 1 AND eid = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $eID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['event_name'];
        }
        return "NULL";
    }
    
    public function isCheckInSucc(string $uName, int $eID):bool {
        $uid = $this->users->getUserIDByName($uName);
        $query = "SELECT checkIn FROM history WHERE eid = ? AND uid = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $eID, $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    public function getEventStatus($eid): string {
        $query = "SELECT status FROM events WHERE eid = ?";
        
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("i", $eid);
            $stmt->execute();
            $stmt->bind_result($status);
            
            if ($stmt->fetch()) {
                switch ($status) {
                    case 0:
                        return "ปิดรับสมัคร";
                    case 1:
                        return "เปิดรับสมัคร";
                    case 2:
                        return "กิจกรรมจบแล้ว";
                    default:
                        return "สถานะไม่รู้จัก";
                }
            }
        }
        
        return "ไม่พบกิจกรรม";
    }

    public function getAllEvents(): array {
        $query = "SELECT * FROM events";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            $events = [];
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
            return $events;
        } else {
            return [];
        }
    }
    
    public function getRegistered(int $eid): int {
        $query = "SELECT COUNT(*) AS total_registered FROM history WHERE eid = ? AND join_state = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $eid);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total_registered'] ?? 0;
    }
    
    function getEventData(string $keyword, string $date): array {
        $conditions = [];
        
        if (!empty($keyword)) {
            $conditions[] = "event_name LIKE '%" . $this->conn->real_escape_string($keyword) . "%'";
        }
        
        if (!empty($date)) {
            $conditions[] = "(event_start_date <= '$date' AND event_end_date >= '$date')";
        }
        
        $query = "SELECT * FROM events";
        
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $result = $this->conn->query($query);
    
        if ($result->num_rows > 0) {
            $events = [];
            while ($row = $result->fetch_assoc()) {
                $events[] = $row;
            }
            return $events;
        } else {
            return [];
        }
    }

    public function getEventDetails(int $eid): array {
        $query = "SELECT * FROM events WHERE eid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $eid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return [];
        }
    }
}
