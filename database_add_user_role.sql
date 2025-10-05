-- Migration pour ajouter le système de rôles aux utilisateurs
-- Exécutez ce script dans votre base de données

-- Ajouter la colonne role à la table users
ALTER TABLE users
ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user' AFTER is_active;

-- Créer un index sur role pour améliorer les performances des requêtes
ALTER TABLE users
ADD INDEX idx_role (role);

-- Optionnel: Promouvoir un utilisateur existant en admin
-- Remplacez 'votre-email@example.com' par l'email de l'utilisateur à promouvoir
-- UPDATE users SET role = 'admin' WHERE email = 'votre-email@example.com';

-- Exemples de requêtes utiles:

-- 1. Lister tous les admins
-- SELECT id, email, first_name, last_name, role FROM users WHERE role = 'admin';

-- 2. Promouvoir un utilisateur en admin
-- UPDATE users SET role = 'admin' WHERE id = 1;

-- 3. Rétrograder un admin en utilisateur normal
-- UPDATE users SET role = 'user' WHERE id = 1;
