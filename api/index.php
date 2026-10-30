<?php

declare(strict_types=1);

chdir(dirname(__DIR__));

$pages = [
    'Login' => 'Login.php',
    'AdminPanel' => 'AdminPanel.php',
    'Logout' => 'Logout.php',
    'Percobaan' => 'Percobaan.php',
];

$page = $_GET['page'] ?? null;

if ($page === null || $page === '') {
    require 'index.php';
    return;
}

if (!isset($pages[$page])) {
    http_response_code(404);
    echo 'Not Found';
    return;
}

require $pages[$page];
