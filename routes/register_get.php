<?php
if (isLoggedIn()) {
    header('Location: /home');
    exit;
}
renderView('register_get');
