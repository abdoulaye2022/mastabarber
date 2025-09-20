<?php
declare(strict_types=1);

// Charger la configuration de la base de données
require_once __DIR__ . '/../config/database.php';

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

// Fonction pour vérifier le token de réinitialisation
function verifyPasswordResetToken($pdo, $token) {
    if (!$pdo || empty($token)) {
        return null;
    }

    try {
        $tokenHash = hash('sha256', $token);

        $sql = "SELECT u.id, u.first_name, u.last_name, u.email, prt.expires_at, prt.used_at
                FROM password_reset_tokens prt
                JOIN users u ON prt.user_id = u.id
                WHERE prt.token_hash = ? AND prt.expires_at > NOW() AND prt.used_at IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tokenHash]);

        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Token verification error: " . $e->getMessage());
        return null;
    }
}

// Fonction pour réinitialiser le mot de passe avec le token
function resetPasswordWithToken($pdo, $token, $newPassword) {
    if (!$pdo || empty($token) || empty($newPassword)) {
        return ['success' => false, 'error' => 'Paramètres invalides'];
    }

    try {
        $pdo->beginTransaction();

        // Vérifier le token une fois de plus
        $tokenData = verifyPasswordResetToken($pdo, $token);
        if (!$tokenData) {
            $pdo->rollBack();
            return ['success' => false, 'error' => 'Token invalide ou expiré'];
        }

        $tokenHash = hash('sha256', $token);
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe
        $sql = "UPDATE users SET password_hash = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$passwordHash, $tokenData['id']]);

        // Marquer le token comme utilisé
        $sql = "UPDATE password_reset_tokens SET used_at = NOW() WHERE token_hash = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tokenHash]);

        // Invalider tous les autres tokens de cet utilisateur
        $sql = "UPDATE password_reset_tokens SET used_at = NOW()
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
        error_log("Password reset error: " . $e->getMessage());
        return ['success' => false, 'error' => 'Erreur lors de la réinitialisation'];
    }
}

// Fonction pour envoyer un email de confirmation (simplifié)
function sendPasswordResetConfirmation($email, $firstName) {
    $to = $email;
    $subject = 'Mot de passe modifié avec succès - MastaBaber';

    $message = "
    <html>
    <head>
        <meta charset='utf-8'>
        <title>Mot de passe modifié - MastaBaber</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #c79e56 0%, #a67c52 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0; color: #155724; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>MastaBaber</h1>
                <h2>Mot de passe modifié</h2>
            </div>
            <div class='content'>
                <h3>Bonjour $firstName,</h3>
                <div class='success'>
                    <strong>Votre mot de passe a été modifié avec succès !</strong>
                </div>
                <p>Votre mot de passe MastaBaber a été mis à jour le " . date('d/m/Y à H:i') . ".</p>
                <p>Vous pouvez maintenant vous connecter à l'application avec votre nouveau mot de passe.</p>
                <p><strong>Si ce n'est pas vous qui avez effectué cette modification, contactez-nous immédiatement.</strong></p>
            </div>
        </div>
    </body>
    </html>";

    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: MastaBaber <contact@mastabarber.com>',
        'Reply-To: contact@mastabarber.com'
    ];

    return mail($to, $subject, $message, implode("\r\n", $headers));
}

// Connexion à la base de données
$pdo = getDatabaseConnection();

if (!$pdo) {
    $error = 'Erreur de connexion à la base de données';
} else {
    // Vérifier le token au chargement de la page
    if ($token) {
        $tokenData = verifyPasswordResetToken($pdo, $token);
        if (!$tokenData) {
            $error = 'Ce lien de réinitialisation est invalide ou a expiré.';
        }
    }

    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        $resetToken = $_POST['token'];

        // Validations
        if (empty($newPassword)) {
            $error = 'Le mot de passe est requis.';
        } elseif (strlen($newPassword) < 6) {
            $error = 'Le mot de passe doit contenir au moins 6 caractères.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'Les mots de passe ne correspondent pas.';
        } else {
            // Réinitialiser le mot de passe
            $result = resetPasswordWithToken($pdo, $resetToken, $newPassword);

            if ($result['success']) {
                $success = 'Votre mot de passe a été réinitialisé avec succès !';

                // Envoyer email de confirmation
                sendPasswordResetConfirmation(
                    $result['user']['email'],
                    $result['user']['first_name']
                );

                $token = ''; // Nettoyer le token pour cacher le formulaire
            } else {
                $error = $result['error'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - MastaBaber</title>
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

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #c79e56;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #c79e56 0%, #a67c52 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
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

        .user-info {
            background: #edf2f7;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .user-info strong {
            color: #2d3748;
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

        .password-requirements {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
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
            <p>Réinitialisation de mot de passe</p>
        </div>

        <div class="content">
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <strong>Erreur:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-icon">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>

                <div class="alert alert-success">
                    <strong>Succès!</strong> <?= htmlspecialchars($success) ?>
                </div>

                <div class="info-box">
                    <h3>Que faire maintenant ?</h3>
                    <p>Votre mot de passe a été modifié avec succès. Vous pouvez maintenant vous connecter à l'application MastaBaber avec votre nouveau mot de passe.</p>
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

            <?php elseif (!$token || !$tokenData): ?>
                <div class="info-box">
                    <h3>Lien invalide ou expiré</h3>
                    <p>Ce lien de réinitialisation de mot de passe est invalide ou a expiré. Les liens de réinitialisation expirent après 1 heure pour des raisons de sécurité.</p>
                </div>

                <div class="info-box">
                    <h3>Comment procéder ?</h3>
                    <p>Retournez sur l'application MastaBaber et demandez un nouveau lien de réinitialisation de mot de passe depuis la page de connexion.</p>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <a href="/" style="color: #c79e56; text-decoration: none; font-size: 14px;">
                        ← Retour au site principal
                    </a>
                </div>

            <?php else: ?>
                <!-- Afficher les informations de l'utilisateur -->
                <div class="user-info">
                    <strong>Réinitialisation pour:</strong> <?= htmlspecialchars($tokenData['first_name'] . ' ' . $tokenData['last_name']) ?><br>
                    <strong>Email:</strong> <?= htmlspecialchars($tokenData['email']) ?>
                </div>

                <form method="POST" action="">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <div class="form-group">
                        <label for="new_password">Nouveau mot de passe</label>
                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            required
                            minlength="6"
                            placeholder="Entrez votre nouveau mot de passe"
                        >
                        <div class="password-requirements">
                            Minimum 6 caractères
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirmer le mot de passe</label>
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            required
                            minlength="6"
                            placeholder="Confirmez votre nouveau mot de passe"
                        >
                    </div>

                    <button type="submit" class="btn">
                        Réinitialiser le mot de passe
                    </button>
                </form>

                <div class="info-box">
                    <h3>Conseils de sécurité</h3>
                    <p>
                        • Utilisez un mot de passe unique<br>
                        • Mélangez lettres, chiffres et symboles<br>
                        • Évitez les informations personnelles<br>
                        • Ne partagez jamais votre mot de passe
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Validation côté client
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (!form) return;

            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');

            function validatePasswords() {
                if (newPassword.value && confirmPassword.value) {
                    if (newPassword.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
                    } else {
                        confirmPassword.setCustomValidity('');
                    }
                }
            }

            newPassword.addEventListener('input', validatePasswords);
            confirmPassword.addEventListener('input', validatePasswords);

            form.addEventListener('submit', function(e) {
                validatePasswords();
                if (!form.checkValidity()) {
                    e.preventDefault();
                }
            });
        });

        // Auto-focus sur le premier champ
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.getElementById('new_password');
            if (firstInput) {
                firstInput.focus();
            }
        });
    </script>
</body>
</html>