<?php
declare(strict_types=1);

// Charger la configuration de la base de données
require_once __DIR__ . '/../config/database.php';

$token = $_GET['token'] ?? '';
$error = '';
$success = '';
$tokenData = null;


// Fonction pour vérifier le token de vérification d'email
function verifyEmailToken($pdo, $token) {
    if (!$pdo || empty($token)) {
        return null;
    }

    try {
        $tokenHash = hash('sha256', $token);

        $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.email_verified_at, u.email_verified, evt.expires_at, evt.used_at
                FROM email_verification_tokens evt
                JOIN users u ON evt.user_id = u.id
                WHERE evt.token_hash = ? AND evt.expires_at > NOW() AND evt.used_at IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tokenHash]);

        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Token verification error: " . $e->getMessage());
        return null;
    }
}

// Fonction pour marquer l'email comme vérifié
function verifyEmailWithToken($pdo, $token) {
    if (!$pdo || empty($token)) {
        return ['success' => false, 'error' => 'Paramètres invalides'];
    }

    try {
        $pdo->beginTransaction();

        // Vérifier le token une fois de plus
        $tokenData = verifyEmailToken($pdo, $token);
        if (!$tokenData) {
            $pdo->rollBack();
            return ['success' => false, 'error' => 'Token invalide ou expiré'];
        }

        // Vérifier si l'email est déjà vérifié
        if ($tokenData['email_verified_at'] !== null || $tokenData['email_verified'] == 1) {
            $pdo->rollBack();
            return ['success' => false, 'error' => 'Email déjà vérifié'];
        }

        $tokenHash = hash('sha256', $token);

        // Marquer l'email comme vérifié
        $sql = "UPDATE users SET email_verified_at = NOW(), email_verified = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tokenData['id']]);

        // Marquer le token comme utilisé
        $sql = "UPDATE email_verification_tokens SET used_at = NOW() WHERE token_hash = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tokenHash]);

        // Supprimer les autres tokens de cet utilisateur
        $sql = "UPDATE email_verification_tokens SET used_at = NOW()
                WHERE user_id = ? AND used_at IS NULL AND token_hash != ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tokenData['id'], $tokenHash]);

        $pdo->commit();

        return [
            'success' => true,
            'user' => $tokenData
        ];

    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Email verification error: " . $e->getMessage());
        return ['success' => false, 'error' => 'Erreur lors de la vérification'];
    }
}

// Connexion à la base de données
$pdo = getDatabaseConnection();

if (!$pdo) {
    $error = 'Erreur de connexion à la base de données';
} else {
    // Vérifier le token au chargement de la page
    if ($token) {
        $tokenData = verifyEmailToken($pdo, $token);
        if (!$tokenData) {
            $error = 'Ce lien de vérification est invalide ou a expiré.';
        } elseif ($tokenData['email_verified_at'] !== null || $tokenData['email_verified'] == 1) {
            $success = 'Votre email est déjà vérifié !';
        } else {
            // Procéder à la vérification
            $result = verifyEmailWithToken($pdo, $token);

            if ($result['success']) {
                $success = 'Félicitations ! Votre adresse email a été vérifiée avec succès.';
                $token = ''; // Nettoyer le token
            } else {
                $error = $result['error'];
            }
        }
    } else {
        $error = 'Token de vérification manquant.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Email - MastaBaber</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #c79e56 0%, #a67c52 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .logo-icon {
            margin-bottom: 15px;
        }

        .logo-icon img {
            width: 100px;
            height: auto;
            border-radius: 10px;
            background: white;
            padding: 5px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }

        .content {
            padding: 40px 30px;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-error {
            background: #fee;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        .alert-success {
            background: #f0fff4;
            color: #2f855a;
            border: 1px solid #9ae6b4;
        }

        .info-box {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-box h3 {
            color: #2d3748;
            margin-bottom: 10px;
        }

        .info-box p {
            color: #4a5568;
            line-height: 1.6;
        }

        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .info-box li {
            color: #4a5568;
            margin-bottom: 5px;
        }

        .success-icon {
            text-align: center;
            margin-bottom: 25px;
        }

        .success-icon svg {
            width: 80px;
            height: 80px;
            color: #48bb78;
        }

        .download-app {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }

        .download-app p {
            margin-bottom: 15px;
            color: #4a5568;
        }

        .app-links {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .app-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #c79e56;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .app-link:hover {
            background: #a67c52;
        }

        @media (max-width: 480px) {
            .container {
                margin: 10px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 2em;
            }

            .content {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-icon">
                <img src="https://www.mastabarber.com/assets/img/logo.png" alt="MastaBaber Logo">
            </div>
            <h1>MastaBaber</h1>
            <p>Vérification d'email</p>
        </div>

        <div class="content">
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <strong>Erreur:</strong> <?= htmlspecialchars($error) ?>
                </div>

                <div class="info-box">
                    <h3>Besoin d'aide ?</h3>
                    <p>Si vous rencontrez des difficultés avec la vérification de votre email, vous pouvez :</p>
                    <ul>
                        <li>Vérifier que le lien n'a pas expiré (valide 24h)</li>
                        <li>Demander un nouveau lien de vérification</li>
                        <li>Contacter notre support si le problème persiste</li>
                    </ul>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <a href="/" style="color: #c79e56; text-decoration: none; font-size: 14px;">
                        ← Retour au site principal
                    </a>
                </div>

            <?php elseif ($success): ?>
                <div class="success-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>

                <div class="alert alert-success">
                    <strong>Succès!</strong> <?= htmlspecialchars($success) ?>
                </div>

                <div class="info-box">
                    <h3>Félicitations !</h3>
                    <p>Votre compte est maintenant entièrement activé. Vous pouvez maintenant :</p>
                    <ul>
                        <li>Vous connecter à l'application MastaBaber</li>
                        <li>Prendre des rendez-vous</li>
                        <li>Recevoir des notifications importantes</li>
                        <li>Accéder à toutes les fonctionnalités</li>
                    </ul>
                </div>

                <div class="download-app">
                    <p><strong>Téléchargez notre application mobile :</strong></p>
                    <div class="app-links">
                        <a href="#" class="app-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                            </svg>
                            App Store
                        </a>
                        <a href="#" class="app-link">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                            </svg>
                            Google Play
                        </a>
                    </div>
                    <div style="margin-top: 20px;">
                        <a href="/" style="color: #c79e56; text-decoration: none; font-size: 14px;">
                            ← Retour au site principal
                        </a>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>
</body>
</html>