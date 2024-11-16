<?php
// Définir le dossier public
$publicDir = '/mastabarber/public';

// Récupérer l'URL complète après le nom de domaine
$requestUri = $_SERVER['REQUEST_URI'];

// Supprimer le chemin vers le dossier public pour obtenir le path après
$pathAfterPublic = str_replace($publicDir, '', $requestUri);

// Nettoyer le path (supprimer les slashs initiaux et les extensions .php)
$pathAfterPublic = trim($pathAfterPublic, '/');
$pathAfterPublic = str_replace('.php', '', $pathAfterPublic);

// Afficher le chemin après public pour vérification
// var_dump($pathAfterPublic); die;



// Routage des pages
switch ($pathAfterPublic) {
    case '':
        require __DIR__ . '/../pages/home.php';
        break;
    case 'accueil':
        require __DIR__ . '/../pages/home.php';
        break;
    case 'contact':
        require __DIR__ . '/../pages/contact.php';
        break;
    case 'about':
        require __DIR__ . '/../pages/about.php';
        break;
    default:
        require __DIR__ . '/../pages/404.php';
        break;
}
