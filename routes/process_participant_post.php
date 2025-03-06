<?php

$uid = (int)$_POST['uid'] ?? null;
$eid = (int)$_POST['eid'] ?? null;
$action = $_POST['action'] ?? null;

if (!$events->isOwnerEvent($_SESSION['username'], $eid))
{
    http_response_code(403);
    exit;
}

if ($uid && $eid && in_array($action, ['approve', 'reject'])) {
    $join_state = ($action === 'approve') ? 1 : 0; // 1 = อนุมัติ, 0 = ปฏิเสธ

    $events = new Events();
    $users = new Users();
    
    if (!$events->isOwnerEvent($_SESSION['username'], $eid))
    {
        http_response_code(403);
        exit;
    }
    $uname = $users->getName();
    
    if (empty($eid) || !$events->getEventDataByID($eid))
    {
        http_response_code(403);
        exit;
    }

    $eventParticipants = $events->getParticipantsByEventID($eid);
    $result = $events->updateUserJoinState($eid, $uid, $join_state);
    
    if ($result === 'เกิดข้อผิดพลาดในการอัปเดต!') {
        swalAlertWithData($result, 'error', 'approve_event_get', 'approve_event', $eventParticipants, true);
    } else {
        swalAlertWithData($result, 'success', 'approve_event_get', 'approve_event', $eventParticipants, true);
    }
    


} else {
    http_response_code(400);
    exit;
}
