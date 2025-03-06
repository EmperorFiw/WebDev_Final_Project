<?php
declare(strict_types=1);

$eid = (int)$_GET['eid'] ?? '';
echo $eid;
$users = new Users();
$events = new Events();
$uname = $users->getName();

if (empty($eid) || !$events->getEventDataByID($eid))
{
    http_response_code(400);
    exit;
}

$eventParticipants = $events->getParticipantsByEventID($eid);

renderView('approve_event_get', $eventParticipants);