<?php
declare(strict_types=1);

$events = new Events();
$eventList = $events->getAllEvents();
foreach ($eventList as &$event) {
    $event['registered'] = $events->getRegistered(intval($event['eid']));
}

renderView('home', ['data' => $eventList]);  