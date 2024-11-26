<?php
session_start();

// Détecter l'environnement
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    define('BASE_URL', (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/mastabarber/public/');
    define('APP_ROOT', ('C:\wamp64\www\mastabarber'));
    define('ROOT_PATH', dirname(__DIR__) . '/');
} else {
    define('BASE_URL', (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/public/');
    define('APP_ROOT', (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/');
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Charger la configuration et les fonctions
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/router.php';


