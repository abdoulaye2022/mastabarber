<?php
$error = "";
if(isset($_POST['login'])) {
    if(isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) 
    {
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

        // Vérification de la longueur maximale (par exemple, 50 caractères pour le username)
        if ($username && strlen($username) <= 50) {
            $username = htmlspecialchars(trim($username));
        } else {
            die('Nom d\'utilisateur invalide ou trop long.');
        }

        // Vérification du mot de passe (longueur minimale et éventuellement regex)
        if ($password && strlen($password) >= 4) {
            $password = htmlspecialchars(trim($password));
        } else {
            die('Mot de passe invalide ou trop court.');
        }

        try {
            // Préparer la requête pour récupérer les données utilisateur
            $stmt = $cn->prepare("SELECT * FROM users WHERE username = :username");
        
            // Lier les paramètres avec une sécurité renforcée
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        
            // Exécuter la requête
            $stmt->execute();
        
            // Récupérer les résultats
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Vérifier si l'utilisateur existe
            if ($user) {
                // Vérifier le mot de passe avec password_verify
                if (password_verify($password, $user['password'])) {
                    $_SESSION['firstname'] = $user['firstname'];
                    $_SESSION['lastname'] = $user['lastname'];
                    header("Location: dashboard");
                    die;
                } else {
                    $error = "Invalid Username or password.";
                }
            } else {
                $error = "Invalid Username or password.";
            }
        } catch (PDOException $e) {
            $error = 'Server error: ' . $e->getMessage();
        }
    } else {
        $error = "All the fields ar required!";
    }
}

include __DIR__ . '/includes/headerDm.php';
?>
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="index.html" class="d-inline-block auth-logo">
                                <!-- <img src="dm/assets/images/logo-light.png" alt="" height="20"> -->
                            </a>
                        </div>
                        <!-- <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p> -->
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Mastabarber.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="" method="post">
                                    <?php if($error != "") { ?>
                                    <div class="mb-3">
                                        <p class="text" style="color: red; text-align: center;"><?php echo $error; ?></p>
                                    </div>
                                    <?php } ?>

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="username"
                                            placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        <!-- <div class="float-end">
                                            <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                                        </div> -->
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" name="password" class="form-control pe-5 password-input"
                                                placeholder="Enter password" id="password-input">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div> -->

                                    <div class="mt-4">
                                        <button name="login" class="btn btn-success w-100" type="submit">Sign In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <?php
include __DIR__ . '/includes/footerDm.php';
?>