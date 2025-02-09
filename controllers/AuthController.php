<?php

require_once __DIR__ . '/../models/userModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function showLogin() {
        $title = "Login";
        require_once __DIR__ . '/../views/login.php';
    }

    public function showRegister() {
        $title = "Register";
        require_once __DIR__ . '/../views/register.php';
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // ตรวจสอบข้อมูลการเข้าสู่ระบบ
            $user = $this->userModel->login_process($username, $password);
    
            if ($user && password_verify($password, $user['password'])) {
                // หากล็อกอินสำเร็จ
                echo "Welcome, " . $user['name'];
            } else {
                // หากล็อกอินไม่สำเร็จ
                echo "<script>alert('Invalid username or password!');</script>";
            }
        }
    }

    // ฟังก์ชันสำหรับจัดการการ Register
    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // เพิ่มข้อมูลผู้ใช้ใหม่
            $this->userModel->createUser($username, $password, $email);
            echo "Registration successful!";
        }
    }
}
