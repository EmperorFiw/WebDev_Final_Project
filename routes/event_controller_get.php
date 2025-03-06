<?php
declare(strict_types=1);

$events = new Events();
$users = new Users();


$uid = (int)($_GET['uid'] ?? null);
$action = $_GET['action'] ?? '';
$eid = (int)$_GET['eid'] ?? null;
$uname = $users->getName();

if (!$events->isOwnerEvent($_SESSION['username'], $eid))
{
    http_response_code(403);
    exit;
}

if (!empty($action)) {
    if (!empty($eid)) {
        $eid = (int)$eid; 

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
                    $eventData = $events->getEventDataByID($eid);
                    if (isset($eventData[0])) {
                        $eventData = $eventData[0];
                    }
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
            case "delImg":
                // $imgPath = $_GET['img'] ?? '';
                // if (empty($imgPath))
                // {
                //     http_response_code(400);
                //     exit; 
                // }
                $eventData = $events->getEventDataByID($eid);
                if (isset($eventData[0])) {
                    $eventData = $eventData[0];
                }
                $alertScript = "Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: 'คุณต้องการลบรูปนี้จริงๆ หรือไม่?',
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
                        
                    });";
                    // else {
                    //     window.location.href = '/edit_event';
                    // }

                $eventData['alertScript'] = $alertScript;
                $eventData['imgPath'] = $eid;

                renderView("edit_event_get", $eventData);
                break;
            case "checkin_list":
                $eventData = $events->getCheckListData($eid);
                renderView("checkin_list_get", $eventData);
                break;
            case "gen_qrcode":
                $events->setCheckInStatus($eid, 1);
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                $host = $_SERVER['HTTP_HOST'];
                $baseUrl = $protocol . '://' . $host. '/auth?id='. $eid;
                renderView("checkIn_event_get", ['url' => $baseUrl]);
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
