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
        $events = new Events();
        $user = new Users();
        $uid = $user->getUserIDByName($user->getName());
        $historyData = $user->getEventHistory($uid);
        $eventsPerPage = 5;
        $totalEvents = count($historyData);
        $totalPages = ceil($totalEvents / $eventsPerPage);
        renderView('home', ['data' => $eventList, 'historyData' => $historyData, 'totalPages' => $totalPages]);
    }
} else {
    http_response_code(400);
    exit;
}
 