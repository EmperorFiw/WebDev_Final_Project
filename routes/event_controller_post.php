<?php
declare(strict_types=1);

$action = $_POST['action'] ?? '';
$eid = $_POST['eid'] ?? '';
$uname = $_SESSION['username'];

if (!empty($action))
{
    if (!empty($eid))
    {
        $events = new Events();
        $users = new Users();
        $eid = intval($eid);

        if (!$events->isOwnerEvent($uname, $eid))
        {
            http_response_code(403);
            exit;
        }

        $eventData = $events->getOwnerEventData($uname);

        switch($action)
        {
            case "approve":
            {
                renderView('approve_event_get', $eventData);
                break;
            }
            case "name_check":
            {
                renderView('name_check_get', $eventData);
                break;
            }
            case "statistics":
            {
                $statistic = new Statistic();
                $stats = $statistic->getStatistics($eid);
                
                renderView('statistics_get', [
                    'allMember' => $stats['totalMembers'] ?? 0,
                    'ageData' => $stats['ageData'] ?? [],
                    'genderData' => $stats['genderData'] ?? []
                ]);
                break;
            }
            case "edit":
            {
                if (!empty($eventData)) {
                    renderView('edit_event_get', $eventData);
                }
                else
                {
                    swalAlert('ไม่พบข้อมูล', 'error', 'edit_event_get', 'home');
                }
                break;
            }
            case "delete":
            {
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
                });";
                
                $eventData[0]['alertScript'] = $alertScript;
                $eventData[0]['deleteID'] = $eid;

                renderView("my_events_get", $eventData);
            
                break;
            }
        }
    }
    else
    {
        $eventData = $events->getOwnerEventData($uname);
        renderView("my_events_get", $eventData);
    }
}
