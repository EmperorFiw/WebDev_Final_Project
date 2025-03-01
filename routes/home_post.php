<?php
declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    $events = new Events();
    $eventList = $events->getEventDataByKeyword($key, $date);

    if (empty($eventList)) {
        renderView('home', ['not_found' => 1]);
    } else {
        foreach ($eventList as &$event) {
            $event['registered'] = $events->getTotalRegistered(intval($event['eid']));
        }
        renderView('home', ['data' => $eventList]);
    }
} else {
    http_response_code(400);
    exit;
}
 