<?php
require_once '../app/controllers/AuthController.php';

$controller = new AuthController();
$action = $_GET['action'] ?? 'index';

if ($action == 'index') {
    $controller->showIndex();
} elseif ($action == 'login') {
    $controller->showLogin(); // ประมวลผลการ login
}

