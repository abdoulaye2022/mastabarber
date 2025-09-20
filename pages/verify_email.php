<?php
declare(strict_types=1);

// Configuration de la base de données
$host = 'localhost';
$dbname = 'barbershop';
$username = 'root';
$password = '';

$token = $_GET['token'] ?? '';
$error = '';
$success = '';
$tokenData = null;

// Fonction pour se connecter à la base de données
function getConnection($host, $dbname, $username, $password) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection error: " . $e->getMessage());
        return null;
    }
}

// Fonction pour vérifier le token de vérification d'email
function verifyEmailToken($pdo, $token) {
    if (!$pdo || empty($token)) {
        return null;
    }

    try {
        $tokenHash = hash('sha256', $token);

        $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.email_verified_at, evt.expires_at, evt.used_at
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
        if ($tokenData['email_verified_at'] !== null) {
            $pdo->rollBack();
            return ['success' => false, 'error' => 'Email déjà vérifié'];
        }

        $tokenHash = hash('sha256', $token);

        // Marquer l'email comme vérifié
        $sql = "UPDATE users SET email_verified_at = NOW() WHERE id = ?";
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
$pdo = getConnection($host, $dbname, $username, $password);

if (!$pdo) {
    $error = 'Erreur de connexion à la base de données';
} else {
    // Vérifier le token au chargement de la page
    if ($token) {
        $tokenData = verifyEmailToken($pdo, $token);
        if (!$tokenData) {
            $error = 'Ce lien de vérification est invalide ou a expiré.';
        } elseif ($tokenData['email_verified_at'] !== null) {
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
            background: linear-gradient(135deg, #c79e56 0%, #a67c52 100%);
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
            display: inline-block;
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
            <h1>✂️ MastaBaber</h1>
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
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
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
                        <a href="#" class="app-link">📱 App Store</a>
                        <a href="#" class="app-link">🤖 Google Play</a>
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