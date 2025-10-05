<?php
// Fichier de diagnostic pour le système admin
// ⚠️ SUPPRIMEZ CE FICHIER APRÈS LE DEBUG !

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnostic Système Admin</h1>";
echo "<hr>";

// Test 1: Vérifier les sessions
echo "<h2>1. Test Sessions</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    echo "✅ Session démarrée<br>";
} else {
    echo "✅ Session déjà active<br>";
}

// Test 2: Vérifier le fichier .env
echo "<h2>2. Test Fichier .env</h2>";
$envPath1 = __DIR__ . '/../.env';
$envPath2 = __DIR__ . '/../../.env';

echo "Chemin 1 (dev): " . $envPath1 . " - " . (file_exists($envPath1) ? "✅ Existe" : "❌ N'existe pas") . "<br>";
echo "Chemin 2 (prod): " . $envPath2 . " - " . (file_exists($envPath2) ? "✅ Existe" : "❌ N'existe pas") . "<br>";

// Test 3: Charger config database
echo "<h2>3. Test Chargement config/database.php</h2>";
try {
    require_once __DIR__ . '/../config/database.php';
    echo "✅ Config chargée<br>";
    echo "DB_HOST: " . (defined('DB_HOST') ? DB_HOST : 'Non défini') . "<br>";
    echo "DB_NAME: " . (defined('DB_NAME') ? DB_NAME : 'Non défini') . "<br>";
    echo "DB_USER: " . (defined('DB_USER') ? DB_USER : 'Non défini') . "<br>";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

// Test 4: Connexion à la base de données
echo "<h2>4. Test Connexion Base de Données</h2>";
try {
    $db = getDatabaseConnection();
    if ($db) {
        echo "✅ Connexion réussie<br>";

        // Test 5: Vérifier la structure de la table users
        echo "<h2>5. Test Structure Table Users</h2>";
        $stmt = $db->query("SHOW COLUMNS FROM users");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Colonne</th><th>Type</th><th>Null</th><th>Default</th></tr>";
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>" . $col['Field'] . "</td>";
            echo "<td>" . $col['Type'] . "</td>";
            echo "<td>" . $col['Null'] . "</td>";
            echo "<td>" . $col['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Vérifier spécifiquement la colonne role
        $hasRole = false;
        foreach ($columns as $col) {
            if ($col['Field'] === 'role') {
                $hasRole = true;
                echo "<br>✅ La colonne 'role' existe<br>";
                echo "Type: " . $col['Type'] . "<br>";
                break;
            }
        }
        if (!$hasRole) {
            echo "<br>❌ La colonne 'role' n'existe PAS !<br>";
        }

        // Test 6: Vérifier la table promotions
        echo "<h2>6. Test Structure Table Promotions</h2>";
        $stmt = $db->query("SHOW COLUMNS FROM promotions");
        $promoCols = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hasDeletedAt = false;
        foreach ($promoCols as $col) {
            if ($col['Field'] === 'deleted_at') {
                $hasDeletedAt = true;
                echo "✅ La colonne 'deleted_at' existe<br>";
                break;
            }
        }
        if (!$hasDeletedAt) {
            echo "❌ La colonne 'deleted_at' n'existe PAS !<br>";
        }

        // Test 7: Compter les utilisateurs
        echo "<h2>7. Test Utilisateurs</h2>";
        $stmt = $db->query("SELECT COUNT(*) as total FROM users");
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Total utilisateurs: " . $count['total'] . "<br>";

        if ($hasRole) {
            $stmt = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
            $adminCount = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Admins: " . $adminCount['total'] . "<br>";

            if ($adminCount['total'] > 0) {
                echo "<br>Liste des admins:<br>";
                $stmt = $db->query("SELECT id, email, first_name, last_name, role FROM users WHERE role = 'admin'");
                $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>ID</th><th>Email</th><th>Nom</th><th>Rôle</th></tr>";
                foreach ($admins as $admin) {
                    echo "<tr>";
                    echo "<td>" . $admin['id'] . "</td>";
                    echo "<td>" . $admin['email'] . "</td>";
                    echo "<td>" . $admin['first_name'] . " " . $admin['last_name'] . "</td>";
                    echo "<td>" . $admin['role'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<br>⚠️ Aucun admin trouvé ! Vous devez promouvoir un utilisateur:<br>";
                echo "<code>UPDATE users SET role = 'admin' WHERE email = 'votre-email@example.com';</code><br>";
            }
        }

    } else {
        echo "❌ Connexion échouée<br>";
    }
} catch (PDOException $e) {
    echo "❌ Erreur PDO: " . $e->getMessage() . "<br>";
    echo "Code: " . $e->getCode() . "<br>";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

// Test 8: Vérifier les fichiers admin
echo "<h2>8. Test Fichiers Admin</h2>";
$files = [
    'admin-login.php' => __DIR__ . '/../pages/admin-login.php',
    'admin-dashboard.php' => __DIR__ . '/../pages/admin-dashboard.php',
    'admin-logout.php' => __DIR__ . '/../pages/admin-logout.php',
    'router.php' => __DIR__ . '/../includes/router.php'
];

foreach ($files as $name => $path) {
    echo $name . ": " . (file_exists($path) ? "✅ Existe" : "❌ N'existe pas") . "<br>";
}

echo "<hr>";
echo "<h3 style='color: red;'>⚠️ IMPORTANT: Supprimez ce fichier après le diagnostic !</h3>";
echo "<p>Pour supprimer: <code>rm public/debug-admin.php</code></p>";
?>
