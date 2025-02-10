<?php

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Constant values for this project
const INCLUDES_DIR = __DIR__ . '/../includes';
const ROUTE_DIR = __DIR__ . '/../routes';
const TEMPLATES_DIR = __DIR__ . '/../templates';
const DATABASE_DIR = __DIR__ . '/../databases';
// Include router to index.php 
require_once INCLUDES_DIR . '/session.php';
require_once INCLUDES_DIR . '/router.php';
require_once INCLUDES_DIR . '/view.php';
require_once INCLUDES_DIR . '/db.php';
// Call dispatch to handle requests
//echo '$_SERVER["REQUEST_URI"]=' . $_SERVER['REQUEST_URI'];
dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);