<?php
declare(strict_types=1);

$events = new Events();
$user = new Users();

$eventList = $events->getAllEvents();
foreach ($eventList as &$event) {
    $event['registered'] = $events->getTotalRegistered(intval($event['eid']));
}

$uid = $user->getUserIDByName($user->getName());
$historyData = $user->getEventHistory($uid);
$eventsPerPage = 5;
$totalEvents = count($historyData);
$totalPages = ceil($totalEvents / $eventsPerPage);

renderView('home', ['data' => $eventList, 'historyData' => $historyData, 'totalPages' => $totalPages]);  