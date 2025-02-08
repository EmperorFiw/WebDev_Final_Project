<?php
require_once '../config/db.php';

class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = (new db())->getConnection();
    }

    // ฟังก์ชันดึงข้อมูลผู้ใช้จากชื่อผู้ใช้และรหัสผ่าน
    public function getUserByUsernameAndPassword($username, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc(); // คืนค่าผู้ใช้หากพบ
    }

    // ฟังก์ชันเพิ่มผู้ใช้ใหม่
    public function createUser($username, $password, $email) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?, ?)"; //////////////// ยังไม่เสร็จ!!!!
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
    }
}
?>
