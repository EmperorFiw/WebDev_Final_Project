<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (!empty($username) && !empty($password) && !empty($email) && !empty($phone)) {
        $users = new Users();
        $result = $users->register($username, $password, $email, $phone);

        if ($result === "ลงทะเบียนสำเร็จ!") {
            swalAlert($result, 'success', 'register_get', 'home');
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