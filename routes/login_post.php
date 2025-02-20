<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $users = new Users();
        $result = $users->login($username, $password);

        if ($result === "เข้าสู่ระบบสำเร็จ!") {
            swalAlert($result, 'success', 'login_get', 'home');
        } else {
            swalAlert($result, 'error', 'login_get', 'login');
        }
    } else {
        swalAlert('กรุณากรอกข้อมูลให้ครบทุกช่อง', 'error', 'login_get', 'login');
    }
}
else
{
    http_response_code(400);
    exit;
}