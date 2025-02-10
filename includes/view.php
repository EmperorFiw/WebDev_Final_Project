<?php

declare(strict_types=1);

function renderView(string $template, array $data = []): void
{
    $data = [
        'isLoggedIn' => isset($_SESSION['username']) && !empty($_SESSION['username']),
        'username' => $_SESSION['username']
    ];
    include TEMPLATES_DIR . '/navbar.php';
    include TEMPLATES_DIR . '/' . $template . '.php';
    include TEMPLATES_DIR . '/footer.php';
}
