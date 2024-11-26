<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure PHPMailer via Composer
require __DIR__ . '/../vendor/autoload.php';

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

$translations = include "../lang/{$lang}.php";

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = "";

if (isset($_POST['book'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid CSRF token.';
    }

    // Vérification des champs obligatoires
    $required_fields = ['fullname', 'phone', 'email', 'date', 'availability', 'service'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $error = 'All fields are required.';
        }
    }

    // Traitement des données utilisateur
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $date = htmlspecialchars(trim($_POST['date']));
    $availability_id = htmlspecialchars(trim($_POST['availability']));
    $service_id = htmlspecialchars(trim($_POST['service']));

    // Validation supplémentaire
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    }

    if (!validatePhoneNumber($phone)) {
        $error = 'Invalid phone number. Please provide a valid international format.';
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $error = 'Invalid date format. Use YYYY-MM-DD.';
    }

    if (!is_numeric($availability_id) || intval($availability_id) <= 0) {
        $error = 'Invalid availability ID.';
    }

    $newsletter = 0;
    if(isset($_POST['newsletter']) && intval($_POST['newsletter']) > 0) {
        $newsletter = 1;
    }

    $stmt = $cn->prepare('SELECT firstname, lastname, email FROM customers WHERE phone = :phone');
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $customer_id = 0;

    if ($user && $newsletter == 1) {
        $stmt = $cn->prepare("UPDATE customers SET newsletter = :newsletter WHERE phone = :phone");
        $stmt->bindParam(':newsletter', $newsletter, PDO::PARAM_INT);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();
        $customer_id = $user['id'];
    } else {
        try {
            // Préparer la requête pour insérer les données utilisateur
            $stmt = $cn->prepare("INSERT INTO customers (firstname, lastname, phone, email, newsletter, status) 
                                  VALUES (:firstname, :lastname, :phone, :email, :newsletter, :status)");
            $status = 1;
            $full = explode(' ', $fullname);
            // Lier les paramètres avec des valeurs sécurisées
            $stmt->bindParam(':firstname', $full[0], PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $full[1], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':newsletter', $newsletter, PDO::PARAM_INT);
        
            // Exécuter la requête
            $stmt->execute();
        
            $customer_id = $cn->lastInsertId();
        } catch (PDOException $e) {
            $error = 'Erreur du serveur : ' . $e->getMessage();
        }
    }

    // Si une erreur est détectée
    if ($error) {
        echo "<script>alert('$error');</script>";
    } else {
        try {
            // Préparer la requête pour insérer les données utilisateur
            $stmt = $cn->prepare("INSERT INTO appointments (`customer_id`, `availability_id`, `service_id`, `notes`) 
                                  VALUES (:customer_id, :availability_id, :service_id, :notes)");
            $status = 1;
            $notes = "";
            // Lier les paramètres avec des valeurs sécurisées
            $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
            $stmt->bindParam(':availability_id', $availability_id, PDO::PARAM_STR);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_STR);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_INT);
        
            // Exécuter la requête
            $stmt->execute();
        
            $success = "User is created successfuly!";
        } catch (PDOException $e) {
            $error = 'Erreur du serveur : ' . $e->getMessage();
        }

        // recupere le service
        $stmt = $cn->prepare("SELECT * FROM availabilities WHERE id = :availability_id");
        $stmt->bindParam(':availability_id', $availability_id, PDO::PARAM_STR);
        $stmt->execute();
        $availability = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $cn->prepare("UPDATE availabilities SET status = 'reserved' WHERE id = :availability_id");
        $stmt->bindParam(':availability_id', $availability_id, PDO::PARAM_STR);
        $stmt->execute();

        // recupere le service
        $stmt = $cn->prepare("SELECT * FROM services WHERE id = :service_id");
        $stmt->bindParam(':service_id', $service_id, PDO::PARAM_STR);
        $stmt->execute();
        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        $mail_customer = new PHPMailer(true);
        $mail_service = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail_customer->isSMTP();
            $mail_customer->Host = $_ENV['MAIL_HOST'];
            $mail_customer->SMTPAuth = true;
            $mail_customer->Username =  $_ENV['MAIL_USERNAME'];
            $mail_customer->Password = $_ENV['MAIL_PASSWORD']; 
            $mail_customer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail_customer->Port = $_ENV['MAIL_PORT'];

            $mail_service->isSMTP();
            $mail_service->Host = $_ENV['MAIL_HOST'];
            $mail_service->SMTPAuth = true;
            $mail_service->Username =  $_ENV['MAIL_USERNAME'];
            $mail_service->Password = $_ENV['MAIL_PASSWORD']; 
            $mail_service->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail_service->Port = $_ENV['MAIL_PORT'];

            $mail_customer->setFrom('contact@mastabarber.com', 'Masta Barber');
            $mail_service->setFrom('contact@mastabarber.com', 'Not-reply');

            // Ajouter le destinataire
            $mail_customer->addAddress($email, $fullname);
            $mail_service->addAddress('contact@mastabarber.com', 'Not-reply');

            // Contenu du message
            $mail_customer->isHTML(true); // Utiliser le format HTML
            $mail_customer->Subject = 'Confirmation rdv';
            $mail_customer->Body    = '<h1>Bonjour</h1><p>Ceci est un email de confirmation de votre rdv pour le service '.$service['name'].' $'.$service['price'].', a la date du '.$date.' de '.$availability['start_time'].' a '.$availability['end_time'].' .</p>';
            // $mail_customer->AltBody = 'Ceci est la version texte si le client mail ne supporte pas le HTML.';

            $mail_service->isHTML(true); // Utiliser le format HTML
            $mail_service->Subject = 'Nouveau rdv de ' . $fullname;
            $mail_service->Body    = '<h1>Bonjour</h1><p>'.$fullname.' a pris le rdv pour le service '.$service['name'].' $'.$service['price'].', a la date du '.$date.' de '.$availability['start_time'].' a '.$availability['end_time'].' .</p>';
            // $mail_service->AltBody = 'Ceci est la version texte si le client mail ne supporte pas le HTML.';

            // Envoyer le courriel
            $mail_customer->send();
            $mail_service->send();
            echo "<script>alert('Form submitted successfully!');</script>";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi du courriel : {$mail->ErrorInfo}"; die;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">



<head>
    <!--- Basic Page Needs  -->

    <meta charset="utf-8">

    <title><?php echo $translations['welcome']; ?></title>

    <meta name="description"
        content="Welcome to our website dedicated to the beauty of Afro and Canadian hair! We are excited to welcome you into our world where every hair type is celebrated. Whether you are looking for unique designs or vibrant dyes, our team is here to help you express your personal style. Explore our services and let us transform your hair into a work of art. Thank you for visiting us!.">

    <meta name="author" content="Abdoulaye Mohamed Ahmed">

    <meta name="keywords"
        content="Coiffure homme, Barber shop, Coupe de cheveux pour hommes, Rasage traditionnel, Entretien de la barbe, Style masculin, Coiffeur pour hommes, Coupe tendance homme, Salon de coiffure homme, Soins capillaires masculins, Barbe et moustache, Dégradé homme, Coiffure professionnelle, Men's haircut, Barber shop, Men's grooming, Beard trim, Traditional shaving, Men's hairstyles, Professional barber, Haircuts for men, Beard care, Fade haircut, Men's hair styling, Gentlemen's grooming, Shaving services">


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
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">

    <!-- Jquery ui CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.css">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery.fancybox.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/font-awosome.css">

    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/flat-font/flaticon.css">

    <!-- Ticker css-->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/ticker.min.css">

    <!--Owl carousel Slider -->
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

                            <img src="<?php echo BASE_URL; ?>assets/img/logo.png" alt="">

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