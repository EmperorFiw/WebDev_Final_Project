<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'] ?? '';  // รับ event_id เพื่อทำการแก้ไขกิจกรรมที่เลือก
    $event_name = $_POST['event_name'] ?? '';
    $max_participants = $_POST['max_participants'] ?? '';
    $event_start_date = $_POST['event_start_date'] ?? '';
    $event_end_date = $_POST['event_end_date'] ?? '';
    $event_start_time = $_POST['event_start_time'] ?? '';
    $event_end_time = $_POST['event_end_time'] ?? '';
    $reg_start_date = $_POST['reg_start_date'] ?? '';
    $reg_end_date = $_POST['reg_end_date'] ?? '';
    $details = $_POST['details'] ?? '';
    $images = $_FILES['images'] ?? '';

    if (!empty($event_id) && 
        (!empty($event_name) || !empty($max_participants) || !empty($event_start_date) || !empty($event_end_date) || 
         !empty($event_start_time) || !empty($event_end_time) || !empty($reg_start_date) || !empty($reg_end_date) || !empty($details))) 
    {
        // แปลง event_id เป็น integer
        $event_id = (int)$event_id;
        $events = new Events();
        $eventData = $events->getEventData($event_id);
        if (isset($eventData[0])) {
            $eventData = $eventData[0];  // เลือกแถวแรก
        }
        if (!empty($images['name'][0])) {
            $imageData = [];
            $uploadDir = 'assets/img/'; // โฟลเดอร์ที่ต้องการเก็บไฟล์

            // วนลูปทุกไฟล์ใน images
            foreach ($images['tmp_name'] as $key => $tmp_name) {
                // ตรวจสอบว่าไฟล์เป็นภาพจริงๆ
                $imageInfo = getimagesize($tmp_name);
                if ($imageInfo !== false) {
                    // เปลี่ยนชื่อไฟล์เป็นแบบสุ่มเพื่อป้องกันชื่อซ้ำ
                    $fileExtension = pathinfo($images['name'][$key], PATHINFO_EXTENSION);
                    $randomString = bin2hex(random_bytes(8));  // สุ่ม 8 ไบต์ = 16 ตัวอักษร Hex
                    $newFileName = $event_name . '_' . $randomString . '.' . $fileExtension; // ใช้ชื่อกิจกรรม + รหัสสุ่ม
                    $filePath = $uploadDir . $newFileName;

                    // อัปโหลดไฟล์
                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $imageData[] = $filePath; // เก็บเส้นทางไฟล์ที่อัปโหลด
                    }
                } else {
                    // ถ้าไม่ใช่ไฟล์ภาพจริงๆ
                    swalAlertWithData('ไฟล์ที่อัปโหลดไม่ใช่รูปภาพ', 'error', 'edit_event_get', 'edit_event', $eventData, true);
                }
            }

            $imagePathsString = implode(',', $imageData);  // เชื่อมเส้นทางไฟล์ทั้งหมดเป็น string
        } else {
            $imagePathsString = '';  // กรณีไม่มีการอัปโหลดใหม่
        }

        $events = new Events();
        $users = new Users();
        $max_participants = intval($max_participants);
        $ownerID = $users->getUserIDByName($_SESSION['username']);
        // ใช้ฟังก์ชัน updateEvent แทน createEvent
        $result = $events->updateEvent($event_id, $event_name, $ownerID, $max_participants, $event_start_date, $event_end_date, 
                                       $event_start_time, $event_end_time, $reg_start_date, $reg_end_date, $details, $imagePathsString);

        if ($result === 'แก้ไขกิจกรรมสำเร็จ!') {
            swalAlertWithData($result, 'success', 'edit_event_get', 'my_events', $eventData, true);
        } elseif (is_string($result)) {
            swalAlertWithData($result, 'error', 'edit_event_get', 'my_events', $eventData, true);
        }
    } else {
        swalAlertWithData('ข้อมูลไม่ครบถ้วน', 'error', 'edit_event_get', 'my_events', $eventData, true);
    }
}

