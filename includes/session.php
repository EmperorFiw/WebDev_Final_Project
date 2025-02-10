<?php
declare(strict_types=1);
session_start();

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
