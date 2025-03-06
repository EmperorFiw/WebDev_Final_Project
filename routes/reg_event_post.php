<?php
declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eid = (int)$_POST['eid'] ?? '';
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $age = (int)$_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $role = $_POST['role'] ?? '';

    $events = new Events();
    $user = new Users();

    $eventData = $events->getEventDataByID($eid);
    if (isset($eventData[0])) {
        $eventData = $eventData[0];
    }

    if (empty($eid) || empty($fname) || empty($lname) || empty($phone) || empty($age) || empty($gender) || empty($role)) {
        swalAlertWithData('กรุณากรอกข้อมูลให้ครบทุกช่อง', 'error', 'reg_event_get', 'reg_event', $eventData, true);
    }
    else
    {
        $uname = $user->getName();
        $uid = $user->getUserIDByName($uname);
        $result = $events->registerEvent($uid, $eid, $fname, $lname, $phone, $age, $gender, $role);

        if ($result === 'ลงทะเบียนสำเร็จ!')
        {
            swalAlertWithData($result, 'success', 'reg_event_get', 'home', $eventData, true);
        }
        else
        {
            swalAlertWithData($result, 'error', 'reg_event_get', 'reg_event', $eventData, true);
        }
    }
} else {
    http_response_code(400);
    exit;
}
