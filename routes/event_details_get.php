<?php
declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $event_id = (int)$_GET['eid'] ? $_GET['eid'] : '';
    if (empty($event_id))
    {
        http_response_code(404);
        exit;
    }
    $event_id = (int)$event_id;
    $events = new Events();
    $event_details = $events->getEventDataByID($event_id);

    if (!empty($event_details)) {
        $event_details[0]['registered'] = $events->getTotalRegistered($event_id);
        $event_details[1]['status'] = $events->getEventStatus($event_id);
        renderView('event_details', ['data' => $event_details]);
    } else {
        http_response_code(404);
        exit;
    }
} else {
    http_response_code(400);
    exit;
}
