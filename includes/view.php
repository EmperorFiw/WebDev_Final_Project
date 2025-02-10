<?php

declare(strict_types=1);

function renderView(string $template, array $data = []): void
{
    include TEMPLATES_DIR . '/navbar.php';
    include TEMPLATES_DIR . '/' . $template . '.php';
    include TEMPLATES_DIR . '/footer.php';
}
