<?php
session_start();

// Détecter l'environnement
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1' || strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0) {
    $port = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443' ? ':' . $_SERVER['SERVER_PORT'] : '';
    define('BASE_URL', (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/');
    define('APP_ROOT', dirname(__DIR__));
    define('ROOT_PATH', dirname(__DIR__) . '/');
} else {
    define('BASE_URL', (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/');
    define('APP_ROOT', dirname(__DIR__));
    define('ROOT_PATH', dirname(__DIR__) . '/');
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Charger la configuration et les fonctions
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/router.php';


