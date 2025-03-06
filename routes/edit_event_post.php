<?php
declare(strict_types=1);

      
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'] ?? ''; 
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

    $events = new Events();
    $users = new Users();
    
    if (!$events->isOwnerEvent($_SESSION['username'], $event_id))
    {
        http_response_code(403);
        exit;
    }
    if (!empty($event_id) && 
        (!empty($event_name) || !empty($max_participants) || !empty($event_start_date) || !empty($event_end_date) || 
         !empty($event_start_time) || !empty($event_end_time) || !empty($reg_start_date) || !empty($reg_end_date) || !empty($details))) 
    {
        $event_id = (int)$event_id;
        $eventData = $events->getEventDataByID($event_id);
        if (isset($eventData[0])) {
            $eventData = $eventData[0];
        }
        if (!empty($images['name'][0])) {
            $imageData = [];
            $uploadDir = 'assets/img/'; 

    
            foreach ($images['tmp_name'] as $key => $tmp_name) {

                $imageInfo = getimagesize($tmp_name);
                if ($imageInfo !== false) {

                    $fileExtension = pathinfo($images['name'][$key], PATHINFO_EXTENSION);
                    $randomString = bin2hex(random_bytes(8));  
                    $newFileName = $event_name . '_' . $randomString . '.' . $fileExtension; 
                    $filePath = $uploadDir . $newFileName;

                    if (move_uploaded_file($tmp_name, $filePath)) {
                        $imageData[] = $filePath; 
                    }
                } else {
                    swalAlertWithData('ไฟล์ที่อัปโหลดไม่ใช่รูปภาพ', 'error', 'edit_event_get', 'edit_event', $eventData, true);
                }
            }

            $imagePathsString = implode(',', $imageData); 
        } else {
            $imagePathsString = '';  
        }

        $max_participants = intval($max_participants);
        $ownerID = $users->getUserIDByName($_SESSION['username']);
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

