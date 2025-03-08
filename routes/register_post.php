<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $token = $_POST['token'] ?? '';

    if (empty($token) || !isset($_SESSION['token']) || $_SESSION['token'] !== $token) {
        swalAlert('Token mismatch', 'error', 'register_get', 'register');
    }
    else if (!empty($username) && !empty($password) && !empty($email) && !empty($phone)) {
        $users = new Users();
        $result = $users->register($username, $password, $email, $phone);

        if ($result === "ลงทะเบียนสำเร็จ!") {
            swalAlert($result, 'success', 'register_get', 'home');
            
            if (isset($_SESSION['token']))
            {
                unset($_SESSION['token']);
            }
        } else {
            swalAlert($result, 'error', 'register_get', 'register');
        }
    } else {
        swalAlert('กรุณากรอกข้อมูลให้ครบทุกช่อง', 'error', 'register_get', 'register');
    }
}
else
{
    http_response_code(400);
    exit;
}