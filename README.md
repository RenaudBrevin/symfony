# Application Symfony - Gestion de Boutique 

## Projet d'école

Une application web moderne de gestion de boutique développée avec Symfony, offrant des fonctionnalités de gestion des produits, des utilisateurs et un système de points de fidélité.

## Features

### Pour les Utilisateurs
- Inscription et connexion sécurisées
- Profil utilisateur personnalisable
- Système de points de fidélité
- Notifications en temps réel
- Interface utilisateur moderne et responsive

### Pour les Administrateurs
- Gestion complète des produits (CRUD)
- Gestion des utilisateurs
- Tableau de bord administratif
- Statistiques de la boutique
- Système de notifications


## 🔧 Installation

1. Cloner le repository
```bash
git clone [URL_DU_REPO]
cd symfony
```

2. Installer les dépendances PHP
```bash
composer install
```

3. Configurer la base de données
```bash
# Créer la base de données
php bin/console doctrine:database:create

# Créer les tables
php bin/console doctrine:migrations:migrate

# Charger les données de test
php bin/console doctrine:fixtures:load
```

5. Démarrer le serveur de développement
```bash
symfony server:start
```

## 👥 Comptes de Test

### Administrateur
- Email: admin@admin.com
- Mot de passe: password

### Utilisateur
- Email: user@user.com
- Mot de passe: password

## 📁 Structure du Projet

```
src/
├── Controller/      # Contrôleurs de l'application
├── Entity/         # Entités Doctrine
├── Form/           # Formulaires Symfony
├── Repository/     # Repositories Doctrine
├── Service/        # Services métier
├── Message/        # Messages pour le système de messagerie
├── MessageHandler/ # Gestionnaires de messages
└── EventListener/  # Écouteurs d'événements
```
