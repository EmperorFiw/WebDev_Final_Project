<?php
require_once DATABASE_DIR. '/events.php';
$events = new Events();
$eventList = $events->getAllEvents();
foreach ($eventList as &$event) {
    $event['registered'] = $events->getRegistered($event['eid']);
}

renderView('home', ['data' => $eventList]); 