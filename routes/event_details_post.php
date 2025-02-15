<?php
require_once DATABASE_DIR. '/events.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = isset($_POST['eid']) ? $_POST['eid'] : '';

    $events = new Events();
    $event_details = $events->getEventDetails($event_id);

    if (!empty($event_details)) {
        $event_details[0]['registered'] = $events->getRegistered($event_id);
        $event_details[1]['status'] = $events->getEventStatus($event_id);
        renderView('event_details', ['data' => $event_details]);
    } else {
        http_response_code(404);
        exit;
    }
} else {
    http_response_code(403);
    exit;
}
