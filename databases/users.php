<?php
declare(strict_types=1);

class Users {
    private $db;
    private $conn;
    public function __construct() {
        $this->db = new DB();
        $this->conn = $this->db->getConnection();
    }    
    function getName(): string {       
        return $_SESSION['username'];
    }
    function getUserIDByName(string $uName): int {       
        $query = "SELECT uid 
                  FROM users
                  WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $uName);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $row = $result->fetch_assoc()) {
            return $row['uid'];
        }
    
        return -1;
    }
    
    function getNameByID(int $uID): string {       
        $query = "SELECT username 
                  FROM users
                  WHERE uid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $uID);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $row = $result->fetch_assoc()) {
            return $row['username'];
        }
    
        return "NULL";
    }
    
    function updateUsersInt(string $column, int $values, int $uid): bool {
        $query = "UPDATE users SET $column = ? WHERE uid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii",$values, $uid);
        return $stmt->execute();
    }    
    
    function isUsernameExiting(string $username): bool
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    

    function isEmailExiting(string $email): bool
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    function register($username, $password, $email, $phone): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "รูปแบบอีเมลไม่ถูกต้อง";
        }
    
        if (!is_numeric($phone)) {
            return "หมายเลขโทรศัพท์ต้องเป็นตัวเลข";
        }
    
        if ($this->isUsernameExiting($username)) {
            return "ชื่อผู้ใช้งานนี้มีอยู่แล้ว";
        }
    
        if ($this->isEmailExiting($email)) {
            return "อีเมลนี้ถูกใช้แล้ว";
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, tel) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $hashedPassword, $email, $phone);
    
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            return "ลงทะเบียนสำเร็จ!";
        } else {
            return "เกิดข้อผิดพลาดในการลงทะเบียน";
        }
    }
    
    function login($username, $password): string
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
    
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                return "เข้าสู่ระบบสำเร็จ!";
            } else {
                return "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
            }
        } else {
            return "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    }
    

}
