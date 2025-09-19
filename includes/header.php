<?php
require_once __DIR__ . '/seo-config.php';

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
$translations = include "../lang/{$lang}.php";

// Obtenir les données SEO pour la page actuelle
$currentPage = getCurrentPage();
$seoData = getSEOData($currentPage);

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = "";

if (isset($_POST['contact'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid CSRF token.';
    }

    // Vérification des champs obligatoires
    $required_fields = ['fullname', 'phone', 'email', 'message'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $error = 'All fields are required.';
        }
    }

    // Traitement des données utilisateur
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation supplémentaire
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    }

    if (!validatePhoneNumber($phone)) {
        $error = 'Invalid phone number. Please provide a valid international format.';
    }

    // Si une erreur est détectée
    if ($error) {
        echo "<script>alert('$error');</script>";
    } else {
        // Juste afficher un message de succès sans envoyer d'email
        echo "<script>alert('Message sent successfully! We will contact you soon.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($seoData['title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($seoData['description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($seoData['keywords']); ?>">
    <meta name="author" content="Masta Barber - Abdoulaye Mohamed Ahmed">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- SEO Meta Tags -->
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="<?php echo (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . $seoData['canonical']; ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="business.business">
    <meta property="og:title" content="<?php echo htmlspecialchars($seoData['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seoData['description']); ?>">
    <meta property="og:url" content="<?php echo (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:site_name" content="Masta Barber">
    <meta property="og:image" content="<?php echo (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . $seoData['og_image']; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="en_CA">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($seoData['title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($seoData['description']); ?>">
    <meta name="twitter:image" content="<?php echo (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . $seoData['og_image']; ?>">

    <!-- Business Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BarberShop",
        "name": "Masta Barber",
        "image": "<?php echo (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/assets/img/logo.png",
        "description": "Professional barber shop in Moncton offering expert men's haircuts, beard trimming, and grooming services",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "95 Millennium Blvd, Suite 310",
            "addressLocality": "Moncton",
            "addressRegion": "NB",
            "postalCode": "E1E 2G7",
            "addressCountry": "CA"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "46.1351",
            "longitude": "-64.7796"
        },
        "telephone": "+1-506-899-8186",
        "email": "contact@mastabarber.com",
        "url": "<?php echo (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>",
        "priceRange": "$15-$25",
        "openingHours": [
            "Mo-Fr 09:00-18:00",
            "Sa 09:00-17:00"
        ],
        "paymentAccepted": "Cash, Credit Card",
        "currenciesAccepted": "CAD"
    }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.css">
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery.fancybox.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/font-awosome.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/flat-font/flaticon.css">
    <!-- Ticker CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/ticker.min.css">
    <!-- Owl Carousel Slider -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/owl.theme.default.min.css">
    <!-- Nav Menu CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/sm-core-css.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/sm-mint.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/sm-style.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/aos.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/magnific-popup.css">
    <!-- Main StyleSheet CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="<?php echo BASE_URL; ?>assets/img/fav-icon.png">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Preloader -->
    <div id="preloader"></div>
    <!-- /Preloader -->

    <!-- Preloader Fallback Script -->
    <script>
        // Fallback to hide preloader after 2 seconds if other scripts fail
        setTimeout(function() {
            var preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'none';
            }
        }, 2000);
    </script>

    <!-- Scroll Top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up scrollup-icon"></i>
    </button>
    <!-- /Scroll Top -->

    <!-- Header Area Start -->
    <header class="header-area" style="background-color: black;">
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-4">
                    <div class="logo-wrapper" style="background-color: white; max-width: 140px; border-radius: 10px;">
                        <a href="home" title="Masta Barber - Professional Barber Shop Home">
                            <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="Masta Barber Logo - Professional Barber Shop in Moncton NB" width="140" height="auto">
                        </a>
                    </div>
                </div>
                <div class="col-8 col-md-8">
                    <div class="menu-wrapper">
                        <nav class="main-nav">
                            <!-- Mobile menu toggle button (hamburger/x icon) -->
                            <input id="main-menu-state" type="checkbox" />
                            <label class="main-menu-btn" for="main-menu-state">
                                <span class="main-menu-btn-icon"></span>
                            </label>

                            <!-- Menu navigation -->
                            <ul id="main-menu" class="sm sm-mint">
                                <li><a href="home" title="Masta Barber Home - Professional Barber Shop">Home</a></li>
                                <li><a href="services" title="Our Barber Services - Haircuts, Beard Trim, Shaving">Services</a></li>
                                <li><a href="about-us" title="About Masta Barber - Our Story & Team">About Us</a></li>
                                <li><a href="contact" title="Contact Us - Book Your Appointment">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->