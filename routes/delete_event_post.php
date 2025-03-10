<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = $_POST['eid'] ?? '';
    if (empty($eid))
    {
        http_response_code(400);
        exit;
    }
    else
    {
        $eid = intval($eid);
        $events = new Events();
        
        if ($events->isOwnerEvent($_SESSION['username'], $eid))
        {
            $events = new Events();
            $result = $events->deleteEvent($eid);
            $eventData = $events->getEventDataByID($eid);
            if (isset($eventData[0])) {
                $eventData = $eventData[0];  // เลือกแถวแรก
            }
            if (!$result)
            {
                swalAlertWithData('เกิดข้อผิดพลาด', 'error', 'my_events_get', 'my_events', $eventData, true);
            }
            else
            {
                swalAlertWithData('ทำการลบกิจกรรมสำเร็จ', 'success', 'my_events_get', 'my_events', $eventData, true);
            }
        }
        else
        {
            http_response_code(403);
            exit;
        }
    }
}
else
{
    http_response_code(400);
    exit;
}