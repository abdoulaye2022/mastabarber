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
            "streetAddress": "95 Millennium Blvd, Suite 207",
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

    <!-- Closure Notice Banner -->
    <?php
    // Afficher la bannière seulement jusqu'au 10 novembre 2025
    $currentDate = new DateTime();
    $endDate = new DateTime('2025-11-10 23:59:59');

    if ($currentDate <= $endDate):
    ?>
    <div style="background: linear-gradient(135deg, #c79e56 0%, #d4a962 100%); color: white; padding: 15px 0; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: relative; z-index: 1000;">
        <div class="container">
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; flex-wrap: wrap;">
                <i class="fas fa-info-circle" style="font-size: 24px;"></i>
                <p style="margin: 0; font-size: 1.1em; font-weight: 600;">
                    <strong>Important Notice:</strong> We will be closed from November 2nd to November 10th, 2025
                </p>
                <i class="fas fa-calendar-times" style="font-size: 24px;"></i>
            </div>
            <p style="margin: 5px 0 0 0; font-size: 0.95em; opacity: 0.95;">
                We apologize for any inconvenience. We'll be back to serve you on November 11th!
            </p>
        </div>
    </div>
    <?php endif; ?>
    <!-- /Closure Notice Banner -->

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
                                <li>
                                    <a href="#" id="downloadAppBtn"
                                       style="background: #c79e56; color: white; padding: 8px 16px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;"
                                       title="Download MastaBaber Mobile App">
                                        <i class="fas fa-mobile-alt"></i> Get App
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->

    <!-- Smart App Download Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadBtn = document.getElementById('downloadAppBtn');

            if (downloadBtn) {
                downloadBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const userAgent = navigator.userAgent || navigator.vendor || window.opera;

                    // Détection iOS
                    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                        window.location.href = 'https://apps.apple.com/app/mastabarber/id6752813029';
                    }
                    // Détection Android
                    else if (/android/i.test(userAgent)) {
                        window.location.href = 'https://play.google.com/store/apps/details?id=com.m2atech.mastabarber';
                    }
                    // Desktop ou autre - afficher une modal avec les deux options
                    else {
                        showAppDownloadModal();
                    }
                });
            }
        });

        function showAppDownloadModal() {
            // Créer une modal simple
            const modal = document.createElement('div');
            modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); display: flex; align-items: center; justify-content: center; z-index: 9999;';

            modal.innerHTML = `
                <div style="background: white; padding: 40px; border-radius: 20px; max-width: 500px; text-align: center;">
                    <h3 style="color: #333; margin-bottom: 20px; font-size: 1.8em;">Download MastaBaber App</h3>
                    <p style="color: #666; margin-bottom: 30px;">Choose your platform:</p>

                    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 20px;">
                        <a href="https://apps.apple.com/app/mastabarber/id6752813029" target="_blank"
                           style="display: inline-flex; align-items: center; gap: 12px; background: #000; color: white; padding: 15px 25px; border-radius: 12px; text-decoration: none; transition: transform 0.3s ease;"
                           onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="fab fa-apple" style="font-size: 32px;"></i>
                            <div style="text-align: left;">
                                <div style="font-size: 0.8em;">Download on the</div>
                                <div style="font-size: 1.2em; font-weight: bold;">App Store</div>
                            </div>
                        </a>

                        <a href="https://play.google.com/store/apps/details?id=com.m2atech.mastabarber" target="_blank"
                           style="display: inline-flex; align-items: center; gap: 12px; background: #000; color: white; padding: 15px 25px; border-radius: 12px; text-decoration: none; transition: transform 0.3s ease; position: relative;"
                           onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="fab fa-google-play" style="font-size: 32px; color: #00C853;"></i>
                            <div style="text-align: left;">
                                <div style="font-size: 0.8em;">GET IT ON</div>
                                <div style="font-size: 1.2em; font-weight: bold;">Google Play</div>
                            </div>
                        </a>
                    </div>

                    <button onclick="this.parentElement.parentElement.remove()"
                            style="background: #c79e56; color: white; border: none; padding: 10px 30px; border-radius: 8px; cursor: pointer; font-size: 1em;">
                        Close
                    </button>
                </div>
            `;

            // Fermer en cliquant sur le fond
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.remove();
                }
            });

            document.body.appendChild(modal);
        }
    </script>