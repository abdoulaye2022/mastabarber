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
            .header { background: linear-gradient(135deg, #00b894 0%, #00a085 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0; color: #155724; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>✂️ MastaBaber</h1>
                <h2>✅ Mot de passe modifié</h2>
            </div>
            <div class='content'>
                <h3>Bonjour $firstName,</h3>
                <div class='success'>
                    <strong>Votre mot de passe a été modifié avec succès !</strong>
                </div>
                <p>Votre mot de passe MastaBaber a été mis à jour le " . date('d/m/Y à H:i') . ".</p>
                <p>Vous pouvez maintenant vous connecter à l'application avec votre nouveau mot de passe.</p>
                <p><strong>⚠️ Si ce n'est pas vous qui avez effectué cette modification, contactez-nous immédiatement.</strong></p>
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
$pdo = getConnection($host, $dbname, $username, $password);

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
            display: inline-block;
            padding: 10px 20px;
            background: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .app-link:hover {
            background: #3182ce;
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
            <h1>✂️ MastaBaber</h1>
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
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
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
                        <a href="#" class="app-link">📱 App Store</a>
                        <a href="#" class="app-link">🤖 Google Play</a>
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