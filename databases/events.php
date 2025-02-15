<?php
declare(strict_types=1);
require_once INCLUDES_DIR . "/db.php"; 
require_once DATABASE_DIR. "/users.php";

class Events {
    private $db;
    private $users;

    public function __construct() {
        $this->db = new DB();
        $this->users = new Users();
    }
    public function isOwnerEvent(string $username, int $eID): bool {       
        
        $conn = $this->db->getConnection();
    
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
    
    public function isUserInEvent(string $uName, int $eID): bool {
        $conn = $this->db->getConnection();
        $uid = $this->users->getUserIDByName($uName);
        $query = "SELECT 1 FROM history WHERE uid = ? AND eid = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $uid, $eID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    
    
    public function isCheckInOpen(int $eID):bool {
        $conn = $this->db->getConnection();
        $query = "SELECT 1 FROM events WHERE checkIn = 1 AND eid = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",$eID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    
    public function getEventName(int $eID): string {
        $conn = $this->db->getConnection();
        $query = "SELECT event_name FROM events WHERE checkIn = 1 AND eid = ? LIMIT 1";
        $stmt = $conn->prepare($query);
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
        $conn = $this->db->getConnection();
        $uid = $this->users->getUserIDByName($uName);
        $query = "SELECT checkIn FROM history WHERE eid = ? AND uid = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $eID, $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    public function getEventStatus($eid): string {
        $conn = $this->db->getConnection();
        $query = "SELECT status FROM events WHERE id = ?";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $eid);
            $stmt->execute();
            $stmt->bind_result($status);
            
            if ($stmt->fetch()) {
                switch ($status) {
                    case 0:
                        return "รับสมัคร";
                    case 1:
                        return "กิจกรรมกำลังเริ่ม";
                    case 2:
                        return "กิจกรรมจบ";
                    default:
                        return "สถานะไม่รู้จัก";
                }
            }
        }
        
        return "ไม่พบกิจกรรม";
    }
    
}
