# Application Symfony - Gestion de Boutique

Une application web moderne de gestion de boutique développée avec Symfony, offrant des fonctionnalités de gestion des produits, des utilisateurs et un système de points de fidélité.

## 🚀 Fonctionnalités

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

## 🛠️ Technologies Utilisées

- PHP 8.2+
- Symfony 6.4+
- MySQL/MariaDB
- Bootstrap 5
- Bootstrap Icons
- JavaScript
- API Platform

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- MySQL/MariaDB
- Node.js et npm (pour les assets)
- Serveur web (Apache/Nginx)

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

4. Configurer les variables d'environnement
```bash
# Copier le fichier .env
cp .env .env.local

# Modifier les variables dans .env.local
# DATABASE_URL="mysql://user:password@127.0.0.1:3306/db_name?serverVersion=8.0"
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

## 🔐 Sécurité

- Authentification sécurisée avec Symfony Security
- Protection CSRF sur tous les formulaires
- Validation des données
- Gestion des rôles utilisateurs
- Hachage des mots de passe

## 🎨 Interface Utilisateur

- Design moderne et responsive
- Animations fluides
- Thème personnalisable
- Support des icônes Bootstrap
- Messages flash stylisés

## 📝 Routes Principales

- `/` - Page d'accueil
- `/login` - Connexion
- `/register` - Inscription
- `/profile` - Profil utilisateur
- `/admin` - Interface d'administration
- `/admin/users` - Gestion des utilisateurs
- `/admin/produit` - Gestion des produits

## 🤝 Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Auteur

[Votre Nom]

## 📞 Support

Pour toute question ou problème, veuillez ouvrir une issue sur le repository.