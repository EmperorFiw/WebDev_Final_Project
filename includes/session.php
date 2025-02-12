<?php
declare(strict_types=1);
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = null;
}

function isLoggedIn(): bool {
    return isset($_SESSION['username']) && $_SESSION['username'] !== null;
}

function logout(): void {
    session_unset();
    session_destroy();
    header("Location: /login");
    exit;
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR']; 
    }
}