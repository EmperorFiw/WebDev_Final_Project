<?php

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();
// Constant values for this project
const INCLUDES_DIR = __DIR__ . '/../includes';
const ROUTE_DIR = __DIR__ . '/../routes';
const TEMPLATES_DIR = __DIR__ . '/../templates';
const DATABASE_DIR = __DIR__ . '/../databases';
// Include router to index.php 
require_once INCLUDES_DIR . '/router.php';
require_once INCLUDES_DIR . '/view.php';
require_once INCLUDES_DIR . '/db.php';

const PUBLIC_ROUTES = ['/', '/login', '/register', '/logout', '/home', '/event_details', '/auth'];

$request_uri = strtok($_SERVER['REQUEST_URI'], '?');  // ตัด query string ออก

if (in_array(strtolower($request_uri), PUBLIC_ROUTES)) {
    dispatch($request_uri, $_SERVER['REQUEST_METHOD']);
    exit;
} elseif (isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] < 10 * 60) {
    // 10 minutes.
    $unix_timestamp = time();
    $_SESSION['timestamp'] = $unix_timestamp;
    dispatch($request_uri, $_SERVER['REQUEST_METHOD']);
} else {
    unset($_SESSION['timestamp']);
    unset($_SESSION['username']);
    header('Location: /');
    exit;
}
