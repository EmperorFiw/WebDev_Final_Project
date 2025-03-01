<?php
declare(strict_types=1);

$events = new Events();
$users = new Users();

$uid = (int)($_GET['uid'] ?? null);
$action = $_GET['action'] ?? '';
$eid = (int)$_GET['eid'] ?? null;
$uname = $users->getName();

if (!empty($action)) {
    if (!empty($eid)) {
        $eid = (int)$eid; // แปลง $eid เป็นจำนวนเต็ม

        if (!$events->isOwnerEvent($uname, $eid)) {
            http_response_code(403);
            exit;
        }

        $eventData = $events->getOwnerEventDataByUserName($uname);
        if (isset($eventData[0])) {
            $eventData = $eventData[0];  // เลือกแถวแรก
        }

        switch ($action) {
            case "approve":
                if (empty($eid) || !$events->getEventDataByID($eid)) {
                    http_response_code(403);
                    exit;
                }

                $eventParticipants = $events->getParticipantsByEventID($eid);
                renderView('approve_event_get', ['participants' => $eventParticipants]);
                break;

            case "name_check":
                renderView('name_check_get', $eventData);
                break;

            case "statistics":
                $statistic = new Statistic();
                $stats = $statistic->getStatistics($eid);

                renderView('statistics_get', [
                    'allMember' => $stats['totalMembers'] ?? 0,
                    'ageData' => $stats['ageData'] ?? [],
                    'genderData' => $stats['genderData'] ?? []
                ]);
                break;

            case "edit":
                if (!empty($eventData)) {
                    renderView('edit_event_get', $eventData);
                } else {
                    swalAlert('ไม่พบข้อมูล', 'error', 'edit_event_get', 'home');
                }
                break;

            case "delete":
                $alertScript = "Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: 'คุณต้องการลบกิจกรรมนี้จริงๆ หรือไม่?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteForm').submit();
                    }
                    else {
                        window.location.href = '/my_events';
                    }
                });";

                $eventData['alertScript'] = $alertScript;
                $eventData['deleteID'] = $eid;

                renderView("my_events_get", $eventData);
                break;

            case "approveUser":
            case "rejectUser":
                if ($uid && $eid && in_array($action, ['approveUser', 'rejectUser'])) {
                    // กำหนดสถานะการเข้าร่วม (อนุมัติ = 1, ปฏิเสธ = 4)
                    $join_state = ($action === 'approveUser') ? 1 : 4;

                    if (empty($eid) || !$events->getEventDataByID($eid) || !$events->isOwnerEvent($uname, $eid)) {
                        http_response_code(403);
                        exit;
                    }
                    $eventParticipants = $events->getParticipantsByEventID($eid);

                    if ($users->userApprovalStatus($uid, $eid)) {
                        renderView('approve_event_get', ['participants' => $eventParticipants]);
                        break;
                    }

                    $result = $events->updateUserJoinState($eid, $uid, $join_state);

                    if ($result === 'เกิดข้อผิดพลาดในการอัปเดต!') {
                        swalAlertWithData($result, 'error', 'approve_event_get', 'event_controller', ['participants' => $eventParticipants], true);
                    } else {
                        swalAlertWithData($result, 'success', 'approve_event_get', 'event_controller', ['participants' => $eventParticipants], true);
                    }

                } else {
                    http_response_code(400);
                    exit;
                }
                break;

            default:
                http_response_code(400);
                break;
        }
    } else {
        $eventData = $events->getOwnerEventDataByUserName($uname);
        if (isset($eventData[0])) {
            $eventData = $eventData[0];
        }
        swalAlertWithData('กรุณาเลือกกิจกรรมก่อนดำเนินการ', 'error', 'my_events_get', 'my_events', $eventData, true);
    }
}
