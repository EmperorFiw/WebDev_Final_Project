<?php
declare(strict_types=1);

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(403);
    exit;
}

$eventID = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$event = new Events();
$users = new Users();

$eventData = $event->getEventDataByID($eventID);
$username = $_SESSION['username'];
$uid = $users->getUserIDByName($username);

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
if (empty($eventData) || !$eventData['checkIn'])
{
    http_response_code(403);
    echo
    exit;
}
else if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "ผิดพลาด",
                text: "กรุณาล็อคอินก่อนทำการเช็คชื่อ",
                icon: "error"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/login";
                }
            });
        });
        </script>';
    exit;
}
else {
    if ($event->getEventStatus($eventID) == "กิจกรรมจบ")
    {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "ผิดพลาด",
                    text: "กิจกรรมจบแล้ว",
                    icon: "error"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/home";
                    }
                });
            });
        </script>';
        exit; 
    }
    if (!$event->isCheckInOpen($eventID)) {
       http_response_code(403); 
       exit;
    }
    else if (!$event->isUserInEvent($uid, $eventID)) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "ผิดพลาด",
                    text: "คุณไม่มีรายชื่ออยู่ในกิจกรรมนี้",
                    icon: "error"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/home";
                    }
                });
            });
        </script>';
    }
    else {
        $eventName = $event->getEventName($eventID);
        if ($users->checkIn($uid, $eventID))
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "สำเร็จ!",
                    text: "เช็คชื่อกิจกรรม '.$eventName.' สำเร็จ!",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/home";
                    }
                });
            });
            </script>';
    }
}

