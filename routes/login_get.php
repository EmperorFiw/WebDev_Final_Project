<?php
if (isLoggedIn()) {
    header('Location: /home');
    exit;
}
renderView('login_get');
