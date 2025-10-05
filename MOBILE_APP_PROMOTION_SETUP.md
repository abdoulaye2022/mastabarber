# MastaBaber Mobile App Promotion - Setup Instructions

## Images Required

Pour que la promotion de l'application mobile fonctionne correctement, vous devez ajouter les images suivantes dans le dossier `public/assets/img/`:

### 1. Badges App Store & Google Play

#### App Store Badge
- **Nom du fichier:** `app-store-badge.png`
- **Emplacement:** `public/assets/img/app-store-badge.png`
- **Téléchargement:** https://developer.apple.com/app-store/marketing/guidelines/#downloadable-materials
- **Recommandé:** Téléchargez le badge "Download on the App Store" en noir (Black)
- **Dimensions recommandées:** 135 x 40 pixels (ou multiples)

#### Google Play Badge
- **Nom du fichier:** `google-play-badge.png`
- **Emplacement:** `public/assets/img/google-play-badge.png`
- **Téléchargement:** https://play.google.com/intl/en_us/badges/
- **Recommandé:** Badge "Get it on Google Play" en anglais
- **Dimensions recommandées:** 135 x 40 pixels (ou multiples)

### 2. Mockup de l'Application Mobile

#### App Mockup (optionnel mais recommandé)
- **Nom du fichier:** `app-mockup.png`
- **Emplacement:** `public/assets/img/app-mockup.png`
- **Description:** Image d'un iPhone/smartphone affichant votre application
- **Options:**
  1. Créer un mockup avec vos screenshots: https://mockuphone.com/ ou https://smartmockups.com/
  2. Ou simplement un screenshot de l'app avec fond transparent
- **Dimensions recommandées:** 400-600px de largeur, format PNG avec transparence

## Emplacements de Promotion Ajoutés

### 1. Bannière Promotionnelle (En haut)
- **Emplacement:** En haut de toutes les pages
- **Couleur:** Fond sombre (#333) avec texte blanc
- **Message:** "NEW! Download the MastaBaber app for easier bookings"
- **Action:** Lien vers la section mobile app

### 2. Section Mobile App Dédiée
- **Emplacement:** Page d'accueil, entre "About" et "Services"
- **ID:** `#mobile-app`
- **Contenu:**
  - Titre: "Book Appointments Anytime, Anywhere"
  - 4 points clés de l'application
  - Badges App Store & Google Play
  - Mockup de l'application
- **Design:** Fond dégradé doré (#c79e56 → #a67c52)

### 3. Footer
- **Emplacement:** 3ème colonne du footer (remplace la galerie)
- **Contenu:**
  - Titre: "Download Our App"
  - Description courte
  - Badges App Store & Google Play
  - Note: "Android coming soon"
  - Section "Follow Us" avec réseaux sociaux

## Instructions de Téléchargement Rapide

### Pour App Store Badge:
```bash
# Option 1: Téléchargement direct
curl -o public/assets/img/app-store-badge.png https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg

# Ou visitez: https://developer.apple.com/app-store/marketing/guidelines/
```

### Pour Google Play Badge:
```bash
# Visitez: https://play.google.com/intl/en_us/badges/
# Sélectionnez "English" et téléchargez le PNG
```

### Pour le Mockup:
1. Allez sur https://mockuphone.com/
2. Uploadez un screenshot de votre app
3. Choisissez "iPhone 14 Pro" ou similaire
4. Téléchargez l'image générée

## Alternative: Images Temporaires

Si vous voulez tester rapidement sans les vraies images, vous pouvez utiliser des placeholders:

```bash
# Créer des placeholders temporaires (à remplacer plus tard)
mkdir -p public/assets/img

# Les badges officiels peuvent être téléchargés depuis les liens ci-dessus
```

## URLs de l'Application

- **iOS (Disponible):** https://apps.apple.com/app/mastabarber/id6752813029
- **Android (En test):** https://play.google.com/store/apps/details?id=com.m2atech.mastabarber

## Vérification

Après avoir ajouté les images, vérifiez que:
1. ✅ La bannière s'affiche en haut de la page
2. ✅ La section mobile app s'affiche correctement avec les badges
3. ✅ Le footer affiche les badges de téléchargement
4. ✅ Tous les liens pointent vers les bonnes URLs
5. ✅ Les images se chargent correctement (pas de 404)

## Support

Si vous avez besoin d'aide pour créer les images ou le mockup, contactez votre designer ou utilisez les outils en ligne mentionnés ci-dessus.
