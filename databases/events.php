<?php
declare(strict_types=1);

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
                  JOIN users u ON e.owner_id = u.uid 
                  WHERE e.eid = ? AND u.username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('is', $eID, $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->num_rows > 0;
    }
    
    public function isUserInEvent(int $uid, int $eID): bool {
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
    
    public function getTotalRegistered(int $eid): int {
        $query = "SELECT COUNT(*) AS total_registered FROM history WHERE eid = ? AND join_state = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $eid);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total_registered'] ?? 0;
    }
    
    function getEventDataByKeyword(string $keyword, string $date): array {
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

    public function getEventDataByID(int $eid): array {
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
    public function createEvent( string $event_name, int $ownerID, int $capacity, string $event_start_date, 
        string $event_end_date, string $event_start_time, string $event_end_time, string $reg_start_date,
        string $reg_end_date, string $details, string $imageData): string | int
    {
        if (!is_numeric($capacity) || $capacity <= 0) {
            return "จำนวนผู้เข้าร่วมต้องมากกว่า 0";
        }
        $event_start_time = date('H:i', strtotime($event_start_time));
        $event_end_time = date('H:i', strtotime($event_end_time));
        
        // ป้องกัน XSS
        $details = htmlspecialchars($details, ENT_QUOTES, 'UTF-8');

        // ตรวจสอบว่า imageData เป็น string หรือไม่
        $imagePathsString = is_array($imageData) ? implode(',', $imageData) : $imageData;

        // ตรวจสอบวันที่ให้ถูกต้อง
        if (!strtotime($event_start_date) || !strtotime($event_end_date) || 
            !strtotime($reg_start_date) || !strtotime($reg_end_date)) {
            return "รูปแบบวันที่ไม่ถูกต้อง";
        }

        // ตรวจสอบรูปแบบเวลา
        if (!preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $event_start_time) || 
            !preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $event_end_time)) {
            return "รูปแบบเวลาต้องเป็น(ชั่วโมง:นาที) และชั่วโมงต้องอยู่ระหว่าง 00 ถึง 23";
        }

        // ตรวจสอบความถูกต้องของช่วงเวลา
        if (strtotime($event_start_date) > strtotime($event_end_date)) {
            return "วันที่เริ่มกิจกรรมต้องไม่มากกว่าวันที่สิ้นสุดกิจกรรม";
        }

        if (strtotime($reg_start_date) > strtotime($reg_end_date)) {
            return "วันที่เริ่มลงทะเบียนต้องไม่มากกว่าวันที่สิ้นสุดการลงทะเบียน";
        }

        // if (strtotime($reg_start_date) < strtotime($event_start_date) || strtotime($reg_start_date) > strtotime($event_end_date)) {
        //     return "วันที่เริ่มลงทะเบียนต้องอยู่ภายในช่วงวันที่กิจกรรม";
        // }

        $query = "INSERT INTO events (event_name, owner_id, create_date, event_start_date, event_end_date, event_start_time, event_end_time, reg_start_date, reg_end_date, description, image, capacity) 
            VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissssssssi", $event_name, $ownerID, $event_start_date, $event_end_date, 
                        $event_start_time, $event_end_time, $reg_start_date, $reg_end_date, 
                        $details, $imagePathsString, $capacity);


        if ($stmt->execute()) {
            $eventid = $this->conn->insert_id;
            return $eventid;  // คืนค่า eventid
        }
        return "เกิดข้อผิดพลาดในการสร้างกิจกรรม";
    }

    public function updateEvent(int $event_id, string $event_name, int $ownerID, int $capacity, string $event_start_date, 
        string $event_end_date, string $event_start_time, string $event_end_time, string $reg_start_date,
        string $reg_end_date, string $details, string $imageData): string
    {
        if (!is_numeric($capacity) || $capacity <= 0) {
            return "จำนวนผู้เข้าร่วมต้องมากกว่า 0";
        }
        $event_start_time = date('H:i', strtotime($event_start_time));
        $event_end_time = date('H:i', strtotime($event_end_time));
        // ป้องกัน XSS
        $details = htmlspecialchars($details, ENT_QUOTES, 'UTF-8');

        // ตรวจสอบว่า imageData เป็น string หรือไม่
        $imagePathsString = is_array($imageData) ? implode(',', $imageData) : $imageData;

        // ตรวจสอบวันที่ให้ถูกต้อง
        if (!strtotime($event_start_date) || !strtotime($event_end_date) || 
            !strtotime($reg_start_date) || !strtotime($reg_end_date)) {
            return "รูปแบบวันที่ไม่ถูกต้อง";
        }

        // ตรวจสอบรูปแบบเวลา
        if (!preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $event_start_time) || 
            !preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $event_end_time)) {
            return "รูปแบบเวลาต้องเป็น(ชั่วโมง:นาที) และชั่วโมงต้องอยู่ระหว่าง 00 ถึง 23";
        }

        // ตรวจสอบความถูกต้องของช่วงเวลา
        if (strtotime($event_start_date) > strtotime($event_end_date)) {
            return "วันที่เริ่มกิจกรรมต้องไม่มากกว่าวันที่สิ้นสุดกิจกรรม";
        }

        if (strtotime($reg_start_date) > strtotime($reg_end_date)) {
            return "วันที่เริ่มลงทะเบียนต้องไม่มากกว่าวันที่สิ้นสุดการลงทะเบียน";
        }

        // if (strtotime($reg_start_date) < strtotime($event_start_date) || strtotime($reg_start_date) > strtotime($event_end_date)) {
        //     return "วันที่เริ่มลงทะเบียนต้องอยู่ภายในช่วงวันที่กิจกรรม";
        // }

        // ตรวจสอบว่า event_id ที่ต้องการอัพเดทมีอยู่ในฐานข้อมูลหรือไม่
        $checkQuery = "SELECT * FROM events WHERE eid = ?";
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return "ไม่พบกิจกรรมที่ต้องการอัพเดท";
        }

        // SQL สำหรับการอัพเดทกิจกรรม
        $query = "UPDATE events SET
                    event_name = ?, 
                    owner_id = ?, 
                    event_start_date = ?, 
                    event_end_date = ?, 
                    event_start_time = ?, 
                    event_end_time = ?, 
                    reg_start_date = ?, 
                    reg_end_date = ?, 
                    description = ?, 
                    image = ?, 
                    capacity = ? 
                WHERE eid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sissssssssii", $event_name, $ownerID, $event_start_date, $event_end_date, 
                        $event_start_time, $event_end_time, $reg_start_date, $reg_end_date, 
                        $details, $imagePathsString, $capacity, $event_id);

        if ($stmt->execute()) {
            return "แก้ไขกิจกรรมสำเร็จ!"; 
        }

        return "เกิดข้อผิดพลาดในการอัพเดทกิจกรรม";
    }

    public function getOwnerEventDataByUserName($username): array 
    {
        $oid = $this->users->getUserIDByName($username);
    
        $query = "SELECT * FROM events WHERE owner_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $oid);
        $stmt->execute();
    
        $result = $stmt->get_result();
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

    public function deleteEvent(int $eid): bool 
    {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE eid = ?");
        $stmt->bind_param("i", $eid);
        $success = $stmt->execute();
    
        return $success;
    }
    public function isRegisteredEvent(int $uid, int $eid) : bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM history WHERE uid = ? AND eid = ?");
        $stmt->bind_param("ii", $uid, $eid);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
    
        return $count > 0;
    }

    public function registerEvent(int $uid, int $eid, string $fname, string $lname, string $phone, int $age, string $gender, string $role): string
    {
        if ($this->isRegisteredEvent($uid, $eid))
        {
            return "คุณลงทะเบียนไปแล้ว!";
        }
        $stmt = $this->conn->prepare("INSERT INTO history (uid, eid, firstname, lastname, date_join, age, gender, tel, type) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?)");
        $stmt->bind_param("iississs", $uid, $eid, $fname, $lname, $age, $gender, $phone, $role);
        if ($stmt->execute())
        {
            return "ลงทะเบียนสำเร็จ!";
        }
        return "เกิดข้อผิดพลาดในการลงทะเบียนกิจกรรม";
    }

    public function getParticipantsByEventID(int $eid): array
    {
        $stmt = $this->conn->prepare("
        SELECT h.*, e.event_name 
        FROM history h
        JOIN events e ON h.eid = e.eid
        WHERE h.eid = ? AND h.join_state = 0
    ");
        $stmt->bind_param("i", $eid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateUserJoinState(int $eid, int $uid, int $state): string
    {
        $uname = $this->users->getUserNameByID($uid);
        
        $join_state = ($state === 1) ? 1 : 4;
        $stmt = $this->conn->prepare("UPDATE history SET join_state = ? WHERE uid = ? AND eid = ?");
        $stmt->bind_param("iii", $join_state, $uid, $eid);
    
        if ($stmt->execute()) {
            if ($state === 0) {
                return "ปฎิเสธผู้ใช้ " . $uname . " สำเร็จ!";
            } elseif ($state === 1) {
                return "อนุมัติผู้ใช้ " . $uname . " สำเร็จ!";
            }
        }
    
        return "เกิดข้อผิดพลาดในการอัปเดต!";
    }

    public function getCheckListData(int $eid): array
    {
        $query = "SELECT e.event_name, h.firstname, h.lastname, h.gender, h.age, h.tel, h.type, h.checkIn
        FROM history h 
        JOIN events e ON h.eid = e.eid 
        WHERE e.eid = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $eid);
        $stmt->execute();
    
        $result = $stmt->get_result();
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

    public function setCheckInStatus(int $eid, int $status): void
    {
        $stmt = $this->conn->prepare("UPDATE events SET checkIn = ? WHERE eid = ?");
        $stmt->bind_param("ii",  $status, $eid);
        $stmt->execute();
    }
    
    public function updateEditEvent(int $event_id, string $event_name, int $ownerID, int $capacity, string $event_start_date, 
        string $event_end_date, string $event_start_time, string $event_end_time, string $reg_start_date,
        string $reg_end_date, string $details, string $imageData): string
    {
        if (!is_numeric($capacity) || $capacity <= 0) {
            return "จำนวนผู้เข้าร่วมต้องมากกว่า 0";
        }
        $event_start_time = date('H:i', strtotime($event_start_time));
        $event_end_time = date('H:i', strtotime($event_end_time));
        // ป้องกัน XSS
        $details = htmlspecialchars($details, ENT_QUOTES, 'UTF-8');

        // ตรวจสอบว่า imageData เป็น string หรือไม่
        $imagePathsString = is_array($imageData) ? implode(',', $imageData) : $imageData;

        // ตรวจสอบวันที่ให้ถูกต้อง
        if (!strtotime($event_start_date) || !strtotime($event_end_date) || 
            !strtotime($reg_start_date) || !strtotime($reg_end_date)) {
            return "รูปแบบวันที่ไม่ถูกต้อง";
        }

        // ตรวจสอบรูปแบบเวลา
        if (!preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $event_start_time) || 
            !preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $event_end_time)) {
            return "รูปแบบเวลาต้องเป็น(ชั่วโมง:นาที) และชั่วโมงต้องอยู่ระหว่าง 00 ถึง 23";
        }

        // // ตรวจสอบความถูกต้องของช่วงเวลา
        // if (strtotime($event_start_date) > strtotime($event_end_date)) {
        //     return "วันที่เริ่มกิจกรรมต้องไม่มากกว่าวันที่สิ้นสุดกิจกรรม";
        // }

        // if (strtotime($reg_start_date) > strtotime($reg_end_date)) {
        //     return "วันที่เริ่มลงทะเบียนต้องไม่มากกว่าวันที่สิ้นสุดการลงทะเบียน";
        // }

        // ตรวจสอบว่า event_id ที่ต้องการอัพเดทมีอยู่ในฐานข้อมูลหรือไม่
        $checkQuery = "SELECT * FROM events WHERE eid = ?";
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return "ไม่พบกิจกรรมที่ต้องการอัพเดท";
        }

        // ถ้ามีการส่งค่า imageData มาใหม่
        if (!empty($imageData)) {
            $query = "UPDATE events SET
                event_name = ?, 
                owner_id = ?, 
                event_start_date = ?, 
                event_end_date = ?, 
                event_start_time = ?, 
                event_end_time = ?, 
                reg_start_date = ?, 
                reg_end_date = ?, 
                description = ?, 
                image = CASE 
                            WHEN image IS NULL OR image = '' THEN ? 
                            ELSE CONCAT(image, ',', ?) 
                        END,
                capacity = ? 
                WHERE eid = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sisssssssssii", $event_name, $ownerID, $event_start_date, $event_end_date, 
            $event_start_time, $event_end_time, $reg_start_date, $reg_end_date, 
            $details, $imagePathsString, $imagePathsString, $capacity, $event_id);
        } else {
            // ถ้าไม่มีการส่งค่า imageData มาใหม่
            $query = "UPDATE events SET
                event_name = ?, 
                owner_id = ?, 
                event_start_date = ?, 
                event_end_date = ?, 
                event_start_time = ?, 
                event_end_time = ?, 
                reg_start_date = ?, 
                reg_end_date = ?, 
                description = ?, 
                capacity = ? 
                WHERE eid = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sissssssssi", $event_name, $ownerID, $event_start_date, $event_end_date, 
            $event_start_time, $event_end_time, $reg_start_date, $reg_end_date, 
            $details, $capacity, $event_id);
        }

        if ($stmt->execute()) {
            return "แก้ไขกิจกรรมสำเร็จ!"; 
        }

        return "เกิดข้อผิดพลาดในการอัพเดทกิจกรรม";
    }
    public function updateEventImages($eid, $newImages) {
        // เตรียมคำสั่ง SQL สำหรับการอัปเดต
        $query = "UPDATE events SET image = ? WHERE eid = ?";
    
        // ใช้ prepare และ bind_param ของ MySQLi
        $stmt = $this->conn->prepare($query);
    
        if ($stmt === false) {
            // ตรวจสอบว่าคำสั่งเตรียมไม่สำเร็จ
            die('MySQL prepare error: ' . $this->conn->error);
        }
    
        // การใช้ bind_param สำหรับการเชื่อมค่าพารามิเตอร์
        // 's' คือ type สำหรับ string และ 'i' คือ type สำหรับ integer
        $stmt->bind_param('si', $newImages, $eid);
    
        // สั่งให้ทำการ execute คำสั่ง
        $result = $stmt->execute();
    
        // ปิดการเชื่อมต่อกับฐานข้อมูล
        $stmt->close();
    
        // คืนค่าผลลัพธ์ของการ execute คำสั่ง (true ถ้าทำงานสำเร็จ, false ถ้าล้มเหลว)
        return $result;
    }
    

}
