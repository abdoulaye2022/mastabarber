# Configuration en Production - MastaBaber Admin

## Problèmes Courants et Solutions

### 1. Erreur 500 sur `/admin-login`

#### Causes possibles :

**A. Fichier .env introuvable**
- **Symptôme** : Erreur "Le fichier .env n'existe pas"
- **Solution** : Le code essaie maintenant 2 chemins automatiquement :
  - Dev : `config/../.env`
  - Prod : `config/../../.env`

**B. Colonne `role` n'existe pas**
- **Symptôme** : Erreur SQL "Unknown column 'role'"
- **Solution** : Exécutez la migration SQL :

```sql
ALTER TABLE users
ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user' AFTER is_active;

ALTER TABLE users
ADD INDEX idx_role (role);
```

**C. Permissions de fichiers**
- **Symptôme** : Erreur de lecture de fichiers
- **Solution** : Vérifiez les permissions :

```bash
# Permissions pour les fichiers PHP
chmod 644 pages/admin-login.php
chmod 644 pages/admin-dashboard.php
chmod 644 config/database.php

# Permissions pour .env (lecture uniquement)
chmod 600 .env
```

### 2. Vérifications à Faire en Production

#### Étape 1 : Vérifier la connexion à la base de données

Créez un fichier temporaire `test-db.php` à la racine :

```php
<?php
require_once __DIR__ . '/config/database.php';

echo "Test de connexion à la base de données...\n";

$db = getDatabaseConnection();

if ($db) {
    echo "✅ Connexion réussie !\n";

    // Vérifier si la colonne role existe
    try {
        $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'role'");
        $result = $stmt->fetch();

        if ($result) {
            echo "✅ La colonne 'role' existe dans la table users\n";
        } else {
            echo "❌ La colonne 'role' n'existe PAS dans la table users\n";
            echo "⚠️ Exécutez la migration : database_add_user_role.sql\n";
        }
    } catch (PDOException $e) {
        echo "❌ Erreur : " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Connexion échouée\n";
}
```

Accédez à : `https://www.mastabarber.com/test-db.php`

**⚠️ IMPORTANT : Supprimez ce fichier après le test !**

#### Étape 2 : Vérifier la structure des dossiers

```
mastabarber/
├── .env                        # Fichier .env (DOIT EXISTER)
├── config/
│   └── database.php
├── pages/
│   ├── admin-login.php
│   ├── admin-dashboard.php
│   └── admin-logout.php
└── public/
    └── index.php
```

#### Étape 3 : Vérifier le contenu du .env

Le fichier `.env` doit contenir :

```env
DB_HOST=localhost
DB_NAME=nom_de_votre_base
DB_USER=votre_utilisateur
DB_PASS=votre_mot_de_passe
```

### 3. Migrations SQL à Exécuter en Production

**Migration 1 : Soft Delete (deleted_at)**
```sql
-- Fichier: database_migration_soft_delete.sql
ALTER TABLE promotions
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

ALTER TABLE promotions
ADD INDEX idx_deleted_at (deleted_at);
```

**Migration 2 : Système de Rôles**
```sql
-- Fichier: database_add_user_role.sql
ALTER TABLE users
ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user' AFTER is_active;

ALTER TABLE users
ADD INDEX idx_role (role);
```

**Migration 3 : Promouvoir un utilisateur en admin**
```sql
-- Remplacez l'email par votre email
UPDATE users SET role = 'admin' WHERE email = 'votre-email@example.com';
```

### 4. Logs d'Erreurs PHP

Pour activer les logs en production, ajoutez dans un fichier `php.ini` ou `.htaccess` :

```apache
# .htaccess
php_flag display_errors off
php_flag log_errors on
php_value error_log /path/to/php-error.log
```

Ou créez un fichier `error-log.php` temporaire :

```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Votre code de test ici
require_once __DIR__ . '/config/database.php';
echo "Test OK";
```

### 5. Compatibilité Développement / Production

Le code a été modifié pour être compatible dans les deux environnements :

#### Détection automatique du .env :
```php
// Essaye d'abord le chemin dev
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    // Sinon essaye le chemin production
    $envPath = __DIR__ . '/../../.env';
}
```

#### Gestion de la colonne role :
- Si la colonne n'existe pas encore, l'accès est autorisé (mode transition)
- Une fois la migration effectuée, seuls les `role = 'admin'` peuvent se connecter

### 6. Checklist de Déploiement

- [ ] Fichier `.env` existe à la racine
- [ ] `.env` contient les bonnes credentials de la base de données
- [ ] Migration `database_migration_soft_delete.sql` exécutée
- [ ] Migration `database_add_user_role.sql` exécutée
- [ ] Au moins un utilisateur promu en `admin`
- [ ] Routes admin ajoutées dans `includes/router.php`
- [ ] Permissions de fichiers correctes (644 pour PHP, 600 pour .env)
- [ ] Test de connexion réussi

### 7. Commandes Utiles

#### Vérifier les utilisateurs admin :
```sql
SELECT id, email, first_name, last_name, role
FROM users
WHERE role = 'admin';
```

#### Vérifier les promotions supprimées :
```sql
SELECT id, title, deleted_at, is_active
FROM promotions
WHERE deleted_at IS NOT NULL;
```

#### Restaurer toutes les promotions supprimées :
```sql
UPDATE promotions
SET deleted_at = NULL
WHERE deleted_at IS NOT NULL;
```

### 8. Sécurité en Production

**IMPORTANT** :
1. ✅ Le fichier `.env` ne doit JAMAIS être accessible via HTTP
2. ✅ Ajoutez `.env` dans `.gitignore` (déjà fait normalement)
3. ✅ Utilisez des mots de passe forts pour la base de données
4. ✅ Activez HTTPS (SSL/TLS) pour toutes les pages admin
5. ✅ Désactivez `display_errors` en production

### 9. Support

Si vous rencontrez toujours des erreurs :

1. Vérifiez les logs d'erreur PHP
2. Vérifiez les logs d'erreur Apache/Nginx
3. Testez la connexion à la base de données avec `test-db.php`
4. Vérifiez que toutes les migrations SQL ont été exécutées
5. Assurez-vous que le fichier `.env` existe et contient les bonnes credentials

## URLs en Production

- Login : `https://www.mastabarber.com/admin-login`
- Dashboard : `https://www.mastabarber.com/admin-dashboard`
- Logout : `https://www.mastabarber.com/admin-logout`
