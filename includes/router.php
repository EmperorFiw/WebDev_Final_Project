<?php
// controller

declare(strict_types=1);

// Constant values for router
const ALLOW_METHODS = ['GET', 'POST'];
const INDEX_URI = '';
const HOME_ROUTE = 'home';

// Normalize URI
function normalizeUri(string $uri): string
{
    // Remove query string
    $uri = strtok($uri, '?');
    // Convert to lower case and remove trailing slashes
    $uri = strtolower(trim($uri, '/'));
    // Check if uri is empty and return index.php
    return $uri == INDEX_URI ? HOME_ROUTE : $uri;
}
function notFound()
{
    http_response_code(404);
    exit;
}
function getFilePath(string $uri, string $method): string
{
    return ROUTE_DIR . '/' . normalizeUri($uri) . '_' . strtolower($method) . '.php';
}
// Router handler
function dispatch(string $uri, string $method): void
{
    // 1) Normalize the URI
    $uri = normalizeUri($uri);
    // 2) Handle GET and POST requests
    if (!in_array(strtoupper($method), ALLOW_METHODS)) {
        notFound();
    }
    // 3) Link to php files
    $filePath = getFilePath($uri, $method);
    if (file_exists($filePath)) {
        include($filePath);
        return;
    } else {
        notFound();
    }
}

function badRequest(string $message = 'Bad request'): void
{
    http_response_code(400);
    echo $message;
    exit;
}

function swalAlert(string $message, string $icon, string $page, string $redirect): void {
    $title = ucfirst($icon);
    $alertScript = "Swal.fire({
        icon: '$icon',
        title: '$title',
        text: '$message',
        confirmButtonText: 'ตกลง'
    }).then(() => {
        window.location.href = '/$redirect';
    });";
    renderView($page, ["alertScript" => $alertScript]);
}
function swalAlertWithData(string $message, string $icon, string $page, string $redirect, array $data): void {
    $title = ucfirst($icon);

    // ตรวจสอบว่า redirect มีคำว่า '_parameter' และตัดออก
    $redirectWithParameter = (strpos($redirect, '_parameter') !== false);
    if ($redirectWithParameter) {
        // ตัด '_parameter' ออกจากข้อความ
        $redirect = str_replace('_parameter', '', $redirect);
    }
    
    $alertScript = "Swal.fire({
        icon: '$icon',
        title: '$title',
        text: '$message',
        confirmButtonText: 'ตกลง'
    }).then(() => {";

    // หาก redirect มี '_parameter' ให้ส่ง query string ไปด้วย
    if ($redirectWithParameter) {
        $alertScript .= "
            window.location.href = '/$redirect' + window.location.search;
        ";
    } else {
        $alertScript .= "
            window.location.href = '/$redirect';
        ";
    }

    $alertScript .= "
    });";

    // ผนวก alertScript กับข้อมูลที่ส่งเข้ามาใน $data
    $data[0]["alertScript"] = $alertScript;

    renderView($page, $data);
}
