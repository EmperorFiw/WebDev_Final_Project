<?php
require_once DATABASE_DIR. '/events.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    $events = new Events();
    $eventList = $events->getEventData($key, $date);

    if (empty($eventList)) {
        renderView('home', ['not_found' => 1]);
    } else {
        foreach ($eventList as &$event) {
            $event['registered'] = $events->getRegistered($event['eid']);
        }
        renderView('home', ['data' => $eventList]);
    }
} else {
    http_response_code(403);
    exit;
}
