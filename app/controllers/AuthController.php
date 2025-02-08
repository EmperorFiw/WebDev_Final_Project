<?php
class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function showLogin():void {
        include '../views/login.php';
    }

    public function showRegister():void {
        include '../views/register.php';
    }

    public function login():void {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_DEFAULT);
            // ตรวจสอบข้อมูลการเข้าสู่ระบบ
            $user = $this->userModel->getUserByUsernameAndPassword($username, $password);

            if ($user) {
                // หากล็อกอินสำเร็จ
                echo "Welcome, " . $user['name'];
            } else {
                // หากล็อกอินไม่สำเร็จ
                echo "Invalid username or password!";
            }
        }
    }

    // ฟังก์ชันสำหรับจัดการการ Register
    public function register():void {
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
