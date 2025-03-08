<?php
// รับค่า imageUrl และ eid จาก URL
$imgPath = $_POST['imageUrl'] ?? '';
$eid = isset($_POST['eid']) ? (int)$_POST['eid'] : '';
$events = new Events();
$users = new Users();

// ตรวจสอบว่า path และ eid ถูกส่งมาหรือไม่
if (empty($imgPath) || empty($eid)) {
    http_response_code(400); // หากไม่มีข้อมูลที่จำเป็น ส่งค่า error 400
    echo 'Missing parameters';
    exit;
}

// ใช้ urldecode เพื่อแปลง URL ที่เข้ารหัสมา
$imgPath = urldecode($imgPath);

// ใช้ parse_url เพื่อแยกโฮสต์และพาธออกจาก URL
$parsedUrl = parse_url($imgPath);

// ตรวจสอบว่า parse_url มี path หรือไม่
if (isset($parsedUrl['path'])) {
    // เอาแค่ path ของไฟล์ (จาก URL)
    $imgFilename = $parsedUrl['path']; // เช่น /assets/img/KKKsdsd_cfeb8ac43fd5460e.png
} else {
    // ถ้าไม่สามารถแยก URL ได้ให้คืนค่า error
    http_response_code(400);
    echo 'Invalid URL';
    exit;
}
if (!$events->isOwnerEvent($users->getName(), $eid))
{
    http_response_code(403);
    exit;
}
// ลบเครื่องหมาย / จากต้นทางของ imgFilename
$imgFilename = ltrim($imgFilename, '/');

// รับข้อมูลกิจกรรมจากฐานข้อมูล
$eventData = $events->getEventDataByID($eid);

if (isset($eventData[0])) {
    $eventData = $eventData[0]; // กรณีมีข้อมูล
}

// ตรวจสอบว่า eventData มีค่าสำหรับ images หรือไม่
$images = $eventData['image'] ?? '';

if (!empty($images)) {
    // แปลง images ที่เก็บไว้ในฐานข้อมูลเป็น array
    $imageArray = explode(',', $images);
    
    // ตรวจสอบและลบชื่อไฟล์ที่ต้องการออกจาก array
    $updatedImages = array_filter($imageArray, function($image) use ($imgFilename) {
        return $image !== $imgFilename; // ลบไฟล์ที่ตรงกับชื่อที่ได้รับมา
    });

    // แปลง array กลับเป็น string ที่ใช้ , คั่น
    $newImages = implode(',', $updatedImages);

    // ลบ , ด้านหน้าและด้านหลังของ string หากมี
    $newImages = rtrim(ltrim($newImages, ','), ',');

    // อัปเดตฐานข้อมูล (ทำการ update เฉพาะ field images)
    $events->updateEventImages($eid, $newImages);

    // สร้าง path ของไฟล์จริงในระบบ
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $imgFilename; // เช่น /var/www/html/assets/img/KKKsdsd_cfeb8ac43fd5460e.png

    // ตรวจสอบว่าไฟล์มีอยู่จริงหรือไม่ก่อนที่จะลบ
    if (file_exists($filePath)) {
        unlink($filePath); // ลบไฟล์จริง
        echo 'File deleted from server';
    } else {
        echo 'File does not exist on server';
    }
    header('Location: event_controller?eid='.$eid.'&action=edit');
    //renderView('edit_event_get', $eventData);
    // echo 'Image deleted successfully';
} else {
    echo 'No images found for the event';
}
