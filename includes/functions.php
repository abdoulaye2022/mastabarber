<?php
require_once (__DIR__ . '/../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['HTTP_HOST'] == 'localhost' ? $_SERVER['DOCUMENT_ROOT'] . '/mastabarber/' : $_SERVER['DOCUMENT_ROOT'] . "/../");
$dotenv->load();


$db = new DB($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
$cn = $db->getConnection();


function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}
