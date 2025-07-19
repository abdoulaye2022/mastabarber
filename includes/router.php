<?php
// Définir le dossier public
$publicDir = '/mastabarber/public';

// Récupérer l'URL complète après le nom de domaine
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Vérifier si l'URL contient une extension .php
if (preg_match('/\.php$/', $requestUri)) {
    // Rediriger vers la page 404
    header("Location: /mastabarber/public/not-found");
    exit;
}

// Supprimer le chemin vers le dossier public pour obtenir le path après
$pathAfterPublic = str_replace($publicDir, '', $requestUri);

// Nettoyer le path (supprimer les slashs initiaux et les extensions .php)
$pathAfterPublic = trim($pathAfterPublic, '/');
$pathAfterPublic = str_replace('.php', '', $pathAfterPublic);

// Fonction pour sécuriser les includes
function secureInclude($filePath) {
    if (file_exists($filePath)) {
        require $filePath;
    } else {
        require __DIR__ . '/../pages/404.php';
    }
}

// Routage des pages
switch ($pathAfterPublic) {
    case '':
    case 'accueil':
        require_once(__DIR__ . '/../pages/home.php');
        break;
    case 'home':
        require_once(__DIR__ . '/../pages/home.php');
        break;
    case 'contact':
        require_once(__DIR__ . '/../pages/contact.php');
        break;
    case 'about-us':
        require_once(__DIR__ . '/../pages/about-us.php');
        break;
    case 'services':
        require_once(__DIR__ . '/../pages/service.php');
        break;
    case 'login':
        require_once(__DIR__ . '/../dm_dash/login.php');
        break;
    case 'dashboard':
        require_once(__DIR__ . '/../dm_dash/dashboard.php');
        break;
    case 'logout':
        require_once(__DIR__ . '/../dm_dash/includes/logout.php');
        break;
    case 'users-management':
        require_once(__DIR__ . '/../dm_dash/users.php');
        break;
    case 'services-management':
        require_once(__DIR__ . '/../dm_dash/services.php');
        break;
    case 'customers-management':
        require_once(__DIR__ . '/../dm_dash/customers.php');
        break;
    case 'availabilities-management':
        require_once(__DIR__ . '/../dm_dash/availabilities.php');
        break;
    case 'ajax_check_user':
        require_once(__DIR__ . '/../dm_dash/ajax/check_user.php');
        break;
    case 'ajax_get_availabilities':
        require_once(__DIR__ . '/../dm_dash/ajax/get_availabilities.php');
        break;
    case 'not-found':
        require_once(__DIR__ . '/../pages/404.php');
        break;
    default:
        require_once(__DIR__ . '/../pages/404.php');
        break;
}