<?php
session_start();

define('BASE_URL', (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/mastabarber/public/');

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Charger la configuration et les fonctions
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/router.php';


