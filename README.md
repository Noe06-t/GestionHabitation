# Gestion Habitation

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)

Application web de gestion des habitants et de leurs certificats d'habitation, développée avec Laravel 12 et Bootstrap 5.

## 📋 Table des matières

- [Description](#-description)
- [Fonctionnalités](#-fonctionnalités)
- [Technologies utilisées](#-technologies-utilisées)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Structure du projet](#-structure-du-projet)
- [Utilisation](#-utilisation)
- [Rôles et permissions](#-rôles-et-permissions)
- [Routes disponibles](#-routes-disponibles)
- [Base de données](#-base-de-données)
- [Commandes utiles](#-commandes-utiles)
- [Dépannage](#-dépannage)

## 📖 Description

**Gestion Habitation** est une application web moderne permettant de gérer efficacement les informations des habitants d'un quartier ou d'une commune ainsi que leurs certificats d'habitation. L'application offre une interface intuitive avec un système d'authentification sécurisé.

## ✨ Fonctionnalités

### Gestion des Habitants
- ✅ Ajouter un nouvel habitant (nom, prénom, email, téléphone, date de naissance, quartier)
- ✅ Modifier les informations d'un habitant existant
- ✅ Supprimer un habitant
- ✅ Afficher la liste complète des habitants
- ✅ Interface responsive avec tableaux modernes

### Gestion des Certificats
- ✅ Créer des certificats d'habitation pour les habitants
- ✅ Modifier les certificats existants
- ✅ Supprimer des certificats
- ✅ Associer un certificat à un habitant spécifique
- ✅ Visualiser tous les certificats émis

### Authentification et Sécurité
- ✅ Système d'inscription et de connexion (Laravel Breeze)
- ✅ Protection des routes avec middleware d'authentification
- ✅ Gestion des rôles (Admin uniquement pour la gestion)
- ✅ Déconnexion sécurisée
- ✅ Middleware AdminMiddleware personnalisé

### Interface Utilisateur
- ✅ Design moderne et professionnel avec Bootstrap 5
- ✅ Interface responsive (mobile, tablette, desktop)
- ✅ Navigation intuitive entre Habitants et Certificats
- ✅ Messages de confirmation et d'alerte
- ✅ Polices Google Fonts (Poppins)
- ✅ Icônes Bootstrap Icons
- ✅ Palette de couleurs professionnelle

## 🛠 Technologies utilisées

### Backend
- **Laravel 12** - Framework PHP moderne
- **PHP 8.2+** - Langage de programmation
- **MySQL 8.0** - Base de données relationnelle

### Frontend
- **Bootstrap 5.3.2** - Framework CSS
- **Blade** - Moteur de templates Laravel
- **JavaScript** - Interactions dynamiques
- **Bootstrap Icons 1.11** - Bibliothèque d'icônes
- **Google Fonts (Poppins)** - Typographie

### Authentification
- **Laravel Breeze 2.3** - Scaffolding d'authentification

### Autres dépendances
- **PayDunya 1.0** - Intégration de paiement
- **Laravel Tinker** - REPL pour Laravel
- **Faker** - Génération de données de test
- **PHPUnit 11.5** - Tests unitaires

## 📦 Prérequis

Avant d'installer l'application, assurez-vous d'avoir :

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 8.0 ou **MariaDB** >= 10.3
- **Node.js** >= 18.0
- **NPM** ou **Yarn**

### Extensions PHP requises
```
- PDO
- MySQL
- OpenSSL
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
```

## 🚀 Installation

### 1. Cloner ou télécharger le projet

```bash
git clone <url-du-repo>
cd GestionHabitation
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Créer le fichier de configuration

```bash
copy .env.example .env
```

### 5. Générer la clé d'application

```bash
php artisan key:generate
```

### 6. Créer la base de données

```sql
CREATE DATABASE gestion_habitation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Exécuter les migrations

```bash
php artisan migrate
```

### 8. Compiler les assets

```bash
npm run build
```

Pour le développement :
```bash
npm run dev
```

### 9. Lancer le serveur

```bash
php artisan serve
```

L'application sera accessible à : **http://localhost:8000**

## ⚙️ Configuration

### Variables d'environnement (.env)

#### Application
```env
APP_NAME="Gestion Habitation"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Langue de l'application
APP_LOCALE=fr
APP_FALLBACK_LOCALE=fr
APP_FAKER_LOCALE=fr_FR
```

#### Base de données
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_habitation
DB_USERNAME=root
DB_PASSWORD=
```

**⚠️ Important :** 
- Créez d'abord la base de données `gestion_habitation`
- Modifiez `DB_USERNAME` et `DB_PASSWORD` selon votre configuration MySQL

#### Sessions et Cache
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
```

#### Sécurité
```env
BCRYPT_ROUNDS=12
```

## 📁 Structure du projet

```
GestionHabitation/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Authentification
│   │   │   ├── CertificatController.php # Gestion certificats
│   │   │   └── HabitantController.php   # Gestion habitants
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php      # Protection admin
│   │   └── Requests/
│   └── Models/
│       ├── User.php                     # Modèle utilisateur
│       ├── Habitant.php                 # Modèle habitant
│       └── Certificat.php               # Modèle certificat
├── bootstrap/
│   └── app.php                          # Configuration middlewares
├── database/
│   └── migrations/
│       ├── 2026_02_11_140406_create_habitants_table.php
│       ├── 2026_02_11_140614_create_certificats_table.php
│       └── 2026_02_11_170251_add_role_to_users_table.php
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       │   └── main.blade.php           # Layout principal
│       ├── habitants/                   # Vues habitants
│       ├── certificats/                 # Vues certificats
│       ├── auth/                        # Vues authentification
│       └── welcome.blade.php            # Page d'accueil
├── routes/
│   ├── web.php                          # Routes principales
│   └── auth.php                         # Routes authentification
├── .env                                 # Configuration
├── composer.json                        # Dépendances PHP
└── package.json                         # Dépendances JS
```

## 📚 Utilisation

### 1. Créer un compte administrateur

**Option 1 - Via la base de données :**
```sql
UPDATE users SET role = 'admin' WHERE email = 'votre_email@example.com';
```

**Option 2 - Via Tinker :**
```bash
php artisan tinker
>>> $user = User::where('email', 'votre_email@example.com')->first();
>>> $user->role = 'admin';
>>> $user->save();
```

### 2. Se connecter

1. Accédez à `http://localhost:8000`
2. Cliquez sur "Se connecter"
3. Entrez vos identifiants
4. Redirection automatique vers `/habitants`

### 3. Gérer les habitants

**Ajouter :**
- Menu Habitants → "Ajouter un habitant"
- Remplir tous les champs requis
- Cliquer sur "Enregistrer"

**Modifier :**
- Cliquer sur "Modifier" dans la liste
- Modifier les informations
- Sauvegarder

**Supprimer :**
- Cliquer sur "Supprimer"
- Confirmer

### 4. Gérer les certificats

**Créer :**
- Menu Certificats → "Ajouter un certificat"
- Sélectionner la date et l'habitant
- Enregistrer

**Navigation rapide :**
- Bouton "Certificats" depuis Habitants
- Bouton "Habitants" depuis Certificats

## 🔐 Rôles et permissions

### Rôle Admin
- Accès complet à toutes les fonctionnalités
- CRUD Habitants et Certificats

### Middlewares
- **auth** : Utilisateur connecté
- **admin** : Utilisateur avec rôle 'admin'

Les routes `habitants.*` et `certificats.*` sont protégées par ces middlewares.

## 🛣 Routes disponibles

### Publiques
```
GET  /              # Page d'accueil
GET  /login         # Connexion
POST /login         # Traitement connexion
GET  /register      # Inscription
POST /register      # Traitement inscription
```

### Protégées (Auth + Admin)
```
# Habitants
GET     /habitants              # Liste
GET     /habitants/create       # Formulaire ajout
POST    /habitants              # Enregistrer
GET     /habitants/{id}/edit    # Formulaire modification
PUT     /habitants/{id}         # Mettre à jour
DELETE  /habitants/{id}         # Supprimer

# Certificats
GET     /certificats            # Liste
GET     /certificats/create     # Formulaire ajout
POST    /certificats            # Enregistrer
GET     /certificats/{id}/edit  # Formulaire modification
PUT     /certificats/{id}       # Mettre à jour
DELETE  /certificats/{id}       # Supprimer
```

## 💾 Base de données

### Table : users
| Colonne          | Type         | Description           |
|------------------|--------------|-----------------------|
| id               | bigint       | ID unique             |
| name             | varchar(255) | Nom utilisateur       |
| email            | varchar(255) | Email (unique)        |
| password         | varchar(255) | Mot de passe hashé    |
| role             | varchar(50)  | Rôle (admin/user)     |
| created_at       | timestamp    | Date création         |

### Table : habitants
| Colonne         | Type         | Description           |
|-----------------|--------------|-----------------------|
| id              | bigint       | ID unique             |
| nom             | varchar(255) | Nom de famille        |
| prenom          | varchar(255) | Prénom                |
| email           | varchar(255) | Email                 |
| telephone       | varchar(20)  | Téléphone             |
| date_naissance  | date         | Date de naissance     |
| quartier        | varchar(255) | Quartier              |

### Table : certificats
| Colonne          | Type      | Description              |
|------------------|-----------|--------------------------|
| id               | bigint    | ID unique                |
| date_certificat  | date      | Date émission            |
| habitant_id      | bigint    | ID habitant (FK)         |

**Relations :**
- certificat → habitant (belongsTo)
- habitant → certificats (hasMany)

## 🎨 Palette de couleurs

```css
--primary-color: #2563EB      /* Bleu principal */
--primary-dark: #1E40AF       /* Bleu foncé */
--success-color: #059669      /* Vert */
--warning-color: #F59E0B      /* Orange */
--danger-color: #DC2626       /* Rouge */
--background-color: #F8FAFC   /* Gris clair */
--text-color: #1E293B         /* Gris foncé */
```

## 💻 Commandes utiles

```bash
# Cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Routes
php artisan route:list

# Base de données
php artisan migrate
php artisan migrate:fresh
php artisan migrate:rollback
php artisan db:seed

# Tinker
php artisan tinker

# Générer
php artisan make:controller NomController
php artisan make:model NomModel -m
php artisan make:migration create_nom_table
```

## 🔧 Dépannage

### Erreur de connexion MySQL
```bash
# Vérifier que MySQL est démarré
# Vérifier les paramètres dans .env
```

### CSRF token mismatch
```bash
php artisan cache:clear
php artisan config:clear
```

### Class not found
```bash
composer dump-autoload
php artisan clear-compiled
```

### Permissions (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 📝 Licence

MIT License

## 👨‍💻 Auteur

Développé dans le cadre du cours de **Développement Web** - Licence 3 GLAR S5  
**Enseignant :** M. Gaye

---

**Version** : 1.0.0  
**Date** : Février 2026  
**Framework** : Laravel 12  
**PHP** : 8.2+
