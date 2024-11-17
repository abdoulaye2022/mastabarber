<?php
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

$translations = include "../lang/{$lang}.php";
?>

<!DOCTYPE html>
<html lang="en">



<head>
    <!--- Basic Page Needs  -->

    <meta charset="utf-8">

    <title><?php echo $translations['welcome']; ?></title>

    <meta name="description" content="">

    <meta name="author" content="">

    <meta name="keywords" content="">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <!-- Mobile Specific Meta  -->

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">



    <!-- Google Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">



    <!-- CSS -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Jquery ui CSS -->
    <link rel="stylesheet" href="assets/css/jquery-ui.css">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awosome.css">

    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="assets/flat-font/flaticon.css">

    <!-- Ticker css-->
    <link rel="stylesheet" href="assets/css/ticker.min.css">

    <!--Owl carousel Slider -->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">

    <!-- Nav Menu CSS -->
    <link rel="stylesheet" href="assets/css/sm-core-css.css">
    <link rel="stylesheet" href="assets/css/sm-mint.css">
    <link rel="stylesheet" href="assets/css/sm-style.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <!-- Main StyleSheet CSS -->
    <link rel="stylesheet" href="assets/css/style.css">


    <!-- Favicon -->

    <link rel="shortcut icon" type="image/png" href="assets/img/fav-icon.png">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

        <![endif]-->

</head>

<body>


    <!---Preloder-->

    <div id="preloader"></div>

    <!-- /Preloder-->

    <!--Scroll Top-->

    <button class="scroll-top scroll-to-target" data-target="html">

        <i class="fas fa-angle-up scrollup-icon"></i>

    </button>

    <!--Scroll Top-->


    <!--Header Area Start-->

    <header class="header-area">

        <div class="container">

            <div class="row">

                <div class="col-4 col-md-4">

                    <div class="logo-wrapper" style="background-color: white; max-width: 140px; border-radius: 10px;">

                        <a href="accueil">

                            <img src="assets/img/logo.png" alt="">

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

                            <!-- Sample menu definition -->
                            <ul id="main-menu" class="sm sm-mint">

                                <li><a href="accueil">Home</a>
                                </li>

                                <li><a href="service">Services</a>
                                </li>

                                <li><a href="about-us">About us</a>
                                </li>
                                <li><a href="contact">Contacts</a>


                                </li>

                                <li><a data-toggle="modal" data-target="#myModal">Appointment</a></li>

                            </ul>

                        </nav>

                    </div>

                </div>

            </div>

        </div>

    </header>

    <!--Header Area End-->