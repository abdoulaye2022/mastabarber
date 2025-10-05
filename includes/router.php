<?php
// Détecter l'environnement et définir le dossier public
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1' || strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0) {
    $publicDir = '/public';
} else {
    // En production, on est déjà dans le dossier public
    $publicDir = '';
}

// Récupérer l'URL complète après le nom de domaine
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Debug temporaire - à supprimer après
// echo "DEBUG: REQUEST_URI = " . $_SERVER['REQUEST_URI'] . "<br>";
// echo "DEBUG: requestUri = " . $requestUri . "<br>";
// echo "DEBUG: publicDir = " . $publicDir . "<br>";

// Vérifier si c'est une route API - laisser passer sans traitement
if (strpos($requestUri, '/api/') === 0) {
    // C'est une route API, arrêter le traitement du routeur
    exit;
}

// Vérifier si l'URL contient une extension .php
if (preg_match('/\.php$/', $requestUri)) {
    // Rediriger vers la page 404
    header("Location: /not-found");
    exit;
}

// Supprimer le chemin vers le dossier public pour obtenir le path après
$pathAfterPublic = str_replace($publicDir, '', $requestUri);

// Debug temporaire - à supprimer après
// echo "DEBUG: pathAfterPublic after replace = " . $pathAfterPublic . "<br>";

// Nettoyer le path (supprimer les slashs initiaux et les extensions .php)
$pathAfterPublic = trim($pathAfterPublic, '/');
$pathAfterPublic = str_replace('.php', '', $pathAfterPublic);

// Debug temporaire - à supprimer après
// echo "DEBUG: final pathAfterPublic = " . $pathAfterPublic . "<br>";
// echo "DEBUG: switching on = '" . $pathAfterPublic . "'<br>";

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
    case 'reset-password':
    case 'reset_password':
        require_once(__DIR__ . '/../pages/reset_password.php');
        break;
    case 'verify-email':
    case 'verify_email':
        require_once(__DIR__ . '/../pages/verify_email.php');
        break;
    case 'privacy-policy':
        require_once(__DIR__ . '/../pages/privacy-policy.php');
        break;
    case 'privacy-choices':
        require_once(__DIR__ . '/../pages/privacy-choices.php');
        break;
    case 'admin-login':
        require_once(__DIR__ . '/../pages/admin-login.php');
        break;
    case 'admin-dashboard':
        require_once(__DIR__ . '/../pages/admin-dashboard.php');
        break;
    case 'admin-logout':
        require_once(__DIR__ . '/../pages/admin-logout.php');
        break;
    case 'not-found':
        require_once(__DIR__ . '/../pages/404.php');
        break;
    default:
        require_once(__DIR__ . '/../pages/404.php');
        break;
}