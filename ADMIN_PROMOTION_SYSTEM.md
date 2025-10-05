# Système d'Administration des Promotions - MastaBaber

## Vue d'ensemble

Ce système permet de gérer les promotions pour l'application mobile MastaBaber avec un système de **soft delete** (suppression douce) pour préserver l'intégrité des données.

## Migration de la Base de Données

### Étape 1 : Ajouter la colonne `deleted_at`

Avant d'utiliser le système, vous devez exécuter la migration SQL pour ajouter la colonne `deleted_at` à la table `promotions`.

```sql
-- Exécutez ce script dans votre base de données
ALTER TABLE promotions
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

-- Créer un index pour améliorer les performances
ALTER TABLE promotions
ADD INDEX idx_deleted_at (deleted_at);
```

Le fichier complet est disponible dans : `database_migration_soft_delete.sql`

## Fonctionnalités

### 1. **Soft Delete (Suppression Douce)**

Au lieu de supprimer définitivement une promotion, le système marque la promotion comme supprimée en définissant `deleted_at = NOW()`. Cela permet de :

- ✅ **Préserver l'intégrité référentielle** avec la table `promotion_notifications`
- ✅ **Restaurer les promotions supprimées** si nécessaire
- ✅ **Garder un historique complet** des promotions
- ✅ **Éviter les erreurs de clés étrangères**

### 2. **Actions Disponibles**

#### Pour les promotions actives :
- **Créer** : Ajouter une nouvelle promotion
- **Modifier** : Éditer une promotion existante
- **Activer/Désactiver** : Toggle le statut `is_active`
- **Supprimer** : Soft delete (marque comme supprimée, peut être restaurée)

#### Pour les promotions supprimées :
- **Restaurer** : Réactiver une promotion supprimée (`deleted_at = NULL`)
- **Suppression Permanente** : Supprimer définitivement de la base de données (⚠️ Irréversible)

### 3. **Filtres**

Le dashboard offre 4 filtres cliquables via les cartes de statistiques :

- **Total Promotions** : Toutes les promotions non supprimées
- **Active Promotions** : Promotions actives (`is_active = 1` et non supprimées)
- **Inactive Promotions** : Promotions inactives (`is_active = 0` et non supprimées)
- **Deleted Promotions** : Promotions marquées comme supprimées (`deleted_at IS NOT NULL`)

## Accès au Système

### URLs :
- **Connexion** : `https://www.mastabarber.com/admin-login`
- **Dashboard** : `https://www.mastabarber.com/admin-dashboard`
- **Déconnexion** : `https://www.mastabarber.com/admin-logout`

### Authentification :
- Utilisez un compte de la table `users`
- L'email et le mot de passe doivent correspondre
- Le compte doit être actif (`is_active = 1`)

## Sécurité

### Mesures de Sécurité Implémentées :

1. ✅ **Sessions sécurisées** : Authentification basée sur les sessions PHP
2. ✅ **Requêtes préparées** : Protection contre les injections SQL (PDO)
3. ✅ **Validation des entrées** : Vérification des données côté serveur
4. ✅ **Protection des routes** : Redirection si non connecté
5. ✅ **Confirmations** : Dialogues de confirmation pour les actions destructives

### Recommandations Supplémentaires :

- [ ] Ajouter une protection CSRF (tokens)
- [ ] Limiter l'accès admin à certains utilisateurs (ajouter un champ `is_admin`)
- [ ] Logger toutes les actions admin (audit trail)
- [ ] Ajouter une authentification à deux facteurs (2FA)

## Structure des Tables

### Table `promotions`
```sql
- id (auto_increment)
- promotion_id (unique)
- title
- message
- target_audience (enum: 'all','inactive','loyal','new')
- start_date
- end_date
- discount_percentage
- is_active (1 = active, 0 = inactive)
- deleted_at (NULL = non supprimé, TIMESTAMP = supprimé)
- created_at
- updated_at
```

### Table `promotion_notifications`
```sql
- id
- promotion_id (FK vers promotions.id)
- user_id (FK vers users.id)
- sent_at
- fcm_response
- success
- error_message
```

## Gestion de l'Intégrité Référentielle

### Pourquoi le Soft Delete ?

La table `promotion_notifications` fait référence à `promotions.id`. Si vous supprimez une promotion avec `DELETE`, cela peut causer :

1. ❌ **Erreur de clé étrangère** si des notifications existent
2. ❌ **Perte d'historique** des notifications envoyées
3. ❌ **Impossibilité de tracer** quelle promotion a été envoyée

### Solution : Soft Delete

Avec le soft delete :
- ✅ Les promotions ne sont jamais vraiment supprimées (par défaut)
- ✅ Les références dans `promotion_notifications` restent valides
- ✅ L'historique complet est préservé
- ✅ Possibilité de restaurer si erreur

### Suppression Permanente (Si nécessaire)

Si vous devez vraiment supprimer une promotion :

**Option 1 : Via l'interface admin**
1. Allez dans "Deleted Promotions"
2. Cliquez sur "Permanent Delete"
3. Confirmez l'action

**Option 2 : Ajouter une contrainte CASCADE**
```sql
ALTER TABLE promotion_notifications
ADD CONSTRAINT fk_promotion_notifications_promotion
FOREIGN KEY (promotion_id)
REFERENCES promotions(id)
ON DELETE CASCADE
ON UPDATE CASCADE;
```

Cela supprimera automatiquement les notifications associées lors de la suppression permanente.

## Workflow Recommandé

### 1. Création d'une Promotion
```
Créer → Activer → Envoyer aux utilisateurs
```

### 2. Désactivation d'une Promotion
```
Toggle "Deactivate" → La promotion n'est plus envoyée
```

### 3. Suppression d'une Promotion
```
Delete → Soft Delete (restaurable) → Si nécessaire : Permanent Delete
```

### 4. Restauration d'une Promotion
```
Aller dans "Deleted Promotions" → Restore → Modifier si nécessaire → Activer
```

## Statistiques

Le dashboard affiche en temps réel :
- Nombre total de promotions (non supprimées)
- Promotions actives
- Promotions inactives
- Promotions supprimées (soft delete)

## Support

Pour toute question ou problème :
- Vérifiez d'abord que la migration SQL a été exécutée
- Consultez les logs d'erreur PHP
- Vérifiez les permissions de la base de données

## Notes Importantes

⚠️ **IMPORTANT** :
- Toujours faire un backup avant une suppression permanente
- Les promotions supprimées (soft delete) ne sont pas envoyées aux utilisateurs
- Le soft delete désactive automatiquement la promotion (`is_active = 0`)
- Les filtres par défaut n'affichent que les promotions non supprimées
