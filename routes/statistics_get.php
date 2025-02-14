<?php
require_once DATABASE_DIR.'/events.php';
require_once DATABASE_DIR.'/statistics.php';
if (isLoggedIn()) {
    header('Location: /home');
    exit;
}
if (!isset($_SESSION['username']) || !isset($_POST['eventID'])) {
    http_response_code(403);
    exit;
}

$evenID = $_POST['eventID'];
if (!$event->isOwnerEvent($_SESSION['username'], $eventID))
{
    http_response_code(403);
    exit;
}
$statistic = new Statistic();
$stats = $statistic->getStatistics($eventID);

renderView('statistics_get', [
    'allMember' => $stats['totalMembers'],
    'ageData' => $stats['ageData'],
    'genderData' => $stats['genderData']
]);