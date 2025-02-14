<?php
declare(strict_types=1);
require_once DATABASE_DIR.'/events.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(403);
    exit;
}

$eventID = $_GET['id'];
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
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
    $username = $_SESSION['username'];
    if ($event->getEventStatus($evenID) == "กิจกรรมจบ")
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
    if (!$event->isCheckInOpen($evenID)) {
       http_response_code(403); 
       exit;
    }
    else if (!$event->isUserInEvent($username, $eventID)) {
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
    else if (!$event->isCheckInSucc($username, $eventID)){
        $eventName = $event->getEventName($evenID);
        $uid = getUserIDByName($username);
        if (updateUsersInt("checkIn", 1, $uid))
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
    else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "สำเร็จ!",
                    text: "คุณเช็คชื่อไปแล้ว!",
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

