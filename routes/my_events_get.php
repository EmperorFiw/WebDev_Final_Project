<?php
declare(strict_types=1);

$events = new Events();
$username = $_SESSION['username'];
$eventData = $events->getOwnerEventData($username);

if (!isset($_SESSION['selected_event'])) {
    $_SESSION['selected_event'] = '';
}

if (!empty($_GET['selectID'])) {
    $selectedID = (int) $_GET['selectID'];

    if ($_SESSION['selected_event'] == $selectedID) {
        $_SESSION['selected_event'] = '';
    } else {
        $_SESSION['selected_event'] = $selectedID;
    }
}


renderView('my_events_get', $eventData);
