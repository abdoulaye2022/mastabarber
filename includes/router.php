<?php
// Définir le dossier public
$publicDir = '/mastabarber/public';

// Récupérer l'URL complète après le nom de domaine
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

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
        secureInclude(__DIR__ . '/../pages/home.php');
        break;
    case 'contact':
        secureInclude(__DIR__ . '/../pages/contact.php');
        break;
    case 'about-us':
        secureInclude(__DIR__ . '/../pages/about-us.php');
        break;
    case 'service':
        secureInclude(__DIR__ . '/../pages/service.php');
        break;
    case 'login':
        secureInclude(__DIR__ . '/../dm/login.php');
        break;
    case 'dashboard':
        secureInclude(__DIR__ . '/../dm/dashboard.php');
        break;
    case 'logout':
        secureInclude(__DIR__ . '/../dm/includes/logout.php');
        break;
    case 'users':
        secureInclude(__DIR__ . '/../dm/includes/users.php');
        break;
    case 'not-found':
        secureInclude(__DIR__ . '/../pages/404.php');
        break;
    default:
        secureInclude(__DIR__ . '/../pages/404.php');
        break;
}
