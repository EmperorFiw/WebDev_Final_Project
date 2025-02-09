<?php
require_once __DIR__ .'/db.php';

class UserModel {
    private $conn;
    private $table = "users";

    public function __construct() {
        $this->conn = (new db())->connect();
    }

    public function login_process($username, $password):array|bool|null {
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = $result->fetch_assoc(); // คืนค่าผู้ใช้หากพบ

        if ($user && password_verify($password, $user['password'])) {
            return $user; // คืนค่าผู้ใช้หากรหัสผ่านถูกต้อง
        }

        return null; // คืนค่า null ถ้ารหัสผ่านไม่ถูกต้อง
    }

    // ฟังก์ชันเพิ่มผู้ใช้ใหม่
    public function createUser($username, $password, $email) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO {$this->table} (username, password, email) VALUES (?, ?, ?)"; // แก้ไข SQL statement
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
    }
}
