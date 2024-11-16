<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DB_NAME', 'my_database');

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Environnement de développement
    define('BASE_URL', 'http://localhost/kane-eco-construction/public/');
    define('ROOT_PATH', __DIR__ . '/../');
} else {
    // Environnement de production
    define('BASE_URL', 'https://kane-eco-construction.com/');
    define('ROOT_PATH', '/path/to/production/root/');
}
