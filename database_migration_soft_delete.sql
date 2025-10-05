-- Migration pour ajouter le soft delete aux promotions
-- Exécutez ce script dans votre base de données

-- Ajouter la colonne deleted_at à la table promotions si elle n'existe pas
ALTER TABLE promotions
ADD COLUMN IF NOT EXISTS deleted_at TIMESTAMP NULL DEFAULT NULL;

-- Créer un index sur deleted_at pour améliorer les performances
ALTER TABLE promotions
ADD INDEX idx_deleted_at (deleted_at);

-- Optionnel: Ajouter une contrainte de clé étrangère avec ON DELETE CASCADE
-- pour la table promotion_notifications si elle existe
-- Cela garantit que si une promotion est vraiment supprimée,
-- les notifications associées sont aussi supprimées

-- Vérifier d'abord si la contrainte existe
-- Si elle n'existe pas, vous pouvez l'ajouter comme ceci:

-- ALTER TABLE promotion_notifications
-- ADD CONSTRAINT fk_promotion_notifications_promotion
-- FOREIGN KEY (promotion_id)
-- REFERENCES promotions(id)
-- ON DELETE CASCADE
-- ON UPDATE CASCADE;

-- Note: Si la contrainte existe déjà avec un autre nom,
-- vous devrez d'abord la supprimer avant d'ajouter celle-ci
