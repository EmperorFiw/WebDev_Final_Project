<?php
session_start();
require_once __DIR__ .'/controllers/AuthController.php';

$action = $_GET['action'] ?? 'login';

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "";
}

$user = $_SESSION['username'];
switch ($action) {
    case 'login':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;
    
    case 'register':
        if ($user || !empty($_SESSION['username'])) {
            header('Location: index.php?action=home');
            exit();
        }
        $controller = new AuthController();
        $controller->showRegister();
        break;
    
    case 'home':
        break;
    default:
        echo "Welcome to the Home Page!";
        break;
}

